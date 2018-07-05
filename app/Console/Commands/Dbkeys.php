<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use App\Option;

class Dbkeys extends Command
{
    /**
     * The console command name.
     * php artisan dbkeys --var=DB_DATABASE --key=pixma303
     * @var string
     */
    protected $signature = 'dbkeys {--var=} {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the db mysql keys for the Application';

    /**
     * Execute the console command.
     *
     * @return void
     */
	
    public function __construct()
    {
        parent::__construct();
    }
	
    public function handle()
    {
		$var = $this->option('var');
		$key_value = $this->option('key');
		
        $path = base_path('.env');

        if (file_exists($path)) {
			if(env($var) == null){
				$this->info("No existe");
				$txt = $var."=".$key_value;
				file_put_contents($path, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
			}else{
            file_put_contents($path, str_replace(
                $var.'='.env($var), $var.'='.$key_value, file_get_contents($path)
            ));
			}
        }

		$this->info($var."=".$key_value);
    }

    
}
