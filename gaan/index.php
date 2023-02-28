<?php 
// require_once 'gaan/getID3/getid3/getid3.php';
require_once './getID3/getid3/getid3.php';
    // Set up the API endpoint and parameters
    set_time_limit(3600); 
    $url = 'https://gaan.app/api/api/tracks/playweb';
    $userId = 'sgekyuAoNleN5vQWiumDvVZ0yQ52';
    $intialId = 8360;
    for($index = 1; $index <= 7000; $index++){
        $params = array(
            'userUid' => $userId,
            'id' => $index
        );
    
        // Build the request URL with parameters
        $request_url = $url . '?' . http_build_query($params);
        echo $request_url."</br>";
    
        // Make the HTTP request to the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo $index.'-'.$httpcode."</br>";
    
        // Save the MP3 file to disk
        if($httpcode == 200){
            $fileName = $index.'.mp3';
            $file_path = './downlaods/'.$fileName;
            $file = fopen($file_path, 'w');
            fwrite($file, $response);
            fclose($file);  
            // Meta Data  
            $getid3 = new getID3;
            $file_info = $getid3->analyze($file_path);
            $getid3->CopyTagsToComments($file_info);

            $title  = $file_info['comments_html']['title'][0]; 
            $artist = $file_info['comments_html']['artist'][0];
            $album  = $file_info['comments_html']['album'][0];

            $newLocation = "./downlaods/".$artist."/".$album;
            if (!file_exists($newLocation)) {
                mkdir($newLocation, 0777, true);
            }
            rename($file_path, $newLocation."/".$title.".mp3");
            
        } 
    }
    

?>