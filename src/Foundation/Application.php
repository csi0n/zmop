<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 3:17 PM
 */

namespace csi0n\ZMop\Foundation;


use csi0n\ZMop\Foundation\ServiceProviders\AuthServiceProvider;
use csi0n\ZMop\Foundation\ServiceProviders\EncryptionServiceProvider;
use csi0n\ZMop\Foundation\ServiceProviders\IvsServiceProvider;
use csi0n\ZMop\Foundation\ServiceProviders\ScoreServiceProvider;
use csi0n\ZMop\Foundation\ServiceProviders\WatchListServiceProvider;
use Pimple\Container;

class Application extends Container
{
    protected $providers = [
        AuthServiceProvider::class,
        EncryptionServiceProvider::class,
        IvsServiceProvider::class,
        ScoreServiceProvider::class,
        WatchListServiceProvider::class
    ];

    /**
     * Application constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct();
        $this['config'] = $config;
        $this->registerProviders();
    }


    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }
}