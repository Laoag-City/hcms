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
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Health Certificate routes

	//creates a new health certiicate
	Route::match(['get', 'post'], '/', 'HealthCertificateController@createHealthCertificate');

	//adds another health certificate to an existing applicant
	//Route::match(['get', 'post'], 'health_certificate/existing_applicant', 'HealthCertificateController@createHealthCertificateExistingApplicant');

	//bulk-print health certificates
	Route::match(['get', 'post', 'delete'], 'health_certificate/bulk_print', 'HealthCertificateController@bulkPrintCertificates');

	//show bulk print preview
	Route::get('health_certificate/bulk_print_preview', 'HealthCertificateController@bulkPrintPreview');

	//clear bulk print ids in session
	Route::post('health_certificate/bulk_print_clear', 'HealthCertificateController@bulkPrintClear');

	//add a single certificate to bulk print list
	Route::post('health_certificate/bulk_print_add', 'HealthCertificateController@bulkPrintAdd');

	//for bulk print page search input
	Route::get('health_certificate/search', 'HealthCertificateController@searchHealthCertificates');

	//renew a health certificate
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

	Route::get('duplicates', 'HealthCertificateController@removeDuplicateCertificates');

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Applicant routes

	//shows applicant list
	Route::get('applicants', 'ApplicantController@getApplicants');

	//view or edit an applicant
	Route::match(['get', 'put'], 'applicant/{applicant}', 'ApplicantController@viewEditApplicant');

	//returns applicants that match the search word in create health certificate and sanitary permit page's whole name field
	Route::get('applicant_search', 'ApplicantController@searchApplicantsForCertificateOrPermitForm');

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Sanitary Permit routes
	
	Route::match(['get', 'post'], 'sanitary_permit', 'SanitaryPermitController@createSanitaryPermit');

	Route::match(['get', 'put'], 'sanitary_permit/renew', 'SanitaryPermitController@renewPermit');

	Route::get('sanitary_permit/list', 'SanitaryPermitController@SanitaryPermitsList');
	
	//Route::match(['get', 'post'], 'sanitary_permit/existing', 'SanitaryPermitController@createSanitaryPermitExistingApplicantBusiness');

	Route::match(['get', 'put'], 'sanitary_permit/{sanitary_permit}', 'SanitaryPermitController@viewEditSanitaryPermit');

	Route::delete('sanitary_permit/{sanitary_permit}', 'SanitaryPermitController@deletePermit');

	Route::get('sanitary_permit/{sanitary_permit}/preview', 'SanitaryPermitController@printPreview');

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Business routes

	//shows business list
	Route::get('businesses', 'BusinessController@getBusinesses');

	//view or edit an applicant
	Route::match(['get', 'put'], 'business/{business}', 'BusinessController@viewEditBusiness');

	//returns businesses that match the search word in create sanitary permit page's whole name field
	Route::get('business_search', 'BusinessController@searchBusinessesForPermitForm');

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////Pink Health Certificate routes

	//add a new pink health certificate
	Route::match(['get', 'post'], 'pink_card', 'PinkHealthCertificateController@addPinkHealthCertificate');

	//renew a pink health certificate
	Route::match(['get', 'put'], 'pink_card/renew', 'PinkHealthCertificateController@renewPinkHealthCertificate');

	//bulk-print pink health certificates
	Route::match(['get', 'post', 'delete'], 'pink_card/bulk_print', 'PinkHealthCertificateController@bulkPrintPinkHealthCertificates');

	//for bulk print page search input
	Route::get('pink_card/search', 'PinkHealthCertificateController@searchPinkHealthCertificates');

	//add a single pink health certificate to bulk print list
	Route::post('pink_card/bulk_print_add', 'PinkHealthCertificateController@bulkPrintAdd');

	//clear bulk print ids in session
	Route::post('pink_card/bulk_print_clear', 'PinkHealthCertificateController@bulkPrintClear');

	//show bulk print preview
	Route::get('pink_card/bulk_print_preview', 'PinkHealthCertificateController@bulkPrintPreview');

	//view and edit a pink health certificate
	Route::match(['get', 'put'], 'pink_card/{pink_health_certificate}', 'PinkHealthCertificateController@viewEditPinkHealthCertificate');

	//delete a pink health certificate
	Route::delete('pink_card/{pink_health_certificate}', 'PinkHealthCertificateController@deletePinkHealthCertificate');

	//shows the preview of the pink health certificate and the take picture feature
	Route::get('pink_card/{pink_health_certificate}/preview', 'PinkHealthCertificateController@printPreview');

	//ajax for saving the image
	Route::post('pink_card/{pink_health_certificate}/picture', 'PinkHealthCertificateController@savePicture');

	//shows applicant's id picture
	Route::get('pink_card/{pink_health_certificate}/picture', 'PinkHealthCertificateController@showPicture');

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//searches applicants
	Route::get('search', 'SearchController@viewSearches');

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Report route

	//show summary of records
	Route::get('reports', 'ReportController');

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//User routes

	//user administration
	Route::group(['middleware' => 'can:is-admin'], function(){
		Route::match(['get', 'post'], 'users', 'UserController@getOrCreateUser');

		Route::match(['get', 'put', 'delete'], 'users/{user}', 'UserController@editOrDeleteUser');

		//Route::match(['get', 'put'], 'health_certificate_values', 'HealthCertificateController@showEditCertificateValues');
	});

	//logs out the user
	Route::post('logout', 'AuthenticationController@logout');
});