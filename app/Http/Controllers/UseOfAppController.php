<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use CRUDBooster;
use DB;

class UseOfAppController extends BaseController
{
    /**
     * Método de carga de la vista.
     */
    public function index()
    {
        // KPIS
        $usersCount = DB::table('actions_audit')->select('actions_audit.user_id')->distinct()->count();
        $remoteInstancesCount = DB::table('actions_audit')->select('actions_audit.ipserver')->distinct()->count();
        $cameraCount = DB::table('actions_audit')->select('actions_audit.ipserver')->distinct()->count();

        return view('use_of_app.index',
        ['remoteInstancesCount' => $remoteInstancesCount,
         'usersCount' => $usersCount,
         'cameraCount' => $cameraCount
         ]);
    }
    /**
     * Obtiene el log de uso de la app
     *
     * @return \Illuminate\Http\Response
     **/
    public function GetLogUse()
    {
        $userid = CRUDBooster::myId();

        $actions_audit = DB::table('actions_audit')
        ->join('centro_comercial','centro_comercial.ipserver','=','actions_audit.ipserver')
        ->join('users','users.id','=','actions_audit.user_id')
        ->join('cameras','cameras.cameraid','=','actions_audit.camera_id')
        ->select(
            'actions_audit.action_start_date',
            'actions_audit.action_end_date',
            'actions_audit.module',
            'actions_audit.details',
            'actions_audit.state',
            'actions_audit.name_channel',
            'users.email')
        ->get();

        return response([Json_encode($actions_audit)]);
    }
    /**
     * Obtiene el log de canales por centro comercial
     *
     * @param  datetime  $start
     * @param  datetime  $end
     * @return \Illuminate\Http\Response
     **/
    public function GetLogUseByDates( $start = null, $end = null)
    {
        $userid = CRUDBooster::myId();

        $actions_audit = DB::table('actions_audit')
        ->join('centro_comercial','centro_comercial.ipserver','=','actions_audit.ipserver')
        ->join('users','users.id','=','actions_audit.user_id')
        ->join('cameras','cameras.cameraid','=','actions_audit.camera_id')
        ->select(
            'actions_audit.action_start_date',
            'actions_audit.action_end_date',
            'actions_audit.module',
            'actions_audit.details',
            'actions_audit.state',
            'actions_audit.name_channel',
            'users.email')
        ->whereDate('actions_audit.action_start_date','>=',$start->from)
        ->whereDate('actions_audit.action_start_date','<=',$end->to)
        ->get();

        return response([
            Json_encode($actions_audit),
            'initialDate' => $start,
            'endDate' => $end]);
    }
}
