<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class HashGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'script:hash {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a hash for a given password
';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $password = $this->argument('password');
        if(empty($password)) {
            $this->error('please provide a password');
            return;
        }
        $hashedPassword = Hash::make($password);

        $this->info('Original password: ' . $password);
        $this->info('Hashed password: ' . $hashedPassword);

        if (Hash::check($password, $hashedPassword)) {
            $this->info('Hash verification successful!');
        }

    }
}
