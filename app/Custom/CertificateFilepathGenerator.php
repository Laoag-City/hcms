<?php

namespace App\Custom;

use Illuminate\Support\ViewErrorBag;

class CertificateFilepathGenerator
{

	public function getHealthCertificateFolder($health_certificate)
	{
		$applicant = $health_certificate->applicant;
		$middle_name = $applicant->middle_name != null ? '_' . snake_case($applicant->middle_name) . '_' : "_";
		$suffix = $applicant->suffix_name != null ? strtolower("_{$applicant->suffix_name}") : "";
		
		$user_folder = snake_case($applicant->first_name) . $middle_name . snake_case($applicant->last_name) . $suffix;
		
		$health_certificate_id = $health_certificate->health_certificate_id;
		$reg_number = $health_certificate->registration_number;
		$timestamp = $health_certificate->created_at->toDateString();

		$certificate_folder = snake_case("$health_certificate_id $reg_number $timestamp");

		return [
			'user_folder' => $user_folder,
			'certificate_folder' => $certificate_folder,
			'certificate_folder_path' => storage_path("certificates\\$user_folder\\$certificate_folder")
		];
	}
}

?>