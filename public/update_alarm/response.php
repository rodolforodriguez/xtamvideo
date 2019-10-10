
<?php
	$params = $_REQUEST;
    $action = isset($params['action']) != '' ? $params['action'] : '';
	include_once("../includes/connection.php");
	
	
	
    mysqli_set_charset($con, 'utf8');
    $empCls = new AlamState($con);

    switch($action) {
        case 'edit':
            $empCls->updateAlamState($params);
        break;
        default:
            $empCls->getAlamStates($params);
        return;
	}
	

class AlamState {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	public function getAlamStates($params) {
		$this->data = $this->getRecords($params);
		echo json_encode($this->data);
	}
	function getRecords($x) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : -1;
        $page = isset($params['current']) ? $params['current'] : 1;

		$start_from = ($page-1) * $rp;
		$sql = $sqlRec = $sqlTot = $where = '';

	    if(!empty($params['searchPhrase']) ) {
			$where .=" AND ( barrio LIKE '%".$params['searchPhrase']."%' ";
			$where .=" OR direccion LIKE '%".$params['searchPhrase']."%' ";
			$where .=" OR codcaso LIKE '%".$params['searchPhrase']."%' ";
			$where .=" OR numllamada LIKE '%".$params['searchPhrase']."%' ";
			$where .=" OR estado LIKE '%".$params['searchPhrase']."%' ";
			$where .=" OR fecha LIKE '%".$params['searchPhrase']."%' ";
			$where .=" OR descripcion_caso LIKE '%".$params['searchPhrase']."%' )";
	   }

	    if( !empty($params['sort']) ) {
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
        }

		$sql = "SELECT n.id,n.numllamada,a.longitud,a.latitud,concat(a.firstname,' ',a.secundname,' ',a.lastname1,' ',a.lastname2) as nombre,
					concat(a.tipo_iden,' ',a.ident) as iden, a.municipio,a.barrio,a.direreccion,td.name,a.celular,n.descripcion_caso,n.estado 
						FROM cms_notifications n inner join abonados a on a.id=n.idabonado
							inner join tipo_dispositivo td on td.id = a.id_dispositivoalarm
								WHERE estado <> 'C'";
		$sqlTot .= $sql;
        $sqlRec .= $sql;

		if(isset($where) && $where != '') {
			$sqlTot .= $where;
			$sqlRec .= $where;
		}

		if ($rp!=-1)
			$sqlRec .= " LIMIT ". $start_from .",".$rp;

		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot prealert data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch prealert data");

		while( $row = mysqli_fetch_assoc($queryRecords) ) {
			$data[] = $row;
        }

		$json_data = array(
			"current" => $page,
			"rowCount" =>  intval($queryRecords->num_rows),
			"total" => intval($qtot->num_rows),
			"rows" => $data
			);

		return $json_data;
	}

	
	function updateAlamState($params) {
		require __DIR__.'/../../vendor/autoload.php';
    	$data = array();
		$sql = "Update `cms_notifications` set `estado` = '" . $params["estado"] . "', `descripcion_caso`= '" . $params["descripcion_caso"] . "' WHERE `id` = '".$params["id"]."'";
		$query="SELECT n.id,n.numllamada,a.longitud,a.latitud,a.municipio,a.barrio,a.direreccion
		FROM cms_notifications n inner join abonados a on a.id=n.idabonado
			inner join tipo_dispositivo td on td.id = a.id_dispositivoalarm
				WHERE n.id =".$params["id"];
		$queryAbonados = mysqli_query($this->conn, $query) or die("error to fetch prealert data");				
		$rowAbon = mysqli_fetch_assoc($queryAbonados);
		$sqllog="INSERT INTO `alarm_event` (`id_cmsnotification`, `state`, `detail`) VALUES ('".$params["id"]."','". $params["estado"] ."', '" . $params["descripcion_caso"] . "');";
		mysqli_query($this->conn, $sqllog) or die("error to fetch prealert data");


		
		///Evento de notificacion de alarma
		$app_id = '549538';
		$app_key = '14b51ac8b3104243bfac';
		$app_secret = '0feece4c505377396bc9';
		$app_cluster = 'us2';

		$pusher = new Pusher\Pusher( $app_key, $app_secret, $app_id, array( 'cluster' => $app_cluster, 'encrypted' => true ) );

		$array['codigo'] = $rowAbon["numllamada"];
		$array['estado'] = $params["estado"];
		$array['municipio'] = $rowAbon["municipio"];
		$array['direccion'] = $rowAbon["direreccion"];
		$array['barrio'] = $rowAbon["barrio"];
		$array['longitud'] = $rowAbon["longitud"];
		$array['latitud'] = $rowAbon["latitud"];
		$array['descripcion_caso'] = $params["descripcion_caso"];
		$array['fecha'] = "";

		$pusher->trigger('channelDemoEvent', 'App\Events\eventTrigger', $array);

		///Fin Evento de notificacion de alarma

		echo $result = mysqli_query($this->conn, $sql) or die("Error al actualizar el estado de la alarma.");

		
	}
}
?>
