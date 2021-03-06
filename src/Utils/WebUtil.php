<?php

namespace csi0n\ZMop\Utils;
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 12:40 PM
 */
class WebUtil
{
    /**
     * 将传入的参数组织成key1=value1&key2=value2形式的字符串
     * @param $params
     * @return string
     */
    public static function buildQueryWithoutEncode($params)
    {
        return self::buildQuery($params, false);
    }

    public static function buildQueryWithEncode($params)
    {
        return self::buildQuery($params, true);
    }

    public static function buildQuery($params, $needEncode)
    {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === self::checkEmpty($v)) {
                if ($needEncode) {
                    $v = urlencode($v);
                }

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }

    public static function trim($params)
    {
        return array_filter($params, function ($k, $v) {
            return $v;
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     *  校验$value是否非空
     *  if not set ,return true;
     *  if is null , return true;
     * @param $value
     * @return bool
     */
    public static function checkEmpty($value)
    {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }
}