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

		$filename = Carbon::now()->format('Y-m-d') . ".sql";
  
        $command = 'C:\xampp\mysql\bin\mysqldump --user="' . env('DB_USERNAME') .'" --password="' . env('DB_PASSWORD') . '" --host="' . env('DB_HOST') . '" ' . env('DB_DATABASE') . ' --result-file="' . storage_path("app\\$folder\\$filename" . '"');

		exec($command);

		$all_backups = collect(Storage::files($folder));

		if($all_backups->isNotEmpty())
		{
			$last_year = (int)Carbon::now()->format('Y') - 1;

			$to_remove = $all_backups->filter(function($value, $key) use($last_year) {
				return str_contains($value, $last_year);
			});

			foreach($to_remove as $file)
				Storage::delete($file);
		}
	}
}

?>