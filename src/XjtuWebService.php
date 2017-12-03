<?php

namespace Xjtuana\XjtuWs\WebService;

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
     * 该webservice的config.
     *
     * @var array
     */
    protected $config;

    /**
     * 传入SoapClient的options.
     *
     * @var array
     */
    protected $options = [
        'connection_timeout' => 5,
    ];
    
    /**
     * 要求必须传入的配置项.
     *
     * @var array
     */
    protected $requiredConfig = [];

    /**
     * 构造函数，传入url.
     *
     * @param  string   $url
     * @param  array    $config
     * @param  array    $options
     *
     * @return void
     * @throws \Xjtuana\XjtuWs\XjtuWebServiceException
     */
    public function __construct(string $url, array $config, array $options = []) {
        if (empty($url)) {
            throw new XjtuWebServiceException('The url of '.__CLASS__.' is required.');
        }
        foreach($this->requiredConfig as $reqconf) {
            if (empty($config[$reqconf])) {
                throw new XjtuWebServiceException('The config[\''.$reqconf.'\'] of '.__CLASS__.' is required.');
            }
        }
        $this->url = $url;
        $this->config = $config;
        $this->options = array_merge($this->options, $options);
    }

    /**
     * 获取当前SoapClient实例.
     *
     * @return \SoapClient
     */
    protected function soap() {
        if (!$this->soap instanceof SoapClient) {
            $this->soap = new SoapClient($this->url, $this->options);
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
     * @throws \Xjtuana\XjtuWs\XjtuWebServiceException
     */
    protected function parseResult($result) {}

}