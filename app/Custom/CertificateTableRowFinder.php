<?php

namespace App\Custom;

trait CertificateTableRowFinder
{
	public function findByRowNumber($model, $row_number, $class_name)
    {
        $model = $model->where('row_number', $row_number)->first();
        return $model == null ? new $class_name : $model;
    }
}

?>