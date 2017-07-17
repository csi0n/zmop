<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 3:14 PM
 */

namespace csi0n\ZMop\Foundation\ServiceProviders;


use csi0n\ZMop\Repositories\IvsRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class IvsServiceProvider implements ServiceProviderInterface
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
        $pimple['ivs']=function ($pimple){
            return new IvsRepository($pimple);
        };
    }
}