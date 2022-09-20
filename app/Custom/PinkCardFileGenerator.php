<?php

namespace App\Custom;

use PDF;
use App\PinkHealthCertificate;
use Illuminate\Support\Facades\Storage;

//duplicated the code from the file generator for health certificate and sanitary permit
//didn't copied the functions for PDF as it is not feasible to implement
//too complicated (and may cause unforeseen problems) to make abstractions for the file generator classes so I decided the easier way of duplicating things
class PinkCardFileGenerator
{
	protected $pink_health_certificate;

	public function __construct(PinkHealthCertificate $pink_health_certificate)
	{
		$this->pink_health_certificate = $pink_health_certificate;
	}

	public function getPinkHealthCertificateFolder()
	{
		$applicant = $this->pink_health_certificate->applicant;
		$middle_name = $applicant->middle_name != null ? '_' . snake_case($applicant->middle_name) . '_' : "_";
		$suffix = $applicant->suffix_name != null ? strtolower("_{$applicant->suffix_name}") : "";
		
		$applicant_folder = $applicant->applicant_id . '_' . snake_case("{$applicant->first_name}") . $middle_name . snake_case($applicant->last_name) . str_replace('.', '', $suffix);

		return [
			'applicant_folder' => $applicant_folder,
			'pink_card_folder_path' => storage_path("app\\pink_cards\\$applicant_folder\\")
		];
	}

	public function updateApplicantfolder($old_applicant_folder)
	{
		$applicant_folder = $this->getPinkHealthCertificateFolder()['applicant_folder'];

		Storage::move("pink_cards\\$old_applicant_folder", "pink_cards\\$applicant_folder");
	}

	public function getPicturePathAndURL($generate_paths_skip_exist_check = false)
	{
		$certificate_path = $this->getPinkHealthCertificateFolder();

		if($generate_paths_skip_exist_check)
			return [
					'path' => $certificate_path['pink_card_folder_path'] . 'picture.png',
					'url' => url("pink_card/{$this->pink_health_certificate->pink_health_certificate_id}/picture")
				];

		if(Storage::exists("certificates\\{$certificate_path['applicant_folder']}\\picture.png"))
			return [
					'path' => $certificate_path['pink_card_folder_path'] . 'picture.png',
					'url' => url("pink_card/{$this->pink_health_certificate->pink_health_certificate_id}/picture")
				];
		else
			return ['path' => null, 'url' => null];
	}
}

?>