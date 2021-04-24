<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $request;
    protected $blade_path_pattern;
    protected $model = NULL;
    protected $modelClassName;
    protected $data = NULL;
    protected $title = '';
    protected $upload_folder = NULL;

    public function __construct(Request $request)
    {

        $this->request = $request;

        $this->init();
    }

    protected function init(){
    }

    public function index()
    {
        $blade_path = ($this->blade_path_pattern . "/" ?? "") . "index";

        if($this->modelClassName){
            $this->model = new $this->modelClassName;
            $this->model->fill($this->request->all());
        }

        if(is_null($this->data)){
            $this->data = [];
        }

        $this->data["title"]                = $this->title;
        $this->data["model"]                = $this->model;
        if(isset($this->data["recall_index"]) && ($this->data["recall_index"] === true)){
        }else{
            $this->data["list"]                 = $this->listData();
        }
        $this->data["url_pattern"]          = $this->getUrlPattern();
        $this->data["upload_folder"]        = $this->upload_folder;

        // return view($blade_path, ["data" => $this->data]);
        return Inertia::render($blade_path, ['data' => $this->data]);
    }

    public function listData(){
        return collect();
    }

    public function modelInit($id = NULL)
    {
        if(!$this->modelClassName){
            return abort(404);
        }

        if($id){
            $this->model = $this->modelClassName::findOrFail($id);
        }else{
            $this->model = new $this->modelClassName;
        }

    }

    public function modelSlugInit($slug = NULL)
    {
        if(!$this->modelClassName){
            return abort(404);
        }

        if($slug){
            $this->model = $this->modelClassName::where("slug", $slug)->whereNull("deleted_at")->firstOrFail();
        }else{
            $this->model = new $this->modelClassName;
        }

        return $this->model;
    }

    public function modelSlugAndIdInit($slugAndId = NULL)
    {
        if(!$this->modelClassName){
            return abort(404);
        }

        $arr = explode("-", $slugAndId);
        $id = end($arr);

        if($id){
            $this->model = $this->modelClassName::findOrFail($id);
        }else{
            $this->model = new $this->modelClassName;
        }

        return $this->model;

    }

    public function show($id)
    {
        $this->modelInit($id);

        $this->request->merge(["id" => $id]);

        $blade_path = ($this->blade_path_pattern . "/" ?? "") . "show";

        if(is_null($this->data)){
            $this->data = [];
        }

        $this->data["title"]                = $this->title;
        $this->data["model"]                = $this->model;
        $this->data["url_pattern"]          = $this->getUrlPattern();

        return Inertia::render($blade_path, array_merge($this->data, ["data"=>$this->data]));
    }

    public function showSlug($slug)
    {
        $model = $this->modelSlugInit($slug);
        return $this->show($model->id);
    }

    public function showSlugAndId($slugAndId)
    {
        $model = $this->modelSlugAndIdInit($slugAndId);
        return $this->show($model->id);
    }

    public function create()
    {
        $blade_path = ($this->blade_path_pattern . "/" ?? "") . "edit";
        $this->data["url_pattern"]          = $this->getUrlPattern();

        $this->modelInit();
        $this->data["title"]                = $this->title;
        $this->data["model"]                = $this->model;
        $this->data["url_pattern"]          = $this->getUrlPattern();

        return Inertia::render($blade_path, $this->data);
    }

    public function store(Request $request)
    {
        $this->modelInit();
        $this->model->fill($request->all());
        $this->model->save();

        return redirect($this->getUrlPattern());
    }

    public function edit($id)
    {
        $this->modelInit($id);

        $this->request->merge(["id" => $id]);

        $this->data["title"]                = $this->title;
        $this->data["model"]                = $this->model;
        $this->data["url_pattern"]          = $this->getUrlPattern();

        $blade_path = ($this->blade_path_pattern . "/" ?? "") . "edit";
        return Inertia::render($blade_path, $this->data);
    }

    public function update(Request $request, $id)
    {
        $this->modelInit($id);
        $this->model->fill($request->all());
        $this->model->update();

        return redirect($this->getUrlPattern());
    }

    public function editImage($id)
    {
        $this->modelInit($id);

        $this->request->merge(["id" => $id]);

        $this->data["title"]                = $this->title;
        $this->data["model"]                = $this->model;
        $this->data["url_pattern"]          = $this->getUrlPattern();
        $this->data["upload_folder"]            = $this->upload_folder;

        $blade_path = ($this->blade_path_pattern . "/" ?? "") . "edit_image";
        return Inertia::render($blade_path, $this->data);
    }

    public function updateImage(Request $request, $id)
    {
        $this->modelInit($id);
        $this->model->fill($request->all());

        $path                   = 'public' . ($this->upload_folder ?? '/images/products');

        if($request->hasFile('logo')){
            $extension              = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore        = 'logo_' . $this->model->id_label . '.' . $extension;
            $full_path              = public_path() . '/\.\./' . $path . "/" . $fileNameToStore;

            if(file_exists($full_path)){
                unlink($full_path);
            }

            try{
                $request->file('logo')->storeAs($path, $fileNameToStore);
            }catch(Exception $ex){
                dd($ex->message);
            }

            $this->model->logo      = $fileNameToStore;
        }

        if($request->hasFile('thumbnail')){
            $extension                      = $request->file('thumbnail')->getClientOriginalExtension();
            $fileNameToStore                = 'thumbnail_' . $this->model->id_label . '.' . $extension;
            $full_path                      = public_path() . '/\.\./' . $path . "/" . $fileNameToStore;
            if(file_exists($full_path)){
                unlink($full_path);
            }
            $request->file('thumbnail')->storeAs($path, $fileNameToStore);

            $this->model->thumbnail         = $fileNameToStore;
        }

        $this->model->update();

        return redirect(url()->full());
    }

    public function getUrlPattern()
    {
        return "/" . str_replace(".", "/", $this->blade_path_pattern);
    }

    public function destroy($id)
    {
        $this->modelClassName::findOrFail($id)->delete();
        return redirect($this->getUrlPattern());
    }

    public function recover($id)
    {
        $this->modelClassName::findOrFail($id)->update(['deleted_at' => NULL]);
        return redirect($this->getUrlPattern());
    }

}
