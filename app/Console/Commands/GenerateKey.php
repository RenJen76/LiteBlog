<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:encryptkey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate aes key and iv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $envFile    = app()->environmentFilePath();
        $key        = Str::random(40);
        $iv         = bin2hex(openssl_random_pseudo_bytes(8));

        if (!file_exists($envFile)) {
            return $this->error('.env files not found');
        }

        if (env("AES_KEY") || env("AES_IV")) {
            return $this->error('key or iv already exists');
        }

        $writeResult = file_put_contents($envFile, 
            str_replace(
                array('AES_KEY=', 'AES_IV='), 
                array('AES_KEY='.$key, 'AES_IV='.$iv), 
                file_get_contents($envFile)
            )
        );

        if (!$writeResult) {
            return $this->error('written failed');
        }

        return $this->info('generate aes key and iv successfully');
        
    }
}
