<?php
	header("Content-Type: application/json");
	header("Access-Control-Allow-Origin: *");
 
	function map($heroi){
		return $heroi->heroi;
	}

	$db = new PDO("mysql:dbname=u213515299_apis;host=mysql.hostinger.com", "u213515299_apis", "ak47m4a1");


	if(isset($_GET["from"])){
		//pegar
		$from = $_GET["from"];
		
		$stmt = $db->prepare("SELECT * FROM herois WHERE id_voto > :from");
		$stmt->execute(array("from" => $from));
		$items = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		
		
		die(json_encode(array_map("map", $items)));
		
	}else if(isset($_POST["heroi"])){
 
		$stmt = $db->prepare("INSERT INTO herois (heroi) VALUES (:nome)");
	 
		if($stmt->execute(array( "nome" => $_POST['heroi'] ))){
			return "true";
		}else{
			return "false";
		}
		
	}


?>