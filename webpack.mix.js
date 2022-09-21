let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
	.styles(['resources/assets/css/global_style.css'], 'public/css/global_style.css')

	.styles(['resources/assets/css/create_health_certificate.css'], 'public/css/create_health_certificate.css')

	.styles(['resources/assets/css/print_health_certificate_values_only.css'], 'public/css/print_health_certificate_values_only.css')

	.styles(['resources/assets/css/print_health_certificate.css'], 'public/css/print_health_certificate.css')

	.scripts(['resources/assets/js/custom/authenticated.js'], 'public/js/authenticated.js')

	.scripts(['resources/assets/js/custom/user_administration.js'], 'public/js/user_administration.js')

	.scripts(['resources/assets/js/custom/health_certificate_information.js'], 'public/js/health_certificate_information.js')

	.scripts(['resources/assets/js/custom/pink_health_certificate_information.js'], 'public/js/pink_health_certificate_information.js')

	.scripts(['resources/assets/js/custom/camera.js'], 'public/js/camera.js')

	.scripts(['resources/assets/js/custom/values_only_camera.js'], 'public/js/values_only_camera.js')

	.scripts(['resources/assets/js/custom/create_health_certificate.js'], 'public/js/create_health_certificate.js')

	.scripts(['resources/assets/js/custom/create_pink_health_certificate.js'], 'public/js/create_pink_health_certificate.js')

	.scripts(['resources/assets/js/custom/applicant_information.js'], 'public/js/applicant_information.js')

	.scripts(['resources/assets/js/custom/bulk_print.js'], 'public/js/bulk_print.js')

	.scripts(['resources/assets/js/custom/bulk_print_pink_card.js'], 'public/js/bulk_print_pink_card.js')

	.scripts(['resources/assets/js/custom/renew_health_certificate.js'], 'public/js/renew_health_certificate.js')

	.scripts(['resources/assets/js/custom/renew_pink_health_certificate.js'], 'public/js/renew_pink_health_certificate.js')

	.scripts(['resources/assets/js/custom/new_sanitary_permit.js'], 'public/js/new_sanitary_permit.js')

	.scripts(['resources/assets/js/custom/sanitary_permit_information.js'], 'public/js/sanitary_permit_information.js')

	.scripts(['resources/assets/js/custom/renew_sanitary_permit.js'], 'public/js/renew_sanitary_permit.js')

	.scripts(['resources/assets/js/custom/business_information.js'], 'public/js/business_information.js')

	.scripts(['resources/assets/js/custom/search_results.js'], 'public/js/search_results.js')

	.version();