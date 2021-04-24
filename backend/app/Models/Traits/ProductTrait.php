<?php
namespace App\Models\Traits;

use App\Model\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

trait ProductTrait
{
	/**
	 * Scope a query to only include specific inquiries based on request params.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return  \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeSearch($query, Request $request)
	{
		$product_table_name = self::getTable();

		$query->select([$product_table_name . '.*']);

		if(!is_null($request->id))
		{
			$query->where($product_table_name . '.id', $request->id);
		}

		if(!is_null($request->name))
		{
			$query->where($product_table_name . '.name', 'LIKE', '%' . $request->name . '%');
		}

		if($request->keyword)
		{
			$query->where(function($query) use ($product_table_name, $request)
			{
				$query ->where($product_table_name . '.name' 						, 'LIKE', '%' . $request->keyword . '%')
					 ->orWhere($product_table_name . '.short_description' 			, 'LIKE', '%' . $request->keyword . '%')
					 ->orWhere($product_table_name . '.description' 				, 'LIKE', '%' . $request->keyword . '%')
					 ->orWhere($product_table_name . '.price' 						, 'LIKE', '%' . $request->keyword . '%')
					 ->orWhere($product_table_name . '.market_price' 				, 'LIKE', '%' . $request->keyword . '%')
				;
			});
		}

		if($request->discount)
		{
			if(isset($request->discount["from"])){
				$query->where($product_table_name . '.promotion_percent', '>=', $request->discount["from"]);
			}
			if(isset($request->discount["to"])){
				$query->where($product_table_name . '.promotion_percent', '<=', $request->discount["to"]);
			}
		}

		if($request->category_id){
			$query->where($product_table_name . '.category_id', $request->category_id);
		}

		if($request->category)
		{
			$category_model = new Category();

			$category = $request->category;

			if($request->sub_category)
			{
				$sub_category = $request->sub_category;
				$category_model = $category_model->where("slug", $sub_category);
				$category_model = $category_model->whereNotNull("parent_id");
				$category_model = $category_model->first();
				$query->where($product_table_name . '.category_id', $category_model->id);
			}else{
				$category_id_list = [];

				$category_model = $category_model->where("slug", $category);
				$category_model = $category_model->whereNull("parent_id");
				$category_model = $category_model->first();
				$parent_category_id = $category_model->id;
				$category_id_list[] = $parent_category_id;

				$category_model_list = $category_model->where("parent_id", $parent_category_id)->get();
				$category_model_list = $category_model_list->pluck("id")->toArray();

				$category_id_list = array_merge($category_id_list, $category_model_list);

				$query->whereIn($product_table_name . '.category_id', $category_id_list);
			}

		}

		if($request->prefecture_id)
		{
			$query->where("prefecture_id", $request->prefecture_id);
		}

		if($request->promotion)
		{
			$promotion = $request->promotion;

			switch ($promotion) {
				case 'above_90':
					$query->where($product_table_name . '.promotion_percent', '>=', "90");
					break;

				case '80_90':
					$query->where($product_table_name . '.promotion_percent', '>=', "80");
					$query->where($product_table_name . '.promotion_percent', '<=', "90");
					break;

				case '70_80':
					$query->where($product_table_name . '.promotion_percent', '>=', "70");
					$query->where($product_table_name . '.promotion_percent', '<=', "80");
					break;

				case '50_70':
					$query->where($product_table_name . '.promotion_percent', '>=', "50");
					$query->where($product_table_name . '.promotion_percent', '<=', "70");
					break;

				case '25_50':
					$query->where($product_table_name . '.promotion_percent', '>=', "25");
					$query->where($product_table_name . '.promotion_percent', '<=', "50");
					break;

				case '10_25':
					$query->where($product_table_name . '.promotion_percent', '>=', "10");
					$query->where($product_table_name . '.promotion_percent', '<=', "25");
					break;

				case 'under_10':
					$query->where($product_table_name . '.promotion_percent', '<=', "10");
					break;

				default:
					break;
			}

		}

		if($request->price)
		{
			$price = $request->price;

			if(isset($request->price["from"])){
				$query->where($product_table_name . '.price', '>=', $request->price["from"]);
			}
			if(isset($request->price["to"])){
				$query->where($product_table_name . '.price', '<=', $request->price["to"]);
			}

			$query->where(function($query) use ($price, $product_table_name)
			{
				foreach ($price as $key => $price_value) {
					switch ($price_value) {
						case 'under_1000':
							$query->where($product_table_name . '.price', '<=', 1000);
							break;

						case '1000_5000':
							$query->orWhere(function($query) use ($price, $product_table_name){
								$query->where($product_table_name . '.price', '>=', 1000);
								$query->where($product_table_name . '.price', '<=', 5000);
							});
							break;

						case '5000_10000':
							$query->orWhere(function($query) use ($price, $product_table_name){
								$query->where($product_table_name . '.price', '>=', 5000);
								$query->where($product_table_name . '.price', '<=', 10000);
							});
							break;

						case '10000_50000':
							$query->orWhere(function($query) use ($price, $product_table_name){
								$query->where($product_table_name . '.price', '>=', 10000);
								$query->where($product_table_name . '.price', '<=', 50000);
							});
							break;

						case '50000_100000':
							$query->orWhere(function($query) use ($price, $product_table_name){
								$query->where($product_table_name . '.price', '>=', 50000);
								$query->where($product_table_name . '.price', '<=', 100000);
							});
							break;

						case '100000_200000':
							$query->orWhere(function($query) use ($price, $product_table_name){
								$query->where($product_table_name . '.price', '>=', 10000);
								$query->where($product_table_name . '.price', '<=', 200000);
							});
							break;

						case 'above_200000':
							$query->orWhere($product_table_name . '.price', '>=', 200000);
							break;

						default:
							break;
					}
				}
			});

		}

		if($request->remain_time){
			$remain_time = $request->remain_time;
			switch ($request->remain_time) {
				case 'in_1_hour':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 1 HOUR)'));
					break;

				case 'in_3_hours':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 3 HOUR)'));
					break;

				case 'in_6_hours':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 6 HOUR)'));
					break;

				case 'in_9_hours':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 9 HOUR)'));
					break;

				case 'in_12_hours':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 12 HOUR)'));
					break;

				case 'in_24_hours':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 24 HOUR)'));
					break;

				case 'in_1_week':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 7 DAY)'));
					break;

				case 'in_30_days':
					$query->where($product_table_name . '.expired_datetime', '<=', \DB::raw('DATE_ADD(NOW(), INTERVAL 30 DAY)'));
					break;

				case 'more_than_30_days':
					$query->where($product_table_name . '.expired_datetime', '>=', \DB::raw('DATE_ADD(NOW(), INTERVAL 30 DAY)'));
					break;

				default:
					break;
			}
		}

		$query->whereNull($product_table_name . '.deleted_at');

		$query->orderBy($product_table_name . '.position');
		if($request->sort_by)
		{
			switch ($request->sort_by) {
				case 'price_down':
					$query->orderBy($product_table_name . '.price', 'DESC');
					break;
				case 'price_up':
					$query->orderBy($product_table_name . '.price');
					break;

				default:
					$query->orderBy($product_table_name . '.expired_datetime', 'DESC');
					$query->orderBy($product_table_name . '.price', 'ASC');
					break;
			}
		}

		$query->orderBy($product_table_name . '.category_id', 'DESC')
		;

		return $query;
	}

	public function scopeRelatedProductsSearch($query, Request $request)
	{
		$product_table_name = self::getTable();

		$query->where($product_table_name . '.id', "<>", $this->id);
		$query->where($product_table_name . '.category_id', $this->category_id);

		$query->orderBy($product_table_name . '.position');
		$query->orderBy($product_table_name . '.expired_datetime', 'DESC');
		$query->orderBy($product_table_name . '.price', 'DESC');

		return $query;
	}

}
