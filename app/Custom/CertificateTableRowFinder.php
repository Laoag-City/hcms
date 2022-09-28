<?php

namespace App\Custom;

//findByRowNumber's logic can be merged inside tabledFieldLooper else statement to be used by edit and renew of health certificate and pink health certificate
//but it would break legacy codes in HealthCertificateController since it uses findByRowNumber.
//Due to time constraint in development, tabledFieldLooper will just call findRowNumber for the sake of adaptability and non-breaking changes in codebase.
trait CertificateTableRowFinder
{
	public function findByRowNumber($models, $row_number, $class_name)
    {
        $model = $models->where('row_number', $row_number)->first();
        return $model == null ? new $class_name : $model;
    }

    public function tabledFieldsLooper($create_new_models, $class_name, $total_rows, $existing_records = null)
    {
        if($create_new_models)
            for($i = 0; $i < $total_rows; $i++)
                $models[$i] = new $class_name;

        else
            for($i = 0; $i < $total_rows; $i++)
                $models[$i] = $this->findByRowNumber($existing_records, $i + 1, $class_name);

        return $models;
    }
}

?>