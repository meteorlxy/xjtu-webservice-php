<?php

namespace Xjtuana\Ws\WebService;

use SoapClient;

/**
 * Class XjtuWebService.
 * Web Service基类
 *
 * @author meteorlxy <meteor.lxy@foxmail.com>
 *
 */
abstract class XjtuWebService {

    /**
     * The soap client used by the webservice.
     *
     * @var \SoapClient
     */
    protected $soap;

    /**
     * 该webservice的URL.
     *
     * @var string
     */
    protected $url;

    /**
     * 构造函数，传入url.
     *
     * @param  string    $url 
     *
     * @return void
     * @throws \Xjtuana\Ws\XjtuWebServiceException
     */
    public function __construct(string $url) {
        if ( empty($url) ) {
            throw new XjtuWebServiceException('The url of '.__CLASS__.' service is required.');
        }
        $this->url = $url;
    }

    /**
     * 获取当前SoapClient实例.
     *
     * @return \SoapClient
     */
    protected function soap() {
        if (!$this->soap instanceof SoapClient) {
            $this->soap = new SoapClient($this->url);
            $this->soap->soap_defencoding = 'utf-8';
            $this->soap->xml_encoding = 'utf-8';
        }
        return $this->soap;
    }

    /**
     * 处理webservice返回的结果
     *
     * @param  mixed    $result 
     *
     * @return mixed
     * @throws \Xjtuana\Ws\XjtuWebServiceException
     */
    protected function parseResult($result) {}

}