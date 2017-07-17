<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 3:15 PM
 */

namespace csi0n\ZMop\Foundation\ServiceProviders;


use csi0n\ZMop\Repositories\ScoreRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ScoreServiceProvider implements ServiceProviderInterface
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
        $pimple['score'] = function ($pimple) {
            return new ScoreRepository($pimple);
        };
    }
}