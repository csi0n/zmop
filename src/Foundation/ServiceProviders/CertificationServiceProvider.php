<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/18/17
 * Time: 5:51 PM
 */

namespace csi0n\ZMop\Foundation\ServiceProviders;


use csi0n\ZMop\Repositories\CertificationRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CertificationServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['certification'] = function ($pimple) {
            return new CertificationRepository($pimple);
        };
    }
}