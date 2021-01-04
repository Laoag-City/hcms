<?php

namespace App\Custom;

use PDF;
use App\SanitaryPermit;
use Illuminate\Support\Facades\Storage;

class PermitFileGenerator
{
	protected $sanitary_permit;

	public function __construct(SanitaryPermit $sanitary_permit)
	{
		$this->sanitary_permit = $sanitary_permit;
	}

	public function getSanitaryPermitFolder()
	{
		$applicant = $this->sanitary_permit->applicant;
		$middle_name = $applicant->middle_name != null ? '_' . snake_case($applicant->middle_name) . '_' : "_";
		$suffix = $applicant->suffix_name != null ? strtolower("_{$applicant->suffix_name}") : "";
		
		$applicant_folder = $applicant->applicant_id . '_' . snake_case("{$applicant->first_name}") . $middle_name . snake_case($applicant->last_name) . str_replace('.', '', $suffix);

		return [
			'applicant_folder' => $applicant_folder,
			'permit_folder_path' => storage_path("app\\permits\\$applicant_folder\\"),
			'permit_file_path' => storage_path("app\\permits\\$applicant_folder\\permit_{$this->sanitary_permit->sanitary_permit_id}.pdf")
		];
	}

	public function generatePDF($other_file_path = null, $other_permit = null)
	{
		PDF::loadView('sanitary_permit.permit_for_pdf', [
				'logo' => public_path('laoag_logo.png'),
				'permit' => !$other_permit ? $this->sanitary_permit : $other_permit,
		])->setPaper('letter')->setOrientation('portrait')->save(!$other_file_path ? $this->getSanitaryPermitFolder()['permit_file_path'] : $other_file_path);
	}

	public function updatePDF()
	{
		$path = $this->getSanitaryPermitFolder();

		Storage::delete("permits\\{$path['applicant_folder']}\\permit_{$this->sanitary_permit->sanitary_permit_id}.pdf");
		$this->generatePDF();
	}

	public function updateApplicantfolder($old_applicant_folder)
	{
		Storage::deleteDirectory("permits\\$old_applicant_folder");
		
		$applicant = $this->sanitary_permit->applicant;
		$permits = $applicant->sanitary_permits;

		foreach($permits as $permit)
		{
			$file_path = $this->getSanitaryPermitFolder()['permit_folder_path'] . "permit_{$permit->sanitary_permit_id}.pdf";
			$this->generatePDF($file_path, $permit);
		}
	}
}

?>