<?php

namespace Rbaker\ThreeTaps;

use Guzzle\Service\Builder\ServiceBuilder;
use Guzzle\Common\Collection;

/**
 * 3taps Client Service Builder Class
 *
 * @author Rbaker
 */
class ThreeTapsService
{
	public static function factory($config = null)
	{
		$default = array(
			'auth_token' => null,
			'scheme' => 'http',
			'base_url' => '{scheme}://{service}.3taps.com'
		);
		$required = array('auth_token');
		$config = Collection::fromConfig($config, $default, $required);

		$services = array(
			'services' => array(
        		'abstract_service' => array(
            		'params' => array(
                		'auth_token' => $config->get('auth_token'),
                		'base_url' => $config->get('base_url'),
                		'scheme' => $config->get('scheme')
            		)
        		),
        		'reference' => array(
            		'extends' => 'abstract_service',
            		'class'  => 'Rbaker\ThreeTaps\Reference\ReferenceClient',
            		'params' => array(
            			'service' => 'reference'
            		)

        		),
        		'search' => array(
            		'extends' => 'abstract_service',
            		'class'   => 'Rbaker\ThreeTaps\Search\SearchClient',
            		'params' => array(
            			'service' => 'search'
            		)
        		),
        		'polling' => array(
        			'extends' => 'abstract_service',
        			'class' => 'Rbaker\ThreeTaps\Polling\PollingClient',
        			'params' => array(
        				'service' => 'polling'
        			)
        		)
        	)
		);

		return ServiceBuilder::factory($services);
	}
}
