<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 12:53 PM
 */

namespace csi0n\ZMop\Repositories;


use csi0n\ZMop\Repositories\Ext\BaseRepository;

class AuthRepository extends BaseRepository
{
//业务参数
    public $biz_attributes = [
        'identity_type' => '',
        'identity_param' => '',
        'biz_params' => '',
    ];

    public function getH5Url()
    {
        $this->method = 'zhima.auth.info.authorize';
        $this->channel = 'app';
        $this->auth_code = 'M_H5';
        return $this->getUrl();
    }

    public function getPcUrl()
    {
        $this->method = 'zhima.auth.info.authorize';
        $this->channel = 'apppc';
        $this->auth_code = 'M_APPPC_CERT';
        return $this->getUrl();
    }

    public function query()
    {
        $this->method = 'zhima.auth.info.authquery';
        $data = $this->get();
        return $data['authorized'];
    }

    public function getNotify()
    {
        return new NotifyRepository($this->application['encryption']);
    }

    public function handleNotify(callable $callback)
    {
        $notify = $this->getNotify();
        if (!$notify->isValid()) {
            throw new \Exception("Invalid request");
        }

        $notify = $notify->getNotify();
        $successful = $notify['success'] === 'true';
        call_user_func_array($callback, [$notify, $successful]);
    }
}