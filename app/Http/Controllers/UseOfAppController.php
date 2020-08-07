<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use CRUDBooster;
use DB;
use App\ActionsAudit;

class UseOfAppController extends BaseController
{
    /**
     * Método de carga de la vista.
     */
    public function index()
    {
        // KPIS
        $usersCount = DB::table('actions_audit')->select('actions_audit.user_id')->distinct()->get()->count();
        $remoteInstancesCount = DB::table('actions_audit')->select('actions_audit.ipserver')->distinct()->get()->count();
        $cameraCount = DB::table('actions_audit')->select('actions_audit.camera_id')->distinct()->get()->count();

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
        try {
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
                'centro_comercial.descripcion',
                'centro_comercial.ipserver',
                'actions_audit.name_channel',
                'users.email')
            ->orderBy('actions_audit.action_start_date', 'desc')
            ->get();

            return response([Json_encode($actions_audit)]);
        } catch (\Throwable $th) {
            $result = (object)array( "success" => false, "message" => $th->getMessage());
            return response([Json_encode($th)]);
        }
    }
    /**
     * Asigna el log de canales por centro comercial
     *
     * @return \Illuminate\Http\Response
     **/
    public function SetLogUse(Request $request){
        try {
           $ip =
                DB::table('cameras')
                ->join('centro_comercial','centro_comercial.id','=','cameras.id_centrocomercial')
                ->where('cameras.cameraid','=',   $request->input("camid"))
                ->take(1)->pluck('centro_comercial.ipserver');

            DB::table('actions_audit')->insert([[
                'user_id' => CRUDBooster::myId(),
                'action_start_date' => $request->input("start"),
                'action_end_date' => $request->input("end"),
                'camera_id' =>  $request->input("camid"),
                'state' => $request->input("state"),
                'details' => $request->input("details"),
                'module' => $request->input("module"),
                'ipserver' => $ip[0],
                'name_channel' => $request->input("channel")
            ]]);

            $result = (object)array( "success" => true, "message" => $request->input("camid"));
            return response([Json_encode($result)]);
        } catch (\Throwable $th) {
            $result = (object)array( "success" => false, "message" => $th->getMessage());
            return response([Json_encode($th)]);
        }
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
        ->orderBy('actions_audit.action_start_date', 'desc')
        ->get();

        return response([
            Json_encode($actions_audit),
            'initialDate' => $start,
            'endDate' => $end]);
    }
}
