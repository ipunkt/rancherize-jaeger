<?php namespace RancherizeJaeger\Parser;

use Rancherize\Configuration\Configuration;
use Rancherize\Configuration\PrefixConfigurationDecorator;
use RancherizeJaeger\Config\JaegerConfig;

/**
 * Class ConfigParser
 * @package RancherizeMailhog\Parser
 */
class ConfigParser {

	/**
	 * @param Configuration $configuration
	 */
	public function parse( Configuration $configuration ) {
		$jaegerConfiguration = new PrefixConfigurationDecorator( $configuration, 'jaeger.' );

		$config = new JaegerConfig();

		if ( !$configuration->has( 'jaeger' ) )
			return $config;

		$config->setEnabled( true );

		if($jaegerConfiguration->has('method'))
		    $config->setJaegerMethod( $jaegerConfiguration->get('method') );
        if($jaegerConfiguration->has('host'))
            $config->setJaegerHost( $jaegerConfiguration->get('host') );
        if($jaegerConfiguration->has('image'))
            $config->setImage( $jaegerConfiguration->get('image') );

		return $config;

	}

}