<?php

namespace Xjtuana\XjtuWs\WebService;

use SoapFault;

/**
 * Class WsUserPhoto.
 * 获取用户照片的Web Service
 * 默认获取的是照片的base64编码，可直接通过<img>标签的src属性显示
 * 
 * @param $config['auth']  调用该webservice需要的凭证
 *
 * @author meteorlxy <meteor.lxy@foxmail.com>
 *
 */
class WsUserPhoto extends XjtuWebService {

    /**
     * 要求必须传入的配置项.
     *
     * @var array
     */
    protected $requiredConfig = [
        'auth',
    ];

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
                'auth'  => $this->config['auth'],
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