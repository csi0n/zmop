<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 3:12 PM
 */

namespace csi0n\ZMop\Repositories;


use csi0n\ZMop\Repositories\Ext\BaseRepository;
use Pimple\Container;

class ScoreRepository extends BaseRepository
{
    //业务参数
    public $biz_attributes = [
        'transaction_id' => '',
        'product_code' => 'w1010100100000000001',
        'open_id' => '',
    ];

    public function __construct(Container $application)
    {
        parent::__construct($application);
        $this->method = 'zhima.credit.score.get';
    }

    //获取结果，包括biz_no等信息
    public function query($open_id = '', $transaction_id = '')
    {
        $this->channel = 'api'; //似乎每一个都可以，有点晕

        if ($open_id) {
            $this->open_id = $open_id;
        }

        if ($transaction_id) {
            $this->transaction_id = $transaction_id;
        }

        $result = $this->post();

        return $result;
    }

    //只获取芝麻分
    public function score($open_id = '', $transaction_id = '')
    {
        $result = $this->query($open_id, $transaction_id);
        return isset($result['zm_score'])?intval($result['zm_score']):false;
    }
}