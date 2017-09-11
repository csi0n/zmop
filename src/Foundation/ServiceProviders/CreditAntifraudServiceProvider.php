<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 9/11/17
 * Time: 11:48 AM
 */

namespace csi0n\ZMop\Foundation\ServiceProviders;


use csi0n\ZMop\Repositories\CreditAntifraudRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CreditAntifraudServiceProvider implements ServiceProviderInterface {

	/**
	 * Registers services on the given container.
	 *
	 * This method should only be used to configure services and parameters.
	 * It should not get services.
	 *
	 * @param Container $pimple A container instance
	 */
	public function register( Container $pimple ) {
		$pimple['creditantifraud'] = function ($pimple) {
			return new CreditAntifraudRepository($pimple);
		};
	}
}