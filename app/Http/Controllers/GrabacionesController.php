<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Auth\Middleware\Authenticate;
use Session;
use CRUDBooster;
use PhpParser\Node\Stmt\Foreach_;

class GrabacionesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function cbInit()
    {
        $this->middleware('auth');

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
        $this->script_js = NULL;


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
        $this->style_css = NULL;



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

        $typecam = DB::table('type_cam')->get();

        $camaras = DB::table('cameras')
            ->join('centro_comercial', 'cameras.id_centrocomercial', '=', 'centro_comercial.id')
            ->join('type_cam', 'cameras.typecam', '=', 'type_cam.id')
            ->join('routerecord', 'routerecord.idcamara', '=', 'cameras.cameraid')
            ->select('cameras.cameraid', 'cameras.folder_record',  'cameras.dcamara', 'type_cam.desc_cam', 'centro_comercial.descripcion', 'routerecord.route', 'centro_comercial.ipserver')
            ->get();
        return view('grabaciones.index',  ['camaras' => $camaras], ['typecam' => $typecam]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
