<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDbooster;

class AdminCmsUsersController extends \crocodicstudio\crudbooster\controllers\CBController
{


	public function cbInit()
	{
		# START CONFIGURATION DO NOT REMOVE THIS LINE 
		$this->table               = 'cms_users';
		$this->primary_key         = 'id';
		$this->title_field         = "name";
		$this->button_action_style = 'button_icon';
		$this->button_import 	   = FALSE;
		$this->button_export 	   = FALSE;
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = array();
		$this->col[] = array("label" => "Nombre", "name" => "name");
		$this->col[] = array("label" => "Correo", "name" => "email");
		$this->col[] = array("label" => "Privilegio", "name" => "id_cms_privileges", "join" => "cms_privileges,name");
		$this->col[] = array("label" => "Foto", "name" => "photo", "image" => 1);
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = array();
		$this->form[] = array("label" => "Nombre", "name" => "name", 'required' => true, 'validation' => 'required|alpha_spaces|min:3');
		$this->form[] = array("label" => "Correo", "name" => "email", 'required' => true, 'type' => 'email', 'validation' => 'required|email|unique:cms_users,email,' . CRUDBooster::getCurrentId());
		$this->form[] = array("label" => "Foto", "name" => "photo", "type" => "upload", "help" => "Resolución recomendada 200x200px", 'required' => true, 'validation' => 'required|image|max:1000', 'resize_width' => 90, 'resize_height' => 90);
		//$this->form[] = array("label" => "Privilegio", "name" => "id_cms_privileges", "type" => "select", "datatable" => "cms_privileges,name", 'required' => true);
		$this->form[] = ['label'=>'Perfil','name'=>'id_cms_privileges','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','dataquery'=>'SELECT cms_privileges.id as value ,cms_privileges.name as label FROM xtam_profile_inst inner join cms_privileges ON cms_privileges.id = xtam_profile_inst.id_privileges where xtam_profile_inst.Profile_StatusChek = 1'];
		$this->form[] = array("label" => "Contraseña", "name" => "password", "type" => "password", "help" => "Por favor, deje vacío si no cambia la contraseña");
		# END FORM DO NOT REMOVE THIS LINE

	}

	public function getProfile()
	{

		$this->button_addmore = FALSE;
		$this->button_cancel  = FALSE;
		$this->button_show    = FALSE;
		$this->button_add     = FALSE;
		$this->button_delete  = FALSE;
		$this->hide_form 	  = ['id_cms_privileges'];

		$data['page_title'] = trans("crudbooster.label_button_profile");
		$data['row']        = CRUDBooster::first('cms_users', CRUDBooster::myId());
		$this->cbView('crudbooster::default.form', $data);
	}
}
