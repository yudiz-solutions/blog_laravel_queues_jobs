<?php

namespace App\Jobs;

use App\Models\UploadCsv;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class UploadCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $timeout = 1200;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $path = public_path('tmp');
        $files = glob("$path/*.csv");
        $header = ["Region", "Country", "Item_Type", "Sales_Channel", "Order_Priority", "Order_Date", "Order_ID", "Ship_Date", "Units_Sold", "Unit_Price", "Unit_Cost", "Total_Revenue", "Total_Cost", "Total_Profit"];
        foreach ($files as $key => $file) {
            $data  =  array_map('str_getcsv', file($file));

            foreach ($data as $sales) {
                $salesData = array_combine($header, $sales);
                UploadCsv::create($salesData);
            }
        }
        unlink($files);
    }

    public function failed(Throwable $exception)
    {

        dd("Job Is Fail" . $exception->getMessage());
    }
    // php artisan queue:retry all
    // php artisan queue:flush



}
