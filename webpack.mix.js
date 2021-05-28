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

	.styles(['resources/assets/css/camera.css'], 'public/css/camera.css')

	.scripts(['resources/assets/js/custom/authenticated.js'], 'public/js/authenticated.js')

	.scripts(['resources/assets/js/custom/user_administration.js'], 'public/js/user_administration.js')

	.scripts(['resources/assets/js/custom/health_certificate_information.js'], 'public/js/health_certificate_information.js')

	.scripts(['resources/assets/js/custom/camera.js'], 'public/js/camera.js')

	.scripts(['resources/assets/js/custom/values_only_camera.js'], 'public/js/values_only_camera.js')

	.scripts(['resources/assets/js/custom/create_health_certificate.js'], 'public/js/create_health_certificate.js')

	.scripts(['resources/assets/js/custom/applicant_information.js'], 'public/js/applicant_information.js')

	.scripts(['resources/assets/js/custom/bulk_print.js'], 'public/js/bulk_print.js')

	.scripts(['resources/assets/js/custom/renew.js'], 'public/js/renew.js')

	.version();
