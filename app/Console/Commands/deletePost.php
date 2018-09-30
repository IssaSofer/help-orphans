<?php

namespace App\Console\Commands;
use App\Posts;
use Carbon\Carbon;
use Illuminate\Console\Command;

class deletePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dpost:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to delete all post that be close after 1 month';

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
        Posts::where('created_at', '<=', Carbon::now()->subDays(30))->delete();
    }
}
