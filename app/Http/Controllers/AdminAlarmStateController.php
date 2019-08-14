<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use CRUDBooster;
use DateTime;

class AdminAlarmStateController extends \crocodicstudio\crudbooster\controllers\CBController
{
    use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = true;
        $this->button_delete = false;
        $this->button_detail = false;
        $this->button_show = false;
        $this->button_filter = false;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "cms_notifications";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        # `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        # `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        # `barrio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        # `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        # `codcaso` bigint(20) DEFAULT NULL,
        # `numllamada` bigint(20) DEFAULT NULL,
        # `municipio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        # `estado` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'P',
        # `descripcion_caso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        # `fecha` datetime DEFAULT NULL,
        $this->col = [];
        $this->col[] = ["label" => "Nº", "name" => "id"];
        $this->col[] = ["label" => "Barrio", "name" => "barrio"];
        $this->col[] = ["label" => "Dirección", "name" => "direccion"];
        $this->col[] = ["label" => "Código", "name" => "codcaso"];
        $this->col[] = ["label" => "Número llamada", "name" => "numllamada"];
        $this->col[] = ["label" => "Municipio", "name" => "municipio"];
        $this->col[] = ["label" => "Estado", "name" => "estado"];
        $this->col[] = ["label" => "Descripción", "name" => "descripcion_caso"];
        $this->col[] = ["label" => "Fecha", "name" => "fecha"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Nº', 'name' => 'id', 'type' => 'number', 'validation' => 'numeric', 'width' => 'col-sm-10', 'readonly' => 'true'];
        $this->form[] = ['label' => 'Barrio', 'name' => 'barrio', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'disabled' => 'true'];
        $this->form[] = ['label' => 'Dirección', 'name' => 'descripcion_caso', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'disabled' => 'true'];
        $this->form[] = ['label' => 'Código', 'name' => 'descripcion_caso', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'disabled' => 'true'];
        $this->form[] = ['label' => 'Número llamada', 'name' => 'descripcion_caso', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'disabled' => 'true'];
        $this->form[] = ['label' => 'Municipio', 'name' => 'descripcion_caso', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'disabled' => 'true'];
        $this->form[] = ['label' => 'Descripción', 'name' => 'descripcion_caso', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'disabled' => 'true'];
        $this->form[] = ['label' => 'Estado', 'name' => 'Profile_StatusChek', 'type' => 'checkbox', 'validation' => '|min:1|max:1', 'width' => 'col-sm-10', 'dataenum' => '1|'];
        $this->form[] = ['label' => 'Descripción', 'name' => 'Profile_StatusChek', 'type' => 'checkbox', 'validation' => '|min:1|max:1', 'width' => 'col-sm-10', 'dataenum' => '1|'];
        # END FORM DO NOT REMOVE THIS LINE

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
        return view('alarmstate.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

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
        $service =
            DB::table('cms_notifications')
            ->where('id', '=', $request["id"])
            ->update('estado', '=', $request["estado"]);

        return view('alarmstate.index');
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
