
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

		$sql = "SELECT * FROM cms_notifications WHERE estado <> 'C' ";
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
    	$data = array();
		$sql = "Update `cms_notifications` set `estado` = '" . $params["estado"] . "' WHERE `id` = '".$params["id"]."'";
		echo $result = mysqli_query($this->conn, $sql) or die("Error al actualizar el estado de la alarma.");
	}
}
?>
