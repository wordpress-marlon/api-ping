<?php


/**
* Plugin Name: Api Ping
* Plugin URI: http://marlonfalcon.cl
* Author: Marlon Falcon
* Version: 1.0
* Author URL: http://marlonfalcon.cl 
 * 
 */
date_default_timezone_set('Europe/Madrid');

function error_handler($errno, $errstr, $errfile, $errline)
{
    if( ($errno & error_reporting()) > 0 )
        throw new ErrorException($errstr, 500, $errno, $errfile, $errline);
    else
        return false;
}
set_error_handler('error_handler');

function w_ping($slug){
    $ip =  $slug['slug'];

        $errno = null;
        $host = $ip; 
        $port = 80; 
        $waitTimeoutInSeconds = 1; 
        
        try {
            $fp = fsockopen($host,$port,$errCode,$errno,$waitTimeoutInSeconds);
            }
        catch(\ErrorException $e) { //used back-slash for global namespace
            return date('l jS \of F Y h:i:s A') . " : No Funciona la ip: ".$host;
        }

        if($fp){   
            return date('l jS \of F Y h:i:s A') . " :  Funciona la ip: ".$host;
        }

        fclose($fp);
         
    
}

add_action( 'rest_api_init', function(){

    register_rest_route('ping', '/(?P<slug>[a-zA-Z0-9-.]+)', array(
        'method' => 'GET',
        'callback' => 'w_ping',
     ));


});

?>