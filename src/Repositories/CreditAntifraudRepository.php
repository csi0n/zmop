<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 9/11/17
 * Time: 11:50 AM
 */

namespace csi0n\ZMop\Repositories;


use csi0n\ZMop\Repositories\Ext\BaseRepository;

class CreditAntifraudRepository extends BaseRepository {
	public $biz_attributes = [
		'transaction_id' => '',
		'product_code'   => 'asd',
		'cert_type'      => 'IDENTITY_CARD',
		'cert_no'        => '',
		'name'           => '',
		'mobile'         => '',
		'email'          => '',
		'bank_card'      => '',
		'address'        => '',
		'ip'             => '',
		'mac'            => '',
		'wifimac'        => '',
		'imei'           => ''
	];

	public function attribute( $attribute, $value ) {
		if ( in_array( $attribute, $this->biz_attributes ) ) {
			$this->biz_attributes[ $attribute ] = $value;
		}

		return $this;
	}

	public function data( $datas ) {
		$biz_arrtibutes_keys = array_keys( $this->biz_attributes );
		foreach ( $datas as $k => $v ) {
			if ( in_array( $k, $biz_arrtibutes_keys ) ) {
				$this->biz_attributes[ $k ] = $v;
			}
		}

		return $this;
	}

	public function score() {
		$this->method                         = 'zhima.credit.antifraud.score.get';
		$this->biz_attributes['product_code'] = 'w1010100003000001100';

		return $this;
	}

	public function verify() {
		$this->method                         = 'zhima.credit.antifraud.verify';
		$this->biz_attributes['product_code'] = 'w1010100000000002859';

		return $this;
	}

	public function get( $transactionId = '' ) {
		if ( ! empty( $transactionId ) ) {
			$this->biz_attributes['transaction_id'] = $transactionId;
		}

		return parent::get();
	}


}