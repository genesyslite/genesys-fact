<?php

namespace GenesysLite\GenesysFact\Commands;

use GenesysLite\GenesysFact\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command User Create';

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
     * @return int
     */
    public function handle()
    {
        $user = User::create([
            'name' => "demo",
            'email' => "demo@gmail.com",
            'password' => bcrypt('secret'),
            'api_token' => Str::random(50),
            'establishment_id' => 1

        ]);
        $this->info('User Create.');
        $this->info('token => '.$user->api_token);
    }
}
