<?php

namespace App\Custom;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DatabaseBackupper
{
	public function __invoke()
	{
		$folder = 'database_backups';

		if(!Storage::exists($folder))
			Storage::makeDirectory($folder);

		$filename = Carbon::now()->format('Y-m-d_H-i-s') . ".sql";
  
        $command = 'C:\xampp\mysql\bin\mysqldump --user="' . env('DB_USERNAME') .'" --password="' . env('DB_PASSWORD') . '" --host="' . env('DB_HOST') . '" ' . env('DB_DATABASE') . ' --result-file="' . storage_path("app\\$folder\\$filename" . '"');

		exec($command);

		$all_backups = collect(Storage::files($folder));

		if($all_backups->isNotEmpty())
		{
			$year_now = Carbon::now()->format('Y');

			$to_remove = $all_backups->filter(function($value, $key) use($year_now) {
				return !str_contains($value, $year_now);
			});

			foreach($to_remove as $file)
				Storage::delete($file);
		}
	}
}

?>