<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{

	public function init()
	{
		parent::init();

		$this->modelClassName = "\App\Models\Product";
		$this->blade_path_pattern = "Product";
		$this->title = __("screen.product.product");
	}

	public function listData()
	{
		$list = $this->modelClassName::search($this->request)->orderBy("created_at", "DESC")->paginate(20);

		// $list = collect([["id"=>1, "slug"=>"product-1", "name"=>"商品①", "description"=>"Product 1"]]);
		return $list;
	}

	public function toAffiliateSite($id)
	{
		$this->modelInit($id);
		$this->model = $this->model->where('id', $id)->whereNull('deleted_at')->firstOrFail();

		if(!empty($this->model->original_url)){
			return redirect($this->model->original_url);
		}
		abort(404);
	}

	public function getAffiliateSite($coupon_site_slug)
	{
		\App\Model\CouponSite::where("slug", $coupon_site_slug)->whereNull('deleted_at')->firstOrFail();

		$this->request->merge(['coupon_site_slug' => $coupon_site_slug]);
		return view('product.index');
	}

	public function getTodofuken($todofuken)
	{
		$this->request->merge(['todofuken' => $todofuken]);
		return view('product.index');
	}

	public function getPromotion($promotion)
	{
		$this->request->merge(['promotion' => $promotion]);
		return view('product.index');
	}

	public function getPrice($price)
	{
		$this->request->merge(['price' => $price]);
		return view('product.index');
	}

	public function getRemainTime($remain_time)
	{
		$this->request->merge(['remain_time' => $remain_time]);
		return view('product.index');
	}

	public function compare(Request $request)
	{
		return view('product.compare');
	}

}
