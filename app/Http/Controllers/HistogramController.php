<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;

use Session;
use DB;
use CRUDBooster;

class HistogramController extends \crocodicstudio\crudbooster\controllers\CBController
{

    use AuthenticatesUsers;
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cbInit()
    {


        /* 
        | ---------------------------------------------------------------------- 
        | Sub Module
        | ----------------------------------------------------------------------     
        | @label          = Label of action 
        | @path           = Path of sub module
        | @foreign_key 	  = foreign key of sub table/module
        | @button_color   = Bootstrap Class (primary,success,warning,danger)
        | @button_icon    = Font Awesome Class  
        | @parent_columns = Sparate with comma, e.g : name,created_at
        | 
        */
        $this->sub_module = array();


        /* 
        | ---------------------------------------------------------------------- 
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------     
        | @label       = Label of action 
        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
        | @icon        = Font awesome class icon. e.g : fa fa-bars
        | @color 	   = Default is primary. (primary, warning, succecss, info)     
        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
        | 
        */
        $this->addaction = array();


        /* 
        | ---------------------------------------------------------------------- 
        | Add More Button Selected
        | ----------------------------------------------------------------------     
        | @label       = Label of action 
        | @icon 	   = Icon from fontawesome
        | @name 	   = Name of button 
        | Then about the action, you should code at actionButtonSelected method 
        | 
        */
        $this->button_selected = array();


        /* 
        | ---------------------------------------------------------------------- 
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------     
        | @message = Text of message 
        | @type    = warning,success,danger,info        
        | 
        */
        $this->alert        = array();



        /* 
        | ---------------------------------------------------------------------- 
        | Add more button to header button 
        | ----------------------------------------------------------------------     
        | @label = Name of button 
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        | 
        */
        $this->index_button = array();



        /* 
        | ---------------------------------------------------------------------- 
        | Customize Table Row Color
        | ----------------------------------------------------------------------     
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
        | 
        */
        $this->table_row_color = array();


        /*
        | ---------------------------------------------------------------------- 
        | You may use this bellow array to add statistic at dashboard 
        | ---------------------------------------------------------------------- 
        | @label, @count, @icon, @color 
        |
        */
        $this->index_statistic = array();



        /*
        | ---------------------------------------------------------------------- 
        | Add javascript at body 
        | ---------------------------------------------------------------------- 
        | javascript code in the variable 
        | $this->script_js = "function() { ... }";
        |
        */
        $this->script_js = null;


        /*
        | ---------------------------------------------------------------------- 
        | Include HTML Code before index table 
        | ---------------------------------------------------------------------- 
        | html code to display it before index table
        | $this->pre_index_html = "<p>test</p>";
        |
        */
        $this->pre_index_html = null;



        /*
        | ---------------------------------------------------------------------- 
        | Include HTML Code after index table 
        | ---------------------------------------------------------------------- 
        | html code to display it after index table
        | $this->post_index_html = "<p>test</p>";
        |
        */
        $this->post_index_html = null;



        /*
        | ---------------------------------------------------------------------- 
        | Include Javascript File 
        | ---------------------------------------------------------------------- 
        | URL of your javascript each array 
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = array();



        /*
        | ---------------------------------------------------------------------- 
        | Add css style at body 
        | ---------------------------------------------------------------------- 
        | css code in the variable 
        | $this->style_css = ".style{....}";
        |
        */
        $this->style_css = null;



        /*
        | ---------------------------------------------------------------------- 
        | Include css File 
        | ---------------------------------------------------------------------- 
        | URL of your css each array 
        | $this->load_css[] = asset("myfile.css");
        |
        */
        $this->load_css = array();
    }



    public function index()
    {
        
        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id',  'centro_comercial.descripcion')
        ->get();

            return view('histogram.index',  ['centro_comercial' => $centro_comercial]);
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
                ->where('datetimestart', '>', DB::raw('NOW() - INTERVAL 1 '.$time.''))
                ->groupBy('datestart')
                ->get();

                

                $device = [];
                $device ["camara"] = $camara->direccion;
                $device ["data"]   = $secondsRecording;

                array_push($camarasArray,$device);
    
            } else {
                
                $secondsRecording = DB::table('recordings')
                ->select( 'datestart' , DB::raw( 'SUM(TIMESTAMPDIFF(SECOND, datetimestart ,datetimefinish)) AS recorded_second'))
                ->where('idCamara', $camara)              
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByVideo($id , $time)
    {

        
        $camarasArray = array();
        $camaras = DB::table('cameras')
        ->select( 'cameras.cameraid',  'cameras.direccion','cameras.dcamara')
        ->where('id_centrocomercial', $id) 
        ->get();

        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id',  'centro_comercial.descripcion','centro_comercial.ipserver')
        ->where('id' , $id) 
        ->get();

        foreach ($centro_comercial as $cc) {
            $ip_remote = $cc->ipserver;
        
        }

        foreach ($camaras as $camara) {

           


            if (!is_null($time)) {
            
                $secondsRecording = DB::table('rtsp_log')
                ->select( 'name_channel',DB::raw("date_format(datecreated, '%Y-%m-%d') as datestart") , DB::raw( 'if(datefinish <> null,SUM(TIMESTAMPDIFF(SECOND, datecreated ,datefinish)),SUM(TIMESTAMPDIFF(SECOND, datecreated ,now()))) AS recorded_second '))
                ->where('name_channel', '=' , $camara->dcamara) 
                ->where('ip_remote', '=' , $ip_remote) 
                ->where('status', '=' , 'inactive') 
                ->groupBy('datestart','name_channel',  'datefinish')
                ->get();
            
                $device = [];
                $device ["camara"] = $camara->direccion;
                $device ["data"]   = $secondsRecording;

                array_push($camarasArray,$device);
    
            } else {
                
                $secondsRecording = DB::table('rtsp_log')
                ->select( 'name_channel',DB::raw("date_format(datecreated, '%Y-%m-%d') as datestart") , DB::raw( 'if(datefinish <> null,SUM(TIMESTAMPDIFF(SECOND, datecreated ,datefinish)),SUM(TIMESTAMPDIFF(SECOND, datecreated ,now()))) AS recorded_second '))
                ->where('name_channel', '=' , $camara->dcamara) 
                ->where('ip_remote', '=' , $ip_remote) 
                ->where('status', '=' , 'inactive') 
                ->groupBy('datestart','name_channel' , 'datefinish')
                ->get();

                $device = [];
                $device ["camara"] = $camara->direccion;
                $device ["data"]   = $secondsRecording;

                array_push($camarasArray,$device);
    
            }
        }
    
            return response([$camarasArray]);  
       
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByCamaras($id , $time)
    {

        $camarasArray = array();

       

        $camaras = DB::table('cameras')
        ->select( 'cameras.cameraid',  'cameras.direccion','cameras.dcamara')
        ->where('id_centrocomercial', $id) 
        ->get();

        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id',  'centro_comercial.descripcion','centro_comercial.ipserver')
        ->where('id' , $id) 
        ->get();

        foreach ($centro_comercial as $cc) {
            $ip_remote = $cc->ipserver;
        }


        foreach ($camaras as $camara) {

            if (!is_null($time)) {
            
                $secondsRecording = DB::table('rtsp_log')
                ->select( 'name_channel',DB::raw("date_format(datecreated, '%Y-%m-%d') as datestart") , DB::raw( 'if(datefinish <> null,SUM(TIMESTAMPDIFF(SECOND, datecreated ,datefinish)),SUM(TIMESTAMPDIFF(SECOND, datecreated ,now()))) AS recorded_second '))
                ->where('name_channel', '=' , $camara->dcamara) 
                ->where('ip_remote', '=' , $ip_remote) 
                ->where('status', '=' , 'inactive') 
                ->groupBy('datestart','name_channel',  'datefinish')
                ->get();
            
                $device = [];
                $device ["camara"] = $camara->direccion;
                $device ["data"]   = $secondsRecording;

                array_push($camarasArray,$device);
    
            } else {
                
                $secondsRecording = DB::table('rtsp_log')
                ->select( 'name_channel',DB::raw("date_format(datecreated, '%Y-%m-%d') as datestart") , DB::raw( 'if(datefinish <> null,SUM(TIMESTAMPDIFF(SECOND, datecreated ,datefinish)),SUM(TIMESTAMPDIFF(SECOND, datecreated ,now()))) AS recorded_second '))
                ->where('name_channel', '=' , $camara->dcamara) 
                ->where('ip_remote', '=' , $ip_remote) 
                ->where('status', '=' , 'inactive') 
                ->groupBy('datestart','name_channel' , 'datefinish')
                ->get();

                $device = [];
                $device ["camara"] = $camara->direccion;
                $device ["data"]   = $secondsRecording;

                array_push($camarasArray,$device);
    
            }
        }
    
            return response([$camarasArray]);    
       
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showXtamOffline($id , $time)
    {

      
        $centro_comercial = DB::table('centro_comercial')
        ->select( 'centro_comercial.id',  'centro_comercial.descripcion','centro_comercial.ipserver')
        ->where('id' , $id) 
        ->get();

        foreach ($centro_comercial as $cc) {
            $ip_remote = $cc->ipserver;
        }

            if (!is_null($time)) {
            
                $secondsOffline = DB::table('remote_log')
                ->select(DB::raw( 'SUM(time_off) AS seconds') ,'only_date')
                ->where('id_centrocomercial' , $id)  
                ->groupBy('only_date')
                ->get();

                $device = [];
                $device ["ipserver"] = $ip_remote;
                $device ["data"]   = $secondsOffline;
   
                array_push($device);
    
            } else {
                
                $secondsOffline = DB::table('remote_log')
                ->select(DB::raw( 'SUM(time_off) AS seconds') ,'only_date')
                ->where('id_centrocomercial' , $id)  
                ->groupBy('only_date')
                ->get();

                $device = [];
                $device ["ipserver"] = $ip_remote;
                $device ["data"]   = $secondsOffline;
   
                array_push($device);
    
            }
           
            return response([$device]);    
       
    }

    

}


?>