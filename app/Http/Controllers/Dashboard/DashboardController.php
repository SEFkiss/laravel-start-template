<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Toastr;


class DashboardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        // $notification = array(
        //     'message' => 'I am a successful message!', 
        //     'alert-type' => 'success'
        // );
        //Toastr::success('Добро пожаловать','Stocky.studio');
        return view('dashboard.index');
    }

}