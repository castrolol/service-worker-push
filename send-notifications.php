<?php

    define( 'API_ACCESS_KEY', "AIzaSyBBATdhSb7l7pf_i0Bw80fQaXjNlulBEcs");
    
    function sendToChrome($heroi, $ids){
        
        var_dump($ids);
        
        $headers = array( 
                    'Authorization: key=' . $apiKey,
                    'Content-Type: application/json'
                );


        // API access key from Google API's Console
        $registrationIds = $ids;
        // prep the bundle
        $msg = array
        (
            "heroi" => $heroi
        );
        $fields = array
        (
            'registration_ids' 	=> $registrationIds,
            'data'			=> $msg
        );
        
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        echo $result;
        var_dump($result);

    }

    function sendToFirefox($heroi, $ids){
        global $db;
        $versions = $db->query("select value from params key='version' LIMIT 1", PDO::FETCH_NUM);
         
        $version = $versions[0][0];
        $stmt = $db->prepare("UPDATE params SET value=:version WHERE key='version' ");
        $stmt->execute(array("version" => $version + 1));
      
        $fields = array(
            "version"=>$version,
            "data"=> array("heroi" => $heroi)
        );
        
        foreach($ids as $id){ 
      
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $id );
            curl_setopt( $ch,CURLOPT_POST, true ); 
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            echo $result;
            var_dump($result);
        
        }
        
    }
    


?>