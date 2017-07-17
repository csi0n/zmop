<?php

namespace csi0n\ZMop\Foundation\ServiceProviders;
use csi0n\ZMop\Repositories\AuthRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 3:06 PM
 */
class AuthServiceProvider implements ServiceProviderInterface
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
        $pimple['auth']=function ($pimple){
            return new AuthRepository($pimple);
        };
    }
}