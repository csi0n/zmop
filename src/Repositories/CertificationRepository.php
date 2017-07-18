<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/18/17
 * Time: 5:51 PM
 */

namespace csi0n\ZMop\Repositories;


use csi0n\ZMop\Repositories\Ext\BaseRepository;

class CertificationRepository extends BaseRepository
{
    public $biz_attributes = [
        'transaction_id' => '',
        'product_code' => '',
        'biz_code' => 'FACE',
//        {"identity_type":"CERT_INFO","cert_type":"IDENTITY_CARD","cert_name":"收委","cert_no":"260104197909275964"}
        'identity_param' => '',
        'merchant_config' => '{"need_user_authorization":"false"}',
        'ext_biz_param' => '{}'
    ];

    public function initialize()
    {
        $this->method = 'zhima.customer.certification.initialize';
        return $this->get();
    }
}