<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $run_data = DB::table('produk_hukum')->where('fid_status', '5')->orWhere('fid_status','0')->whereRaw("tanggal_usulan <=DATE_SUB(NOW(), INTERVAL 1 MONTH)")->update(['deleted_at' => date('Y-m-d H:i:s')]);
        $run_data1 = DB::table('produk_hukum')->where('fid_status', '1')->whereRaw("tanggal_usulan <=DATE_SUB(NOW(), INTERVAL 1 WEEK)")->update(['deleted_at' => date('Y-m-d H:i:s')]);
        // $run_data = DB::delete("delete from produk_hukum WHERE fid_status = '1' AND tanggal_usulan <=DATE_SUB(NOW(), INTERVAL 3 HOUR)");
        // $schedule->command($run_data);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}