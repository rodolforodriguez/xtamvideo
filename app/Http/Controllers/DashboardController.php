<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class DashboardController extends BaseController
{

    public function index()
    {
        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id',  'centro_comercial.descripcion')
        ->get();

        return view('dashboard.index',  ['centro_comercial' => $centro_comercial]);
        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetIpCC($id)
    {

        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id',  'centro_comercial.descripcion','centro_comercial.iptunelgre','centro_comercial.ipsimcard','centro_comercial.ipserver')
        ->where('centro_comercial.id', $id)
        ->get();


        return response([Json_encode($centro_comercial)]);  
      
                
    } 
       

}