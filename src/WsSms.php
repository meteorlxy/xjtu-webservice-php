<?php

namespace Xjtuana\XjtuWs\WebService;

use SoapFault;

/**
 * Class WsSms.
 * 发送短信的Web Service
 *
 * @param $config['usr']  调用该webservice需要的用户名
 * @param $config['pwd']  调用该webservice需要的密码
 * 
 * @author meteorlxy <meteor.lxy@foxmail.com>
 *
 */
class WsSms extends XjtuWebService {

    /**
     * 要求必须传入的配置项.
     *
     * @var array
     */
    protected $requiredConfig = [
        'usr',
        'pwd'
    ];
    
    /**
     * 发送短信.
     *
     * @param  string   $mobile     目标手机号，可用多个半角逗号隔开
     * @param  string   $content    短信内容
     *
     * @return int
     * @throws \SoapFault
     */
    public function send($mobile, $content) {
        try {
            $result = $this->soap()->sendMsg([
                'in0' => $this->config['usr'],
                'in1' => $this->config['pwd'],
                'in2' => $mobile,
                'in3' => $content,
            ]);
        } catch (SoapFault $e) {
            throw $e;
        }

        return $this->parseResult($result);
    }

    /**
     * 处理webservice返回的结果
     *
     * @param  mixed    $result 
     *
     * @return int
     * @throws \Xjtuana\XjtuWs\WebService\XjtuWebServiceException
     */
    protected function parseResult($result) {
 
        if (! property_exists($result, 'out')) {
            throw new XjtuWebServiceException('Invalid response from web service server.');
        }

        $result = $result->out;

        return $result;
    }

}