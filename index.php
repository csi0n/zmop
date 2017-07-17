<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 11:44 AM
 */
require 'vendor/autoload.php';

$application = new \csi0n\ZMop\Foundation\Application([
    'app_id'    => '123456',
    'scene'     => 'yourscene',
    'private_key_file' => '/Users/csi0n/Desktop/rsa_private_key.pem',
    'zhima_public_key_file' => '/Users/csi0n/Desktop/rsa_public_key.pem'
]);
$application['auth']->identity_type = '2';
$application['auth']->identity_param = json_encode([
    'certNo'    => '身份证号',
    'certType'  => 'IDENTITY_CARD',
    'name'      => '名字',
]);
echo $application['auth']->getH5Url();