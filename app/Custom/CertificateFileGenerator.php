<?php

namespace App\Custom;

use PDF;
use App\HealthCertificate;
use Illuminate\Support\Facades\Storage;

class CertificateFileGenerator
{
	protected $health_certificate;

	public function __construct(HealthCertificate $health_certificate)
	{
		$this->health_certificate = $health_certificate;
	}

	public function getHealthCertificateFolder(HealthCertificate $health_certificate = null)
	{
		if($health_certificate == null)
			$health_certificate = $this->health_certificate;

		$applicant = $health_certificate->applicant;
		$middle_name = $applicant->middle_name != null ? '_' . snake_case($applicant->middle_name) . '_' : "_";
		$suffix = $applicant->suffix_name != null ? strtolower("_{$applicant->suffix_name}") : "";
		
		$applicant_folder = $applicant->applicant_id . '_' . snake_case("{$applicant->first_name}") . $middle_name . snake_case($applicant->last_name) . str_replace('.', '', $suffix);
		
		$health_certificate_id = $health_certificate->health_certificate_id;
		$reg_number = $health_certificate->registration_number;
		$timestamp = $health_certificate->created_at->toDateString();

		$certificate_folder = $health_certificate_id . '_' . $reg_number . '_' . $timestamp;

		return [
			'applicant_folder' => $applicant_folder,
			'certificate_folder' => $certificate_folder,
			'certificate_folder_path' => storage_path("app\\certificates\\$applicant_folder\\$certificate_folder\\"),
			'certificate_file_path' => storage_path("app\\certificates\\$applicant_folder\\$certificate_folder\\certificate.pdf")
		];
	}

	public function generatePDF()
	{
		PDF::loadView('health_certificate.certificate_for_pdf', [
				'picture_path' => $this->getPicturePathAndURL()['path'],
				'health_certificate' => $this->health_certificate
			])->setOption('margin-left', 0.2)->setOption('margin-top', 0.2)->save($this->getHealthCertificateFolder()['certificate_file_path']);
	}

	public function updatePDF(HealthCertificate $old_health_certificate = null)
	{
		$path = $this->getHealthCertificateFolder();

		if($old_health_certificate != null && $old_health_certificate->registration_number != $this->health_certificate->registration_number)
		{
			$old_path = $this->getHealthCertificateFolder($old_health_certificate);

			//test these two lines of code if the delete is needed or not after the move
			Storage::move("certificates\\{$old_path['applicant_folder']}\\{$old_path['certificate_folder']}", "certificates\\{$path['applicant_folder']}\\{$path['certificate_folder']}");
			//Storage::deleteDirectory("certificates\\{$old_path['applicant_folder']}\\{$old_path['certificate_folder']}");
		}

		Storage::delete("certificates\\{$path['applicant_folder']}\\{$path['certificate_folder']}\\certificate.pdf");
		$this->generatePDF();
	}

	public function updateApplicantfolder($old_applicant_folder)
	{
		$applicant_folder = $this->getHealthCertificateFolder()['applicant_folder'];

		Storage::move("certificates\\$old_applicant_folder", "certificates\\$applicant_folder");
		$this->updatePDF();
	}

	public function getPicturePathAndURL($generate_paths_skip_exist_check = false)
	{
		$certificate_path = $this->getHealthCertificateFolder();

		if($generate_paths_skip_exist_check)
			return [
					'path' => $certificate_path['certificate_folder_path'] . 'picture.png',
					'url' => url("health_certificate/{$this->health_certificate->health_certificate_id}/picture")
				];

		if(Storage::exists("certificates\\{$certificate_path['applicant_folder']}\\{$certificate_path['certificate_folder']}\\picture.png"))
			return [
					'path' => $certificate_path['certificate_folder_path'] . 'picture.png',
					'url' => url("health_certificate/{$this->health_certificate->health_certificate_id}/picture")
				];
		else
			return ['path' => null, 'url' => null];
	}
}

?>