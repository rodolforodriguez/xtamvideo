<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminCamerasController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id_centrocomercial,dcamara";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "cameras";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Centro Comercial","name"=>"id_centrocomercial","join"=>"centro_comercial,descripcion"];
			$this->col[] = ["label"=>"Dirección","name"=>"direccion"];
			$this->col[] = ["label"=>"Longitud","name"=>"longitud"];
			$this->col[] = ["label"=>"Latitud","name"=>"latitud"];
			$this->col[] = ["label"=>"Descripción","name"=>"dcamara"];
			$this->col[] = ["label"=>"Estado","name"=>"estado"];
			$this->col[] = ["label"=>"Ver cámara","name"=>"vercam"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Sitio central','name'=>'id_centralsites','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'centralsites,name'];
			$this->form[] = ['label'=>'Sitio remoto','name'=>'id_centrocomercial','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'centro_comercial,descripcion'];
			$this->form[] = ['label'=>'Dirección','name'=>'direccion','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Longitud','name'=>'longitud','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Latitud','name'=>'latitud','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tipo de Cámara','name'=>'typecam','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'type_cam,desc_cam'];
			$this->form[] = ['label'=>'Tipo de streaming','name'=>'type_streaming','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataenum'=>'RTMP;RTSP','onclick'=>'flujo();'];
			$this->form[] = ['label'=>'Canal de transmisión','name'=>'dcamara','type'=>'select','validation'=>'min:1|max:255','width'=>'col-sm-10','dataenum'=>'channel1;channel2;channel3;channel4'];
			$this->form[] = ['label'=>'IP de la cámara','name'=>'ipcam','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Url RTSP','name'=>'rtsp_url','type'=>'text','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Carpeta de grabación','name'=>'folder_record','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataenum'=>'camara1;camara2;camara3;camara4'];
			$this->form[] = ['label'=>'Estado','name'=>'estado','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'inactive|Inactiva;active|Activa'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Sitio central','name'=>'id_centralsites','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'centralsites,name'];
			//$this->form[] = ['label'=>'Sitio remoto','name'=>'id_centrocomercial','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'centro_comercial,descripcion'];
			//$this->form[] = ['label'=>'Dirección','name'=>'direccion','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Longitud','name'=>'longitud','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Latitud','name'=>'latitud','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tipo de Cámara','name'=>'typecam','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'type_cam,desc_cam'];
			//$this->form[] = ['label'=>'Tipo de streaming','name'=>'type_streaming','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataenum'=>'RTMP;RTSP'];
			//$this->form[] = ['label'=>'Canal de transmisión','name'=>'dcamara','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'channel1;channel2;channel3;channel4'];
			//$this->form[] = ['label'=>'IP de la cámara','name'=>'ipcam','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Url RTSP','name'=>'rtsp_url','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Carpeta de grabación','name'=>'folder_record','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataenum'=>'camara1;camara2;camara3;camara4'];
			//$this->form[] = ['label'=>'Estado','name'=>'estado','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'inactive|Inactiva;active|Activa'];
			# OLD END FORM

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


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
			//Your code here
			
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
			//Your code here
			//Your code here
			//Your code here+
			$securos=DB::table('cms_settings')
			->select('content')
			->where('name','=','isssecuros')
			->first();
			if($securos->content == 'Si'){

				/*		$cameras= DB::table('centro_comercial')
						->select('ipserver')
						->where('id', '=', $postdata['id_centrocomercial'])
						->first();
						$rtspurl="rtsp://".$cameras->ipserver.":8554/".$postdata['dcamara'];
						$postdata['rtsp_url']=$rtspurl;
						//// funcionalidad ejecutar .bat desde php
						function execInBackground($cmd) { 
							if (substr(php_uname(), 0, 7) == "Windows"){ 
								pclose(popen("start ". $cmd, "r"));
								//echo("entro1");  
							} 
							else { 
								exec($cmd . " > /dev/null &");   
								//echo("entro2");
							} 
						}
						//// fin funcionalidad .bat
						
						///// generacion y ejecucion cmd para convertir rtmp to rtsp
						
						$texto="cd C:/ffmpeg/bin 
						ffmpeg -i rtmp://localhost:1935/".$postdata['dcamara']." -acodec libmp3lame -ar 11025 -f rtsp rtsp://localhost:8554/".$postdata['dcamara'].
						"
						pause";
						$fileconf="ftp://xtam:xtam123456@".$cameras->ipserver."/".$postdata['dcamara'].".bat";

						$fh=fopen($fileconf, 'w') or die("Ocurrio un error al abrir el archivo");
						fwrite($fh, $texto) or die("No se puede escribir en el archivo");
						fclose($fh);
						$BS="\\\\";
						$userxtam=getenv("USER_XTAM");
						$pwdxtam=getenv("PWD_XTAM");
						//// generamos .bat que ejecuta psexec 
						$texto="C:/laragon/www/xtamvideo/public/psexec/psexec ".$BS.$cameras->ipserver." -u ".$userxtam." -p ".$pwdxtam." C:/ffmpeg/bin/".$postdata['dcamara'].".bat";
						mkdir("C:/laragon/www/xtamvideo/public/ISSSecurOS/".$cameras->ipserver, 0700);
						$fileconf="C:/laragon/www/xtamvideo/public/ISSSecurOS/".$cameras->ipserver."/".$postdata['dcamara']."_ps.bat";

						$fh=fopen($fileconf, 'w') or die("Ocurrio un error al abrir el archivo");
						fwrite($fh, $texto) or die("No se puede escribir en el archivo");
						fclose($fh);
						execInBackground($fileconf);
						//$cmd2="C:\laragon\www\xtamvideo\public\psexec\psexec \\192.168.2.7 -u verytel\avallejo -p Colombia2017* C:\ffmpeg\bin\channel1.bat";
						//$cmd2="ftp://xtam:xtam123456@".$cameras->ipserver."/".$postdata['dcamara'].".bat";

						
						//// finalizacion reestructuracion streaming RTSP


						////////////////////

						$streamserver=$postdata['id_streamserver'];
						$counts=DB::table("cameras")->where('id_streamserver',$streamserver);
						$ncam=$counts->count();
						/*if($ncam>=8){
							//$this->alert[] = ["message"=>"Lo siento este servidor de streaming tiene los canales ocupados","type"=>"danger"];
							//CRUDBooster::redirectBack('este servidor tienes sus canales ocupados')->withInput(Input::all());
							echo('unavailable');

							CRUDBooster::redirect(CRUDBooster::mainpath("add"),"Los canales de este Servidor estan ocupados, por favor intenta con otro servidor","danger")->withInput();
							//return redirect()->back()->withInput();
							//redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning'])->withInput();
							//\Session::driver()->save();
							//CRUDBooster::redirect(back(),'Process is successfully done!');
							
						}
			}		*/
		}	
			
			

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
			//Your code here
			$person = DB::table('cameras')->where('cameraid',$id)->first();
			$person->vercam='<a href="http://localhost/xtamvideo/public/vs/streaming.php?ip='.$id.'&state=1&userid=2"><img src="../includes/img/icons8-eye-24.png" /></a>';
			//$person->save();
		/*	$data = array();
			 $data['desc_cam'] = 'testing';
			 DB::table("type_cam")->insert($data);*/

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
			//Your code here
			
			$postdata['vercam']='<a href="http://localhost/xtamvideo/public/vs/streaming.php?ip='.$id.'&state=1&userid=2"><img src="../includes/img/icons8-eye-24.png" /></a>';
			/*
			$cameras= DB::table('centro_comercial')
			->select('ipserver')
			->where('id', '=', $postdata['id_centrocomercial'])
			->first();
			$rtspurl="rtsp://".$cameras->ipserver.":8554/".$postdata['dcamara'];
			$postdata['rtsp_url']=$rtspurl;*/

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 


	}