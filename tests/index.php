<?php

require '../vendor/autoload.php';

use Xjtuana\XjtuWs\WebService\WsUserInfo;
use Xjtuana\XjtuWs\WebService\XjtuWebServiceException;

$config = require './config.php';
try {

    $userinfo = new WsUserInfo($config['userinfo']);
    
    $result = $userinfo->getByNetid('netid');
    
} catch(XjtuWebServiceException $e) {
    echo $e->getMessage();
} catch(\SoapFault $e) {
    throw $e;
}

var_dump($result);