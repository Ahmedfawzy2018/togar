<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	public $Successstatus = 200 ;
    public $FailStatus = 500 ;
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
