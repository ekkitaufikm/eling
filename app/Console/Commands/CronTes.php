<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CronTes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing log';

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
        $now = date('Y-m-d H:i:s');
        DB::update("update produk_hukum SET isDelete = '$now' WHERE fid_status = '1' AND tanggal_usulan <=DATE_SUB(NOW(), INTERVAL 3 HOUR)");
        // \Log::info("Cron is working fine!");
        // DB::table('produk_hukum')
        //         ->where('id', $user->id)
        //         ->update(['active' => true]);
    }
}