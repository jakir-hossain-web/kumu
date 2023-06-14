<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    function report(){
        return view('admin.report.report_view');
    }

    function report_download(Request $request){
        print_r($request->all());
    }
}
