<?php

function http_post_flds($url, $data, $headers=null) {   
    $data = http_build_query($data);    
    $opts = array('http' => array('method' => 'POST', 'content' => $data, 'header' => "Content-Type: application/x-www-form-urlencoded\r\n"));

    if($headers) {
        $opts['http']['header'] = $headers;
    }
    $st = stream_context_create($opts);
    $fp = fopen($url, 'rb', false, $st);

    if(!$fp) {
        return false;
    }
    return stream_get_contents($fp);
}

$titles = array();
$types = array("RC", "CH", "FO", "AC");
foreach ($types as $type)
{
    $response=http_post_flds("http://" . $_SERVER['SERVER_NAME'] . "/~e54061/wp/movie-service.php",
            array("CRC" => "s3493577", "filmID" => $type));
    preg_match('/MS-title\'>(.*?)</', $response, $matches);
    $titles[$type] = ucwords(strtolower($matches[1]));
}

?>
