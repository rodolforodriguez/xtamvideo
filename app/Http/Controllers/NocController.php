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
        
        //Get General Info
        
        $general_info= DB::table('general_info')
        ->where( 'id_centrocomercial', $id)   
        ->get();

        $disk_info= DB::table('disk_info')
        ->where( 'id_centrocomercial', $id)   
        ->get();

        $process_info= DB::table('process_info')
        ->where( 'id_centrocomercial', $id)   
        ->get();

        return response([Json_encode(['general_info' => $general_info , 'disk_info' => $disk_info , 'process_info' => $process_info  ])]); 


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
        /////////////identificacion del Xtam remoto//////////////////
        $ip = $request->input("xtam.Ip");
        $id_cc = "";
        $cc_name = "";
        //buscar ip en tabla 
        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id','centro_comercial.descripcion')
        ->where( 'ipserver', $ip)   
        ->get();

        if(count($centro_comercial) == 0)
        {

            $response = "Error: IP consultada no existe en el sistema.";
            return response([Json_encode($response)]); 

        }

        /////////////////////////////////////////////////////////////////////

        ///////////////////General_info table////////////////////////////////

        //Fecha de actualización
        $dtime = new DateTime();
        $dtime->modify('-5 hours');
        $dtime->format('Y-m-d H:i:s');

        
        //Host
        foreach ($centro_comercial as $cc) {
            $id_cc = $cc->id;
            $cc_name = $cc->descripcion;
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
        
        //existe registros del centro comercial
        $cc_general_info = DB::table('general_info')
        ->select('general_info.id_centrocomercial')
        ->where( 'id_centrocomercial', $id_cc)   
        ->get();

        if(count($cc_general_info) == 0)
        {
            //Se insertan los registros General_info
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
            //Notifications si la memoria supera 90%
            if($average_cpu_used > 90)
            {
                $affected = DB::table('cms_notifications')->insert([
                    ['id_cms_users' =>'3',
                    'content' => 'Xtam Remoto : ' .$cc_name. ' supera 90% de uso en CPU',
                    'url' =>'/admin/dashboard',
                    'is_read' =>'0',
                    'created_at' =>$dtime
                    ]
                ]);

            }

         

        }else
        {
            //Actualizar ultimo registro
            $affected = DB::table('general_info')->where('id_centrocomercial',$id_cc)
                ->update(['server_name' => $Host,
                'cpu_core' =>$cpu_core,
                'cpu_used' =>$average_cpu_used,
                'uptime' =>$uptime,
                'ram_free' =>$ram_free,
                'ram_used' =>$ram_used,
                'ram_size' =>$ram_total,
                'last_update' => $dtime
                ]);

                //Notifications
            if($average_cpu_used > 90)
            {
                $affected = DB::table('cms_notifications')->insert([
                    ['id_cms_users' =>'3',
                    'content' => 'Xtam Remoto : ' .$cc_name. ' supera 90% de uso en CPU',
                    'url' =>'/admin/dashboard',
                    'is_read' =>'0',
                    'created_at' =>$dtime
                    ]
                ]);

            }
               
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

        $free_disk1 = 0;
        $used_disk1 = 0;
        $free_disk2 = 0;
        $used_disk2 = 0;

        if(count($cc_disk_info) == 0)
        {
            
            for($i=1;$i<=$num_disk; $i++)
            {

                //variables que se usan para el remote log
                if($i==1)
                {
                    $free_disk1 = $request->input("disco." . $i . ".Free");
                    $used_disk1 =  $request->input("disco." . $i . ".Used");
                }
                if($i==2)
                {
                    $free_disk2 = $request->input("disco." . $i . ".Free");
                    $used_disk2 =  $request->input("disco." . $i . ".Used");
                }

                //return response([Json_encode($affected)]); 
                 $disk_id =  $request->input("disco." . $i . ".ID");
                 $disk_type =  $request->input("disco." . $i . ".FSType");
                 $disk_name =  $request->input("disco." . $i . ".Name");
                 $disk_total =  $request->input("disco." . $i . ".Total");
                 $disk_used =  $request->input("disco." . $i . ".Used");
                 $disk_free =  $request->input("disco." . $i . ".Free");
                 $disk_percent =  $request->input("disco." . $i . ".Percent");
                 $disk_mountPoint =  $request->input("disco." . $i . ".MountPoint");

                

                 if($disk_total > 81927921664) // si la particion supera las 10gb
                 {
                    $affected = DB::table('disk_info')->insert([
                        ['id_centrocomercial' =>$id_cc,
                        'type' => $disk_type,
                        'letter' => $disk_mountPoint,
                        'free' =>$disk_free,
                        'used' =>$disk_used,
                        'size' =>$disk_total,
                        'percent' =>$disk_percent,
                        'name' =>$disk_name
                        ]
                    ]);
                 }

                 //Notifications
                if($disk_percent > 85)
                {
                    $affected = DB::table('cms_notifications')->insert([
                        ['id_cms_users' =>'3',
                        'content' => 'Xtam Remoto : ' .$cc_name. ' supera 85% en espacio en disco ' .$disk_mountPoint . '',
                        'url' =>'/admin/dashboard',
                        'is_read' =>'0',
                        'created_at' =>$dtime
                        ]
                    ]);
                }
            
            }        

        }else
        {
            
            for($i=1;$i<=$num_disk; $i++)
            {
                //variables que se usan para el remote log
                if($i==1)
                {
                    $free_disk1 = $request->input("disco." . $i . ".Free");
                    $used_disk1 =  $request->input("disco." . $i . ".Used");
                }
                if($i==2)
                {
                    $free_disk2 = $request->input("disco." . $i . ".Free");
                    $used_disk2 =  $request->input("disco." . $i . ".Used");
                }

                 $disk_id =  $request->input("disco." . $i . ".ID");
                 $disk_type =  $request->input("disco." . $i . ".FSType");
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
                    'type' => $disk_type,
                    'free' =>$disk_free,
                    'used' =>$disk_used,
                    'size' =>$disk_total,
                    'percent' =>$disk_percent,
                    'name' =>$disk_name,
                    'last_update' =>$dtime]);   

                    

                    
                      //Notifications
                if($disk_percent > 85)
                {
                    $affected = DB::table('cms_notifications')->insert([
                        ['id_cms_users' =>'3',
                        'content' => 'Xtam Remoto : ' .$cc_name. ' supera 85% en espacio en disco ' .$disk_mountPoint . '',
                        'url' =>'/admin/dashboard',
                        'is_read' =>'0',
                        'created_at' =>$dtime
                        ]
                    ]);
                }
            
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
                $process_name =  $request->input("plugin." . $i . ".Name");
                $process_status =  $request->input("plugin." . $i . ".Status");

                $affected = DB::table('process_info')->insert([
                    ['id_centrocomercial' =>$id_cc,
                    'process_name' => $process_name,
                    'status' =>$process_status
                    ]
                ]);

            }

        }else
        {
            for($i=0;$i<$num_process; $i++)
            {
                $process_name =  $request->input("plugin." . $i . ".Name");
                $process_status =  $request->input("plugin." . $i . ".Status");

                //Plugins - Process
                $process = DB::table('process_info')
                ->select('process_info.id_centrocomercial')
                ->where( 'id_centrocomercial', $id_cc)  
                ->where('process_name',$process_name) 
                ->get();

                if(count($process) == 0)
                {
                    $affected = DB::table('process_info')->insert([
                        ['id_centrocomercial' =>$id_cc,
                        'process_name' => $process_name,
                        'status' =>$process_status
                        ]
                    ]);
                    

                }else
                {
                    $affected = DB::table('process_info')
                    ->where('id_centrocomercial',$id_cc)
                    ->where('process_name',$process_name)
                    ->update(['id_centrocomercial' =>$id_cc,
                        'process_name' => $process_name,
                        'status' =>$process_status
                        ]);


                }     
            }

        }

        //Diferencia entre la ultima actualizacion y la actual 
        $result_lastupdate = DB::table('remote_log')
        ->select('remote_log.last_update')
        ->where( 'id_centrocomercial', $id_cc)   
        ->orderBy('id_log','desc')
        ->limit(1)
        ->get();

        foreach ($result_lastupdate as $row) {
            $last_date = $row->last_update;            
        }

        if($last_date)
        {
            $timeoff =  strtotime($dtime->format('Y-m-d H:i:s')) - strtotime($last_date);
        }
        else
        {
            $timeoff = 0;
        }
     
             
        //echo($timedifference);

        if($timeoff < 120 )
        {
            $timeoff = 0;
        }

        
        //indisponibilidad Xtam - remoto log de registros
        $affected = DB::table('remote_log')->insert([
            ['id_centrocomercial' =>$id_cc,
             'cpu_used' => $average_cpu_used,
             'uptime'   => $uptime,
             'ram_free' => $ram_free,
             'ram_used' => $ram_used,
             'ram_size' => $ram_total,
             'free_disk1' => $free_disk1,
             'used_disk1' => $used_disk1,
             'free_disk2' => $free_disk2,
             'used_disk2' => $used_disk2,
             'time_off' => $timeoff,
             'last_update' => $dtime,
             'only_date' => $dtime->format('Y-m-d')
            ]
        ]);
        
       
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