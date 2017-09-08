<?php

namespace Xjtuana\XjtuWs\WebService;

use SoapFault;

/**
 * Class WsUserPhoto.
 * 获取用户照片的Web Service
 * 默认获取的是照片的base64编码，可直接通过<img>标签的src属性显示
 *
 * @author meteorlxy <meteor.lxy@foxmail.com>
 *
 */
class WsUserPhoto extends XjtuWebService {

    /**
     * 调用该webservice需要的凭证.
     *
     * @var string
     */
    protected $auth;

    /**
     * 构造函数，传入config数组.
     *
     * @param  array    $config 
     *
     * @return void
     * @throws \Xjtuana\XjtuWs\WebService\XjtuWebServiceException
     */
    public function __construct(array $config) {
        
        parent::__construct($config['url']);

        $this->auth = $config['auth'];
    }

    /**
     * 根据用户学工号查询照片.
     *
     * @param  string   $userno 
     *
     * @return string
     * @throws \SoapFault
     */
    public function getByUserno($userno) {
        try {
            $result = $this->soap()->getPhotoByNo([
                'auth'  => $this->auth,
                'sno'   => $userno
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
     * @return string   base64
     * @throws \Xjtuana\XjtuWs\WebService\XjtuWebServiceException
     */
    protected function parseResult($result) {
 
        if (! property_exists($result, 'return')) {
            throw new XjtuWebServiceException('Invalid response from web service server.');
        }

        $result = $result->return;

        return base64_encode($result);
    }

}