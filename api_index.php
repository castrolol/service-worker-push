<?php

    require "send-notifications.php";

	header("Content-Type: application/json");
	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: POST, GET, OPTIONS");
  
    
 
 
 
	function map($heroi){
		return $heroi->heroi;
	}

    function mapEndpoint($client){
        return $client->endpoint;
    }

	$db = new PDO("mysql:dbname=u213515299_apis;host=mysql.hostinger.com", "u213515299_apis", "ak47m4a1");


	if(isset($_GET["from"])){
		//pegar
		$from = $_GET["from"];
		
		$stmt = $db->prepare("SELECT * FROM herois");
		$stmt->execute( );
		$items = $stmt->fetchAll(PDO::FETCH_OBJ);
		$stmt = $db->prepare("UPDATE herois SET consumido = 1 ");
        $stmt->execute();
		
		
		die(json_encode(array_map("map", $items)));
		
    }else if(isset($_GET['push'])){    
        
        $stmt = $db->prepare("SELECT * FROM herois WHERE consumido = 0");
		$stmt->execute( );
		$items = $stmt->fetchAll(PDO::FETCH_OBJ);
		$stmt = $db->prepare("UPDATE herois SET consumido = 1 ");
        $stmt->execute();
		
		
		die(json_encode(array_map("map", $items)));
        
	}else if(isset($_POST["heroi"])){
 
		$stmt = $db->prepare("INSERT INTO herois (heroi) VALUES (:nome)");
	 
		$stmt->execute(array( "nome" => $_POST['heroi'] ));
		
        
        
        $res = $db->query("SELECT * FROM push_clients WHERE type = 'chrome'", PDO::FETCH_OBJ)->fetchAll();
		
        sendToChrome($_POST["heroi"], array_map("mapEndpoint", $res));
        
        die(json_encode(array("success" => TRUE)));
	}/*else {
           
           $resChrome = $db->query("SELECT * FROM push_clients WHERE type = 'chrome'", PDO::FETCH_OBJ)->fetchAll();
           $resFirefox = $db->query("SELECT * FROM push_clients WHERE type = 'firefox'", PDO::FETCH_OBJ)->fetchAll();
		
         
        
        sendToChrome("batman", array_map("mapEndpoint", $resChrome));
        sendToFirefox("batman", array_map("mapEndpoint", $resFirefox));
    }
*/

?>