<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifySendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:send-mail {user : UserId değerini alır.} {--queue} {--tc=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email adresini doğrulamayan kullanıcalara email atan command  (kendi commandrlarımızı oluştuyurmayı deniyorum)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $userID = $this->argument('user');
        // $queue = $this->option('queue');
        // $tc = $this->option('tc');
        // $arguments = $this->arguments();
        // dd($arguments); // toplu hepsini gösterir
        // dd($userID, $queue); // tek tek değerleri çekmek için

        // tablo usulü sorgu oluşturma
        // select * from users
        $usersGenis = User::all()->select('name','email');
        $usersGenis2 = User::all(['name','email']);
        //select name,email from users
        $users = User::query()->select('name','email')->get();
        $this->table(
            ['name', 'email'],
            $users
        );

    }
}