<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Option;

class WeeklyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $option = Option::where('name', 'week_user')->first();
        $option->value = (int) $option->value + 1;
        $option->save();
        return 0;
    }
}
