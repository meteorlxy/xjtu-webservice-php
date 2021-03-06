<?php

namespace Xjtuana\XjtuWs\WebService;

use SoapFault;

/**
 * Class WsUserInfo.
 * 获取用户信息的Web Service
 * 
 * @param $config['auth']  调用该webservice需要的凭证
 *
 * @author meteorlxy <meteor.lxy@foxmail.com>
 *
 */
class WsUserInfo extends XjtuWebService {

    /**
     * 要求必须传入的配置项.
     *
     * @var array
     */
    protected $requiredConfig = [
        'auth',
    ];

    /**
     * Webservice响应中所包含的用户信息fields.
     *
     * @var array
     */
    protected $fields = [
        'userno',           // 学工号
        'userid',           // NetID
        'username',         // 姓名
        'gender',           // 性别
        'email',            // 邮箱
        'usertype',         // 用户类型 int 1学生 2教工
        'classid',          // 班级号 string '6047'
        'dep',              // 所属部门/学院
        'depid',            // 部门/学院代码
        'birthday',         // 生日 string '1994-06-20'
        'idcardname',       // 证件类型
        'idcardno',         // 证件号码
        'marriage',         // 婚否
        'mobile',           // 手机号
        'nation',           // 民族
        'nationplace',      // 故乡
        'polity',           // 政治面貌
        'roomnumber',       // 宿舍号 string '东8宿舍-0999'
        'roomphone',        // 宿舍电话 null
        'speciality',       // 专业 string '计算机科学与技术'
        'studenttype',      // 学生类型 string '统考硕士' / '统考本科生' / '博士'
        'tutoremployeeid',  // 导师姓名 string|null
    ];

    /**
     * 返回结果时应过滤掉的敏感信息.
     *
     * @var array
     */
    protected $filter = [
        'idcardname',
        'idcardno',
    ];

    /**
     * 根据用户Netid查询信息.
     *
     * @param  string   $netid 
     *
     * @return array
     * @throws \SoapFault
     */
    public function getByNetid($netid) {
        try {
            $result = $this->soap()->getInfoById([
                'auth'  => $this->config['auth'],
                'uid'   => $netid
            ]);
        } catch (SoapFault $e) {
            throw $e;
        }

        return $this->parseResult($result);
    }

    /**
     * 根据用户姓名查询信息.
     *
     * @param  string   $name 
     *
     * @return array
     * @throws \SoapFault
     */
    public function getByName($name) {
        try {
            $result = $this->soap()->getInfoByName([
                'auth'  => $this->config['auth'],
                'sname' => $name
            ]);
        } catch (SoapFault $e) {
            throw $e;
        }

        return $this->parseResult($result);
    }

    /**
     * 根据用户学工号查询信息.
     *
     * @param  string   $userno 
     *
     * @return array
     * @throws \SoapFault
     */
    public function getByUserno($userno) {
        try {
            $result = $this->soap()->getInfoByNo([
                'auth'  => $this->config['auth'],
                'sno'   => $userno
            ]);
        } catch (SoapFault $e) {
            throw $e;
        }

        return $this->parseResult($result);
    }

    /**
     * 根据用户手机号查询信息.
     *
     * @param  string   $mobile 
     *
     * @return array
     * @throws \SoapFault
     */
    public function getByMobile($mobile) {
        try {
            $result = $this->soap()->getInfoByMobile([
                'auth'  => $this->config['auth'],
                'mobile' => $mobile
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
     * @return array
     * @throws \Xjtuana\XjtuWs\WebService\XjtuWebServiceException
     */
    protected function parseResult($result) {
 
        if (! property_exists($result, 'return')) {
            return [];
        }

        $result = $result->return;
        
        if (is_null($result)) {
            return [];
        }
        
        if (!is_array($result)) {
            $result = [$result];
        }

        return $this->filterResult($result);
    }

    /**
     * 过滤webservice返回的结果.
     *
     * @param  array    $result 
     *
     * @return array
     * @throws \Xjtuana\XjtuWs\WebService\XjtuWebServiceException
     */
    protected function filterResult(array $result) {
        foreach($result as $index => $user) {
            if (!is_object($user)) {
                throw new XjtuWebServiceException('Invalid response from web service server.');
            }
            foreach($user as $key => $val ) {
                if (!in_array($key, $this->fields) || in_array($key, $this->filter)) {
                    unset($user->$key);
                }
            }
            
            // $result[$index] = (array) $user;
        }
        return $result;
    }

    /**
     * 设置要被过滤掉的字段.
     *
     * @param  array    $filter 
     *
     * @return \Xjtuana\XjtuWs\WebService\UserInfo
     */
    public function setFilter(array $filter) {
        $this->filter = $filter;
        return $this;
    }

}