<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;


class NocController extends BaseController
{

         /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return csrf_token();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        //identificacion del Xtam remoto
        $ip = $request->input("xtam.Ip");
        $id_cc = "";
        //buscar ip en tabla 
        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id')
        ->where( 'ipserver', $ip)   
        ->get();

        if(count($centro_comercial) == 0)
        {

            $response = "Error: IP consultada no existe en el sistema.";
            return response([Json_encode($response)]); 

        }
        //General Info
        foreach ($centro_comercial as $cc) {
            $id_cc = $cc->id;
        }

        $Host = $request->input("xtam.Host");
        $uptime = $request->input("time");
        $cpu_core = $request->input("cpu.0.Model");
        //CPU 
        $sum_core_used = 0;
        $average_cpu_used = 0;
        $num_cpu_core = count($request->input("cpu"));

        for($i=0;$i<$num_cpu_core; $i++)
        {
            $sum_core_used = $sum_core_used + intval($request->input("cpu." . $i . ".Load"));   
              
        }
        $average_cpu_used = $sum_core_used / $num_cpu_core;
        
        //RAM
        $ram_used = $request->input("memoria.Usada");
        $ram_free = $request->input("memoria.Libre");
        $ram_total= $request->input("memoria.Total");
        $ram_porcent = $request->input("memoria.Porcent");  
        
        //Insert General Info
        $cc_general_info = DB::table('general_info')
        ->select('general_info.id_centrocomercial')
        ->where( 'id_centrocomercial', $id_cc)   
        ->get();

        if(count($cc_general_info) == 0)
        {
            $affected = DB::table('general_info')->insert([
                ['id_centrocomercial' =>$id_cc,
                'server_name' => $Host,
                'cpu_core' =>$cpu_core,
                'cpu_used' =>$average_cpu_used,
                'uptime' =>$uptime,
                'ram_free' =>$ram_free,
                'ram_used' =>$ram_used,
                'ram_size' =>$ram_total
                ]
            ]);
  
            

        }else
        {
            $dtime = new DateTime();
            $dtime->modify('-5 hours');
            $dtime->format('Y-m-d H:i:s');
            $affected = DB::table('general_info')->where('id_centrocomercial',$id_cc)
                ->update(['server_name' => $Host,
                'cpu_core' =>$cpu_core,
                'cpu_used' =>$average_cpu_used,
                'uptime' =>$uptime,
                'ram_free' =>$ram_free,
                'ram_used' =>$ram_used,
                'ram_size' =>$ram_total,
                'last_update' => $dtime,
                ]);

                
        }

        //disk Info
       
        $cc_disk_info = DB::table('disk_info')
        ->select('disk_info.id_centrocomercial')
        ->where( 'id_centrocomercial', $id_cc)   
        ->get();

        $num_disk = count($request->input("disco"));
        $dtime = new DateTime();
        $dtime->modify('-5 hours');
        $dtime->format('Y-m-d H:i:s');

        if(count($cc_disk_info) == 0)
        {
            
            for($i=1;$i<=$num_disk; $i++)
            {
                //return response([Json_encode($affected)]); 
                 $disk_id =  $request->input("disco." . $i . ".ID");
                 $disk_name =  $request->input("disco." . $i . ".Name");
                 $disk_total =  $request->input("disco." . $i . ".Total");
                 $disk_used =  $request->input("disco." . $i . ".Used");
                 $disk_free =  $request->input("disco." . $i . ".Free");
                 $disk_percent =  $request->input("disco." . $i . ".Percent");
                 $disk_mountPoint =  $request->input("disco." . $i . ".MountPoint");

                 $affected = DB::table('disk_info')->insert([
                    ['id_centrocomercial' =>$id_cc,
                    'letter' => $disk_mountPoint,
                    'free' =>$disk_free,
                    'used' =>$disk_used,
                    'size' =>$disk_total,
                    'percent' =>$disk_percent,
                    'name' =>$disk_name
                    ]
                ]);
            
            }

            

        }else
        {
            
            for($i=1;$i<=$num_disk; $i++)
            {
                 $disk_id =  $request->input("disco." . $i . ".ID");
                 $disk_name =  $request->input("disco." . $i . ".Name");
                 $disk_total =  $request->input("disco." . $i . ".Total");
                 $disk_used =  $request->input("disco." . $i . ".Used");
                 $disk_free =  $request->input("disco." . $i . ".Free");
                 $disk_percent =  $request->input("disco." . $i . ".Percent");
                 $disk_mountPoint =  $request->input("disco." . $i . ".MountPoint");

                 $affected = DB::table('disk_info')
                 ->where('id_centrocomercial',$id_cc)
                 ->where('letter',$disk_mountPoint)
                 ->update(['letter' => $disk_mountPoint,
                    'free' =>$disk_free,
                    'used' =>$disk_used,
                    'size' =>$disk_total,
                    'percent' =>$disk_percent,
                    'name' =>$disk_name,
                    'last_update' =>$dtime]);     
            
            }
         
        }

        //Plugins - Process
        $cc_process_info = DB::table('process_info')
        ->select('process_info.id_centrocomercial')
        ->where( 'id_centrocomercial', $id_cc)   
        ->get();

        $num_process = count($request->input("plugin"));

        if(count($cc_process_info) == 0)
        {
            for($i=0;$i<$num_process; $i++)
            {
                $disk_name =  $request->input("plugin." . $i . ".Name");
                $disk_status =  $request->input("plugin." . $i . ".Status");

                $affected = DB::table('process_info')->insert([
                    ['id_centrocomercial' =>$id_cc,
                    'process_name' => $disk_name,
                    'status' =>$disk_status
                    ]
                ]);

            }

        }else
        {
            for($i=0;$i<$num_process; $i++)
            {
                $disk_name =  $request->input("plugin." . $i . ".Name");
                $disk_status =  $request->input("plugin." . $i . ".Status");

                $affected = DB::table('process_info')
                ->where('id_centrocomercial',$id_cc)
                ->where('process_name',$disk_name)
                ->update(['id_centrocomercial' =>$id_cc,
                    'process_name' => $disk_name,
                    'status' =>$disk_status
                    ]);
            }

        }

        //process info 
        return response([Json_encode("OK")]); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
       



?>