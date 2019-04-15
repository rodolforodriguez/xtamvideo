<?php
namespace App\Http\Controllers;

use DB;
use Session;
use Request;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class CBHook extends Controller
{

	/*
	| --------------------------------------
	| Please note that you should re-login to see the session work
	| --------------------------------------
	|
	*/
	public function afterLogin()
	{
		$Login = DB::table('xtam_profile_inst')
			->select('Profile_StatusChek')
			->where('Profile_StatusChek', '=', '1')
			->get();
		$tamaño = sizeof($Login);

		if ($tamaño === 0) {
			$to = '../admin/Perfil_de_instancia';
			$message = 'No se ha seleccionado un perfil de instancia';

			CRUDBooster::redirect(
				$to,
				$message
			);
		}
	}
}
