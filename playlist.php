<?php
$data = json_decode(file_get_contents('php://input'), true);

// $params['module'] = 'user';
	$data['name'] = 'abc';
	$data['email'] = 'abc@gmail.com';
	$data['phone'] = '60112223333';
	$data['method'] = 'create';

foreach ($data as $k => $v) {
	if (empty($v)) {
		echo json_encode(['res'=>"Invalid ".$k." data!",'status'=>'ERROR']);
	}
}

$servername = "127.0.0.1";
$database = "vimi";
$username = "root";
$password = 123;
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) echo json_encode(['res'=>"Connection failed: ".mysqli_connect_error(),'status'=>'ERROR']); 

switch ($data['method']) {
	case 'create':
		$data['created_datetime'] = date('Y-m-d H:i:s');
		$data['updated_datetime'] = date('Y-m-d H:i:s');
		$keys = array_keys($data);
		$vals = array_values($data);
		 
		$sql = "INSERT INTO playlist (" . join(', ', $keys) . ") VALUES ('" . join("', '", $vals) . "')";
		if ($conn->query($sql) === TRUE) {
		      	$sql = "SELECT * FROM playlists ORDER BY id DESC LIMIT 1";

		      	if ($conn->query($sql) === TRUE) {

		      		$res = mysql_fetch_assoc($res);
		  			$status = "SUCCESS";

		      		// echo $res;
					$conn->close();
					// echo json_encode(['res'=>$res,'status'=>'SUCCESS']);

				}

		} else {
			$conn->close();

			$res = "Error: " . $sql . "<br>" . $conn->error;
		  	$status = "ERROR";

			// echo json_encode(['res'=>"Error: " . $sql . "<br>" . $conn->error,'status'=>'ERROR']);
		}
		break;
	
	case 'delete':

		$sql = "DELETE FROM playlists WHERE id=$id";

		if ($conn->query($sql) === TRUE) {
		  $status = "SUCCESS";
		  $res = "Record deleted successfully";
		} else {
		  $res = "Error deleting record: " . $conn->error;
		  $status = "ERROR";

		}

		$conn->close();

		break;

	case 'update':
		$sql = "UPDATE playlists SET lastname='Doe' WHERE id=$id";

		if ($conn->query($sql) === TRUE) {
		  $status = "SUCCESS";
		  $res = "Record updated successfully";
		} else {
		  $res = "Error updating record: " . $conn->error;
		  $status = "ERROR";

		}

		$conn->close();
		break;

	default:
		$sql = "SELECT * FROM playlists WHERE id = $id";
		$result = $conn->query($sql);
		if ($conn->query($sql) === TRUE) {
		  	$res = mysql_fetch_assoc($res);
		  	$status = "SUCCESS";
		} else {
		  	$res = "No record: " . $conn->error;
		  	$status = "ERROR";
		}
		$conn->close();
		break;

}

echo json_encode(['res'=>$res,'status'=>$status]);


?>