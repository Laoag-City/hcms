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

	public function getHealthCertificateFolder()
	{
		$applicant = $this->health_certificate->applicant;
		$middle_name = $applicant->middle_name != null ? '_' . snake_case($applicant->middle_name) . '_' : "_";
		$suffix = $applicant->suffix_name != null ? strtolower("_{$applicant->suffix_name}") : "";
		
		$applicant_folder = $applicant->applicant_id . '_' . snake_case("{$applicant->first_name}") . $middle_name . snake_case($applicant->last_name) . str_replace('.', '', $suffix);

		return [
			'applicant_folder' => $applicant_folder,
			'certificate_folder_path' => storage_path("app\\certificates\\$applicant_folder\\"),
			'certificate_file_path' => storage_path("app\\certificates\\$applicant_folder\\certificate_{$this->health_certificate->health_certificate_id}.pdf")
		];
	}

	public function generatePDF()
	{
		PDF::loadView('health_certificate.certificate_for_pdf', [
				'logo' => public_path('doh_logo.png'),
				'picture' => $this->getPicturePathAndURL()['path'],
				'health_certificate' => $this->health_certificate,
				'color' => $this->health_certificate->getColor(),
			])->setOption('margin-left', 0.2)->setOption('margin-top', 0.2)->save($this->getHealthCertificateFolder()['certificate_file_path']);
	}

	public function updatePDF()
	{
		$path = $this->getHealthCertificateFolder();

		Storage::delete("certificates\\{$path['applicant_folder']}\\certificate_{$this->health_certificate->health_certificate_id}.pdf");
		$this->generatePDF();
	}

	public function updateApplicantfolder($old_applicant_folder)
	{
		$applicant_folder = $this->getHealthCertificateFolder()['applicant_folder'];

		Storage::move("certificates\\$old_applicant_folder", "certificates\\$applicant_folder");

		/*too expensive a process, update only happens on edit or renew to cut processing overhead
		$this->updatePDF();*/
	}

	public function getPicturePathAndURL($generate_paths_skip_exist_check = false)
	{
		$certificate_path = $this->getHealthCertificateFolder();

		if($generate_paths_skip_exist_check)
			return [
					'path' => $certificate_path['certificate_folder_path'] . 'picture.png',
					'url' => url("health_certificate/{$this->health_certificate->health_certificate_id}/picture")
				];

		if(Storage::exists("certificates\\{$certificate_path['applicant_folder']}\\picture.png"))
			return [
					'path' => $certificate_path['certificate_folder_path'] . 'picture.png',
					'url' => url("health_certificate/{$this->health_certificate->health_certificate_id}/picture")
				];
		else
			return ['path' => null, 'url' => null];
	}
}

?>