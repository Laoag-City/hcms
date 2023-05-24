<?php

namespace App\Custom;

use App\DocumentCategory;
use App\Statistic;
use App\Year;

trait StatisticsTrait
{
	public function recordToStatistic($category, $add = true, $custom_year = null)
	{
		if($category != null)
		{
			$category_id = DocumentCategory::where('category', $category)->first()->document_category_id;

			$year = new Year;

			if($custom_year == null)
	        	$year_id = $year->getCurrentYear()->year_id;
	        else
	        	$year_id = $year->getYear($custom_year)->year_id;

	        (new Statistic)->recordOne($category_id, $year_id, $add);
		}
	}
}

?>