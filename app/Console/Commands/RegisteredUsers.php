<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Report\BudgetReport;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class RegisteredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email of registered users';

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
     $new=  new BudgetReport();
        $new->create_report_budget();
    }
}
