<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 3:11 PM
 */

namespace csi0n\ZMop\Repositories;


use csi0n\ZMop\Repositories\Ext\BaseRepository;
use Pimple\Container;

class IvsRepository extends BaseRepository
{
    //业务参数
    public $biz_attributes = [
        'product_code' => 'w1010100000000000103',
        'transaction_id' => '',
        'open_id' => '',
        'cert_no' => '',
        'cert_type' => '',
        'name' => '',
        'mobile' => '',
        'email' => '',
        'bank_card' => '',
        'address' => '',
        'ip' => '',
        'mac' => '',
        'wifimac' => '',
        'imei' => '',
        'imsi' => '',
    ];

    public function __construct(Container $application)
    {
        parent::__construct($application);
        $this->method = 'zhima.credit.ivs.detail.get';
        $this->channel = 'api';
    }

    //只获取评分
    public function score(array $info = [])
    {
        $result = $this->query($info);
        return $result['ivs_score'];
    }

    //获取结果，包括biz_no等信息
    public function query(array $info = [])
    {

        foreach ($info as $k => $v) {
            if (isset($this->biz_attributes[$k])) {
                $this->$k = $v;
            }
        }

        $result = $this->post();
        return $result;
    }
}