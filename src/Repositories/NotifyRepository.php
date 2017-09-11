<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 4:33 PM
 */

namespace csi0n\ZMop\Repositories;


use Curl\Curl;

class NotifyRepository
{
    protected $encryption;
    protected $curl;
    protected $notify;
    protected $params = '';
    protected $sign = '';
    protected $result = '';

    /**
     * NotifyRepository constructor.
     * @param EncryptionRepository $encryptionRepository
     * @param Curl|null $curl
     */
    public function __construct(EncryptionRepository $encryptionRepository, Curl $curl = null)
    {
        $this->encryption = $encryptionRepository;
        $this->curl = $curl ?: new Curl();
    }

    public function getParams()
    {
        if ($this->params == '') {
            $this->params = $_REQUEST['params'];
        }
        return $this->params;
    }

    public function getSign()
    {
        if ($this->sign == '') {
            $this->sign = $_REQUEST['sign'];
        }
        return $this->sign;
    }

    public function getResult()
    {
        if ($this->result == '') {
            $this->result = $this->encryption->rsaDecrypt($this->getParams());
        }
        return $this->result;
    }

    public function isValid()
    {
        return $this->encryption->verify($this->getResult(), $this->getSign());
    }

    public function getNotify()
    {
        if (!empty($this->notify)) {
            return $this->notify;
        }
        parse_str($this->getResult(), $data);

        return $this->notify = $data;
    }
}