<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 12:31 PM
 */

namespace csi0n\ZMop\Repositories\Ext;

use csi0n\ZMop\Exceptions\SignException;
use csi0n\ZMop\Utils\WebUtil;
use Curl\Curl;
use Exception;
use Pimple\Container;

abstract class BaseRepository
{
    protected $application = null;
    protected $gateway = 'https://zmopenapi.zmxy.com.cn/openapi.do';
    public $sys_attributes = [
        'app_id' => '',
        'scene' => '',
        'charset' => 'UTF-8',
        'method' => '',
        'version' => '1.0',
        'channel' => '',
        'platform' => 'zmop',
        'params' => '',
        'sign' => '',
        'ext_params' => '',
        'auth_code' => ''
    ];


    protected $http = null;

    //业务参数
    public $biz_attributes = [];

    /**
     * BaseRepository constructor.
     * @param Container $application
     */
    public function __construct(Container $application)
    {
        $this->sys_attributes = array_merge(
            $this->sys_attributes, $application['config']);

        $this->application = $application;
    }

    public function getHttp()
    {
        if ($this->http === null) {
            $this->http = new Curl();
        }
        return $this->http;
    }

    public function getUrl()
    {
        $url = sprintf('%s?%s', $this->gateway, $this->getRequestString());
        return $url;
    }

    public function getBizAttributesStr()
    {
        return WebUtil::buildQueryWithEncode($this->biz_attributes);
    }

    public function getRequestString()
    {
        $biz_query = $this->getBizAttributesStr();
        $encryptor = $this->application['encryption'];
        $this->sign = $encryptor->sign($biz_query);
        $this->params = $encryptor->rsaEncrypt($biz_query);

        return WebUtil::buildQueryWithEncode($this->sys_attributes);
    }

    public function getRequestParams()
    {
        $biz_query = $this->getBizAttributesStr();

        $encryptor = $this->application['encryption'];
        $this->sign = $encryptor->sign($biz_query);
        $this->params = $encryptor->rsaEncrypt($biz_query);

        return WebUtil::trim($this->sys_attributes);
    }

    public function get()
    {
        $result = $this->getHttp()->get($this->gateway,
            $this->getRequestParams());
        return $this->parse($result);
    }

    public function post()
    {
        $result = $this->getHttp()->post($this->gateway,
            $this->getRequestParams());
        return $this->parse($result);
    }

    public function json()
    {
        $result = $this->getHttp()->json($this->gateway,
            $this->getRequestParams());
        return $this->parse($result);
    }


    public function parse($result)
    {
        $result = json_decode($result, true);
        if ($result['encrypted'] == false) {
            $result = $result['biz_response'];
            return json_decode($result, true);
        } else {
            $encryptor = $this->application['encryption'];
            $response = $result['biz_response'];
            $sign = $result['biz_response_sign'];
            $result = $encryptor->rsaDecrypt($response);
            if ($encryptor->verify($result, $sign)) {
                return json_decode($result, true);
            } else {
                throw new SignException();
            }
        }
    }

    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            return $this->$setter($value);
        } elseif (isset($this->sys_attributes[$name]) ||
            isset($this->biz_attributes[$name])
        ) {
            return $this->setAttribute($name, $value);
        }
        throw new Exception('Property ' . get_class($this) . '. ' . $name . 'is not defined');
    }

    public function getAttribute($name)
    {
        if (isset($this->sys_attributes[$name])) {
            return $this->sys_attributes[$name];
        } elseif (isset($this->biz_attributes[$name])) {
            return $this->biz_attributes[$name];
        }
        return null;
    }

    public function setAttribute($name, $value)
    {
        if (isset($this->sys_attributes[$name])) {
            $this->sys_attributes[$name] = $value;
            return $this;
        } elseif (isset($this->biz_attributes[$name])) {
            $this->biz_attributes[$name] = $value;
            return $this;
        }

        return false;
    }

    public function __call($name, $params)
    {
        if (strncasecmp($name, 'get', 3) === 0) {
            $attribute = strtolower(substr($name, 3));
            if (
                isset($this->sys_attributes[$attribute]) ||
                isset($this->biz_attributes[$attribute])
            ) {
                return $this->getAttribute($attribute);
            }
        } else if (strncasecmp($name, 'set', 3) === 0) {
            $attribute = strtolower(substr($name, 3));
            if (
                isset($this->sys_attributes[$attribute]) ||
                isset($this->biz_attributes[$attribute])
            ) {
                return $this->setAttribute($attribute, $params[0]);
            }
        }
        throw new Exception('Methord ' . get_class($this) . '.' . $name . 'is not defined');
    }
}