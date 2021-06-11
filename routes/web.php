<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['get', 'post'], 'login', 'AuthenticationController@login')->name('login')->middleware('guest');

Route::group(['middleware' => 'auth'], function(){
	//creates a new health certiicate
	Route::match(['get', 'post'], '/', 'HealthCertificateController@createHealthCertificate');

	//adds another health certificate to an existing applicant
	Route::match(['get', 'post'], 'health_certificate/existing_applicant', 'HealthCertificateController@createHealthCertificateExistingApplicant');

	//views and edits a health certificate
	Route::match(['get', 'put'], 'health_certificate/renew', 'HealthCertificateController@renewCertificate');

	//views and edits a health certificate
	Route::match(['get', 'put'], 'health_certificate/{health_certificate}', 'HealthCertificateController@viewEditCertificate');

	//deletes a health certificate
	Route::delete('health_certificate/{health_certificate}', 'HealthCertificateController@deleteCertificate');

	//shows the preview of the health certificate and the take picture feature
	Route::get('health_certificate/{health_certificate}/preview', 'HealthCertificateController@printPreview');

	//ajax for saving the image
	Route::post('health_certificate/{health_certificate}/picture', 'HealthCertificateController@savePicture');

	//shows applicant's id picture
	Route::get('health_certificate/{health_certificate}/picture', 'HealthCertificateController@showPicture');

	//shows health certificate list
	//Route::get('health_certificate', 'HealthCertificateController@getHealthCertificates');

	//show bulk print preview
	//Route::get('health_certificate/bulk_print_preview', 'HealthCertificateController@bulkPrintPreview');
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//shows applicant list
	Route::get('applicants', 'ApplicantController@getApplicants');

	//view or edit an applicant
	Route::match(['get', 'put'], 'applicant/{applicant}', 'ApplicantController@viewEditApplicant');

	//returns applicants that match the search word in create health certificate and sanitary permit page's whole name field
	Route::get('applicant_search', 'ApplicantController@searchApplicantsForCertificateOrPermitForm');

	//searches applicants
	Route::get('search', 'ApplicantController@searchApplicants');

	//bulk-print health certificates
	//Route::match(['get', 'post'], 'applicant/bulk_print', 'ApplicantController@bulkPrintCertificates');
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	Route::match(['get', 'post'], 'sanitary_permit', 'SanitaryPermitController@createSanitaryPermit');
	
	Route::match(['get', 'post'], 'sanitary_permit/existing', 'SanitaryPermitController@createSanitaryPermitExistingApplicantBusiness');

	Route::match(['get', 'put'], 'sanitary_permit/{sanitary_permit}', 'SanitaryPermitController@viewEditSanitaryPermit');

	Route::delete('sanitary_permit/{sanitary_permit}', 'SanitaryPermitController@deletePermit');

	Route::get('sanitary_permit/{sanitary_permit}/preview', 'SanitaryPermitController@printPreview');
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//shows business list
	Route::get('businesses', 'BusinessController@getBusinesses');

	//returns businesses that match the search word in create sanitary permit page's whole name field
	Route::get('business_search', 'BusinessController@searchBusinessesForPermitForm');

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//user administration
	Route::group(['middleware' => 'can:is-admin'], function(){
		Route::match(['get', 'post'], 'users', 'UserController@getOrCreateUser');

		Route::match(['get', 'put', 'delete'], 'users/{user}', 'UserController@editOrDeleteUser');

		//Route::match(['get', 'put'], 'health_certificate_values', 'HealthCertificateController@showEditCertificateValues');
	});

	//logs out the user
	Route::post('logout', 'AuthenticationController@logout');
});