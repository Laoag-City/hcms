<?php

use Illuminate\Database\Seeder;
use App\DocumentType;
use App\DocumentCategory;
use App\HealthCertificate;
use App\SanitaryPermit;
use App\PinkHealthCertificate;

class DocTypesAndCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hc = DocumentType::firstOrCreate(['document_name' => 'Health Certificate']);
        $sp = DocumentType::firstOrCreate(['document_name' => 'Sanitary Permit']);
        $phc = DocumentType::firstOrCreate(['document_name' => 'Pink Health Certificate']);

        foreach(HealthCertificate::CERTIFICATE_TYPES as $key => $type)
            DocumentCategory::firstOrCreate(['category' => $key], ['document_type_id' => $hc->document_type_id]);

        foreach(SanitaryPermit::PERMIT_CLASSIFICATIONS as $type)
            DocumentCategory::firstOrCreate(['category' => $type], ['document_type_id' => $sp->document_type_id]);

        DocumentCategory::firstOrCreate(['category' => PinkHealthCertificate::CERTIFICATE_TYPE], ['document_type_id' => $phc->document_type_id]);
    }
}
