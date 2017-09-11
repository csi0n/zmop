<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 12:50 PM
 */

namespace csi0n\ZMop\Exceptions;


class SignException extends \Exception
{

    /**
     * SignException constructor.
     */
    public function __construct($message = '签名错误')
    {
        $this->message = $message;
    }
}