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
        ->select( 'centro_comercial.id',  'centro_comercial.descripcion','centro_comercial.iptunelgre','centro_comercial.ipsimcard','centro_comercial.ipserver')
        ->get();

        return view('dashboard.index',  ['centro_comercial' => $centro_comercial]);
        
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id , $time)
    {

        $camarasArray = array();
        $camaras = DB::table('cameras')
        ->select( 'cameras.cameraid',  'cameras.direccion')
        ->where('id_centrocomercial', $id) 
        ->get();


        foreach ($camaras as $camara) {

            if (!is_null($time)) {
            
                $secondsRecording = DB::table('recordings')
                ->select( 'datestart' , DB::raw( 'SUM(TIMESTAMPDIFF(SECOND, datetimestart ,datetimefinish)) AS recorded_second'))
                ->where('idCamara', $camara->cameraid) 
                ->where('datetimestart', '>', DB::raw('NOW() - INTERVAL 1 '.$time.'',))
                ->groupBy('datestart')
                ->get();

                

                $device = [];
                $device ["camara"] = $camara->direccion;
                $device ["data"]   = $secondsRecording;

                array_push($camarasArray,$device);
    
            }else {
                
                $secondsRecording = DB::table('recordings')
                ->select( 'datestart' , DB::raw( 'SUM(TIMESTAMPDIFF(SECOND, datetimestart ,datetimefinish)) AS recorded_second'))
                ->where('idCamara', $camara->cameraid)              
                ->groupBy('datestart')
                ->get();

                $device = [];
                $device ["camara"] = $camara->direccion;
                $device ["data"]   = $secondsRecording;

                array_push($camarasArray,$device);
    
            }
        }
    
            return response([$camarasArray]);     
    }  
       

}