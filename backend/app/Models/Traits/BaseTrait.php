<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait BaseTrait
{
    use SoftDeletes;

    public $timestamps = true;

    public function getIdLabelAttribute(){
        $label = null;
        if($this->id){
            $label = str_pad($this->id, 5, "0", STR_PAD_LEFT);
        }

        return $label;
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function isJoined($query, $table)
    {
        $joins = $query->getQuery()->joins;
        if($joins == null) {
            return false;
        }
        foreach ($joins as $join) {
            if ($join->table == $table) {
                return true;
            }
        }
        return false;
    }

    public function getSlugAttribute(){
        if(!property_exists($this, name)){
            return null;
        }

        $slug = Str::of($this->name)->slug('-');
        return $slug;
    }

    public function getSlug()
    {
        $slug = ($this->slug ?? $this->id ?? NULL);
        return $slug;
    }

    public static function selectBoxArray($value_col_name = 'id', $text_col_name = 'name', $hasEmptyValue = true)
    {
        $result = self::whereNull("deleted_at")->pluck($text_col_name, $value_col_name);
        if($hasEmptyValue){
            $result = [""=>"-----"] + $result->toArray();
        }

        return $result;
    }

    public static function getList($allowDeleted = false)
    {
        if($allowDeleted){
            $result = self::get();
        }else{
            $result = self::whereNull("deleted_at")->get();
        }

        return $result;
    }

}
