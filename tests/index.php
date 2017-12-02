<?php

require '../vendor/autoload.php';

use Xjtuana\XjtuWs\WebService\WsUserInfo;
use Xjtuana\XjtuWs\WebService\WsUserPhoto;
use Xjtuana\XjtuWs\WebService\WsSms;
use Xjtuana\XjtuWs\WebService\XjtuWebServiceException;

$config = require './config.php';
try {

    $userinfo = new WsUserInfo($config['userinfo']['url'], $config['userinfo']['config'], [
        'connection_timeout' => 10,
    ]);
    
    $res_userinfo = $userinfo->getByNetid('netid');

    $userphoto = new WsUserPhoto($config['userphoto']['url'], $config['userphoto']['config'], [
        'connection_timeout' => 10,
    ]);
    
    $res_userphoto = $userphoto->getByUserno('userno');

    $sms = new WsSms($config['sms']['url'], $config['sms']['config'], [
        'connection_timeout' => 10,
    ]);
    
    $res_sms = $sms->send('mobile_number', 'sms_content');
    
} catch(XjtuWebServiceException $e) {
    echo $e->getMessage();
} catch(\SoapFault $e) {
    throw $e;
}

var_dump($res_userinfo);
echo '<br>';
var_dump($res_userphoto);
echo '<br>';
var_dump($res_sms);