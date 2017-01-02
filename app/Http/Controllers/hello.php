<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class hello extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function __construct()
	{
	      
	     $this->middleware('auth.wp');
			
	}
	
    public function world()
    {
       
	   return view('hello.world');
    }

   
}
