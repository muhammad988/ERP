<?php

namespace App\Console\Commands;

use App\Model\Hr\User;
use Illuminate\Console\Command;
use Mail;
use App\Mail\SendMailable;

class WordOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users with a word and its meaning';

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
        $totalUsers = 10;
        Mail::to('krunal@appdividend.com')->send(new SendMailable($totalUsers));
    }
}
