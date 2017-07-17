<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 3:16 PM
 */

namespace csi0n\ZMop\Foundation\ServiceProviders;


use csi0n\ZMop\Repositories\WatchListRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class WatchListServiceProvider implements ServiceProviderInterface
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
        $pimple['watchlist'] = function ($pimple) {
            return new WatchListRepository($pimple);
        };
    }
}