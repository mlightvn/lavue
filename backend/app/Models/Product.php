<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Traits\ProductTrait;

class Product extends BaseModel
{
    use HasFactory;
    use ProductTrait;

    protected $fillable = [
        'id',
        'coupon_site_id',
        'category_id',
        'name',
        'market_price',
        'price',
        'promotion_percent',
        'quantity',
        'max_quantity',
        'short_description',
        'description',
        'expired_datetime',

        'logo',
        'logo_behind',
        'thumbnail',
        'thumbnail_behind',
        'logo_paths',
        'thumbnail_paths',
        'slug',

        'position',

        'deleted_at',
    ];

    public function getSummarisedList()
    {
        $list = $this->limit(20)->get();
        return $list;
    }

    public function Category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id', 'id');
    }

    public function Prefecture()
    {
        return $this->belongsTo('App\Model\Prefecture', 'prefecture_code', 'code');
    }

    public function getPriceLabelAttribute(){
        return "&yen;" . number_format($this->price ?? 0);
    }

    public function getMarketPriceLabelAttribute(){
        return "&yen;" . number_format($this->market_price ?? 0);
    }

    public function getPromotionPercentLabelAttribute(){
        return (!is_null($this->promotion_percent) ? ($this->promotion_percent . "%") : "");
    }

    public function getLogosAttribute()
    {
        if($this->logo_paths){
            $logo_paths = $this->logo_paths;
            $images = array_filter(explode("\n", $logo_paths));
        }else{
            $images = [];
        }
        return $images;
    }

    public function getThumbnailsAttribute()
    {
        if($this->thumbnail_paths){
            $thumbnail_paths = $this->thumbnail_paths;
            $thumbnails = array_filter(explode("\n", $thumbnail_paths));
        }else{
            $thumbnails = [];
        }
        return $thumbnails;
    }

    public function getRelatedProductsAttribute()
    {
        return $this->relatedProductsSearch(request())->limit(20)->get();
    }

}
