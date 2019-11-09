<?php
include("connection.php");

$params = $_REQUEST;
$action = isset($params['action']) && $params['action'] !='' ? $params['action'] : '';
$dataNew = new Data();
 
switch($action) {
 case 'add':
    $dataNew->insertData($params['data']);
 break;
 case 'delete':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dataNew->deleteData($id);
 break;
 case 'get_data':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dataNew->getSingleData($id);
 break;
 case 'edit':
	$dataNew->updateData($params['data']);
 break;
 default:
 return;
}

class Data {
	protected $conn;
	protected $data = array();
	function __construct() {

		$db = new dbObj();
		$connString =  $db->getConnstring();
		$this->conn = $connString;
	}
	
	public function getData() {
		$sql = "SELECT * FROM motivos_es_gt";
		$queryRecords = pg_query($this->conn, $sql) or die("error to fetch data");
		$data = pg_fetch_all($queryRecords);
		return $data;
    }

    public function getSingleData($id) {
        $sql = "SELECT * FROM motivos_es_gt Where motivo=".$id;
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch data");
        $data = pg_fetch_object($queryRecords);
        echo json_encode($data);
    }
    
    public function insertData($params) {
        $data = $resp = array();
        $resp['status'] = false;
        //$data['motivo'] = $params['lastID'];
        $data['des_motivo'] = $params[2]['value'];
		$data['estado'] = $params[3]['value'];
		$data['tipo'] = $params[4]['value'];
        $result = pg_insert($this->conn, "motivos_es_gt", $data) or die("error to insert data");
        
        $resp['status'] = true;
        $resp['Record'] = $data;
        echo json_encode($resp);  // send data as json format*/
    }

    public function deleteData($id) {
        $sql = "Delete FROM motivos_es_gt Where motivo=".$id;
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch data");
        if($queryRecords) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function updateData($params) {
		$data = $resp = array();
        $resp['status'] = false;
        $data['motivo'] = $params[1]['value'];
		$data['des_motivo'] = $params[2]['value'];
		$data['estado'] = $params[3]['value'];
		$data['tipo'] = $params[4]['value'];
		
		$result = pg_update($this->conn, 'motivos_es_gt' , $data, array('motivo' => $data['motivo'])) or die("error to update data");
		
        $resp['status'] = true;
        $resp['Record'] = $data;
        echo json_encode($resp);  // send data as json format*/
	}
}
?>