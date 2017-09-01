# XJTU Webservice - PHP Version

PHP Client for XJTU Webservice

目前支持：
- WsUserInfo 用户信息接口
- WsUserPhoto 用户照片接口
- WsSms 短信平台接口

## Usage 使用方法

- 通过Composer引入包（[Packagist](https://packagist.org/packages/xjtuana/xjtu-webservice)）

```shell
composer require xjtuana/xjtu-webservice ~1.0
```

- 示例代码

```php
use Xjtuana\Ws\WebService\WsUserInfo;
use Xjtuana\Ws\WebService\XjtuWebServiceException;

try {

    $userinfo = new WsUserInfo([
        'url' => '...',
        'auth' => '...',
    ]);
    
    $result = $userinfo->getByNetid('netid');
    
} catch(XjtuWebServiceException $e) {
    echo $e->getMessage();
} catch(\SoapFault $e) {
    throw $e;
}

var_dump($result);
```

## API

### WsUserInfo

- `getByNetid()` 通过NETID获取信息

    - 参数：`string` 查询的NETID

    - 返回值：`array` 用户对象数组

- `getByName()` 通过姓名获取信息

    - 参数：`string` 查询的姓名

    - 返回值：`array` 用户对象数组

- `getByUserno()` 通过学工号获取信息

    - 参数：`string` 查询的学工号

    - 返回值：`array` 用户对象数组

- `getByMobile()` 通过手机号获取信息

    - 参数：`string` 查询的手机号

    - 返回值：`array` 用户对象数组

- `setFilter()` 设置要隐藏的字段

    - 参数：`array` 字段名数组

    - 返回值：`UserInfo` (可链式调用，对当前示例持续生效)

    - 示例：

    ```php
    $userinfo->setFilter(['userno'])->getByNetid('netid');
    ```

    - 注意：默认`filter = ['idcardname' ,'idcardno']`，即默认隐藏证件名称和证件号码

#### 字段列表

字段名 | 含义 | 示例
----|------|----
userno | 学工号  | 2100000000
userid | NetID  | user.netid
username | 姓名  | 王二小
gender | 性别  | 男 / 女
email | 邮箱  | user.netid@stu.xjtu.edu.cn
usertype | 用户类型  | 1(学生) / 2(教职工)
classid | 班级  | 6046
dep | 所属部门/学院  | 电子与信息工程学院
depid | 部门/学院代码  | 
birthday | 生日  | 2000-02-20
idcardname | 证件名称  | 身份证
idcardno | 证件号码  | 
marriage | 婚姻状况  | 未婚
mobile | 手机号  | 18222222222
nation | 民族  | 汉族
nationplace | 故乡/生源地  | 河北
polity | 政治面貌  | 无党派民主人士
roomnumber | 宿舍  | 东2宿舍-0222
roomphone | 宿舍电话  | 
speciality | 专业名称  | 计算机科学与技术
studenttype | 学生类型  | 统考本科生 / 统考硕士 / 博士
tutoremployeeid | 导师姓名  | 王树国


### WsUserPhoto

- `getByUserno()` 通过学工号获取照片

    - 参数：`string` 查询的学工号

    - 返回值：`string` (base64)

### WsSms

- `send()` 发送短信

    - 参数1：`string` 目标手机号，多个号码用半角逗号隔开

    - 参数2: `string` 短信内容，根据长度会拆分成多条

    - 返回值：`int` 发送结果，好像没什么用，成不成功都回0


## Related Packages 相关包

- [xjtuana/laravel-xjtuana](https://git.xjtuana.com/xjtuana/laravel-xjtuana)