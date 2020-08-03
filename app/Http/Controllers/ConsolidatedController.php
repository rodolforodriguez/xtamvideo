<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use CRUDBooster;
use DB;

class ConsolidatedController extends BaseController
{
    /**
     * Método de carga de la vista.
     */
    public function index()
    {
        // Params
        /*
        $initialDate = $_POST['start'];
        $endDate = $_POST['end'];
        $endDate = $_POST['cc_id'];
        $userid = CRUDBooster::myId();
        */

        // KPIS
        $totalSites = DB::table('centro_comercial')->count();
        $totalSitesOff = 0; // DB::table('centro_comercial')->count();
        $totalIntegrated = DB::table('cameras')->count();
        $totalCamerasOff = DB::table('cameras')->where("cameras.estado","=", "inactive")->count();
        $totalRecording = DB::table('cameras')->where("cameras.estado","=", "active")->count();
        $totalRecordingOff = DB::table('cameras')->where("cameras.estado","=", "inactive")->count();
        $centro_comercial = DB::table('centro_comercial')->select( 'centro_comercial.id',  'centro_comercial.descripcion')->get();

        return view('consolidated.index',
        ['centro_comercial' => $centro_comercial,
         'id' => $userid,
         'totalSites' => $totalSites,
         'totalIntegrated' => $totalIntegrated,
         'totalRecording' => $totalRecording,
         'totalSitesOff' => $totalSitesOff,
         'totalCamerasOff' => $totalCamerasOff,
         'totalRecordingOff' => $totalRecordingOff
         ]);
    }
    /**
     * Obtiene el log de canales por centro comercial
     *
     * @return \Illuminate\Http\Response
     **/
    public function GetLogChannels()
    {
        $userid = CRUDBooster::myId();

        $rtsp_log = DB::table('rtsp_log')
        ->join('centro_comercial','centro_comercial.ipserver','=','rtsp_log.ip_remote')
        ->select(
            'rtsp_log.id_log',
            'rtsp_log.name_channel',
            'rtsp_log.ip_remote',
            'rtsp_log.status',
            'rtsp_log.datecreated',
            'rtsp_log.datefinish',
            'centro_comercial.descripcion')
        ->get();

        return response([Json_encode($rtsp_log)]);
    }
    /**
     * Obtiene el log de canales por centro comercial
     *
     * @param  datetime  $start
     * @param  datetime  $end
     * @return \Illuminate\Http\Response
     **/
    public function GetLogChannelsByDates( $start = null, $end = null)
    {
        $userid = CRUDBooster::myId();

        $rtsp_log = DB::table('rtsp_log')
        ->join('centro_comercial','centro_comercial.ipserver','=','rtsp_log.ip_remote')
        ->select(
            'rtsp_log.id_log',
            'rtsp_log.name_channel',
            'rtsp_log.ip_remote',
            'rtsp_log.status',
            'rtsp_log.datecreated',
            'rtsp_log.datefinish',
            'centro_comercial.descripcion')
        ->whereDate('rtsp_log.datefinish','>=',$start->from)
        ->whereDate('rtsp_log.datefinish','<=',$end->to)
        ->get();

        return response([
            Json_encode($rtsp_log),
            'initialDate' => $start,
            'endDate' => $end]);
    }
}
