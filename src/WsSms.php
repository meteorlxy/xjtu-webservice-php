<?php

namespace Xjtuana\Ws\WebService;

use SoapFault;

/**
 * Class WsSms.
 * 发送短信的Web Service
 *
 * @author meteorlxy <meteor.lxy@foxmail.com>
 *
 */
class WsSms extends XjtuWebService {

    /**
     * 调用该webservice需要的用户名.
     *
     * @var string
     */
    protected $usr;

    /**
     * 调用该webservice需要的密码.
     *
     * @var string
     */
    protected $pwd;

    /**
     * 构造函数，传入config数组.
     *
     * @param  array    $config 
     *
     * @return void
     * @throws \Xjtuana\Ws\WebService\XjtuWebServiceException
     */
    public function __construct(array $config) {
        
        parent::__construct($config['url']);
        
        if (empty($config['usr']) || empty($config['pwd'])) {
            throw new XjtuWebServiceException('The config of '.__CLASS__.' service is not complete.');
        }
        
        $this->usr = $config['usr'];
        $this->pwd = $config['pwd'];
    }

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
                'in0' => $this->usr,
                'in1' => $this->pwd,
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
     * @throws \Xjtuana\Ws\WebService\XjtuWebServiceException
     */
    protected function parseResult($result) {
 
        if (! property_exists($result, 'out')) {
            throw new XjtuWebServiceException('Invalid response from web service server.');
        }

        $result = $result->out;

        return $result;
    }

}