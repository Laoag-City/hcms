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
	//creates a health certiicate
	Route::match(['get', 'post'], '/', 'HealthCertificateController@createHealthCertificate');
	//returns applicants that match the search word in create health certificate page's whole name field
	Route::get('applicant_search', 'ApplicantController@searchApplicantsForHealthCertificate');

	//shows health certificate list
	//Route::get('health_certificate', 'HealthCertificateController@getHealthCertificates');
	//shows the preview of the health certificate and the take picture feature
	Route::get('health_certificate/{health_certificate}/preview', 'HealthCertificateController@printPreview');
	//ahow bulk print preview
	Route::get('health_certificate/bulk_print_preview', 'HealthCertificateController@bulkPrintPreview');
	//ajax for saving the image
	Route::post('health_certificate/{health_certificate}/picture', 'HealthCertificateController@savePicture');
	//shows applicant's id picture
	Route::get('health_certificate/{health_certificate}/picture', 'HealthCertificateController@showPicture');
	//views and edits a health certificate
	Route::match(['get', 'put'], 'health_certificate/{health_certificate}', 'HealthCertificateController@viewEditCertificate');

	//shows applicant list
	Route::get('applicant', 'ApplicantController@getApplicants');
	//bulk-print health certificates
	Route::match(['get', 'post'], 'applicant/bulk_print', 'ApplicantController@bulkPrintCertificates');
	//view or edit an applicant
	Route::match(['get', 'put'], 'applicant/{applicant}', 'ApplicantController@viewEditApplicant');
	
	//searches applicants
	Route::get('search', 'ApplicantController@searchApplicants');

	//user administration
	Route::group(['middleware' => 'can:is-admin'], function(){
		Route::match(['get', 'post'], 'users', 'UserController@getOrCreateUser');
		Route::match(['get', 'put', 'delete'], 'users/{user}', 'UserController@editOrDeleteUser');

		//Route::match(['get', 'put'], 'health_certificate_values', 'HealthCertificateController@showEditCertificateValues');
	});

	//logs out the user
	Route::post('logout', 'AuthenticationController@logout');
});