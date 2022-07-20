<?php

namespace App\Http\Controllers;

use App\Jobs\UploadCsvJob;
use App\Models\UploadCsv;
use Illuminate\Http\Request;

class UploadCsvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload.upload');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (request()->has('mycsv')) {
            // first ********************
            // return file(request()->mycsv);
            // $data  =  array_map('str_getcsv', file(request()->mycsv));
            // $header = $data[0];
            // // return $data[0];
            // // unset($data[0]);
            // // return $data;
            // foreach ($data as $key => $value) {
            //     $arr_combines = array_combine($header, $value);
            //     UploadCsv::create($arr_combines);
            // }
            // end of first ****************

            // second  upload files using the chunks 
            $data =  file(request()->mycsv);
            $header = $data[0];
            unset($data[0]);

            $chunks = array_chunk($data, 1000);
            foreach ($chunks as $key => $chunk) {
                $name = "/tmp{$key}.csv";
                $path = public_path('tmp');
                file_put_contents($path . $name, $chunk);
            }

            UploadCsvJob::dispatch()->delay(now()->addSeconds(5));
            //end of the second files upload chunk done 

            return redirect()->back()->with('success', "Data Inserted Succesfuly");
        }
    }

    public static function storeData()
    {
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UploadCsv  $uploadCsv
     * @return \Illuminate\Http\Response
     */
    public function show(UploadCsv $uploadCsv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UploadCsv  $uploadCsv
     * @return \Illuminate\Http\Response
     */
    public function edit(UploadCsv $uploadCsv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UploadCsv  $uploadCsv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UploadCsv $uploadCsv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UploadCsv  $uploadCsv
     * @return \Illuminate\Http\Response
     */
    public function destroy(UploadCsv $uploadCsv)
    {
        //
    }
}
