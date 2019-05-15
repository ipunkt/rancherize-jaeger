<?php namespace RancherizeJaeger\Event;

use Rancherize\Blueprint\Events\MainServiceBuiltEvent;
use Rancherize\Blueprint\Infrastructure\Service\NetworkMode\ShareNetworkMode;
use Rancherize\Blueprint\Infrastructure\Service\Service;
use RancherizeJaeger\Parser\ConfigParser;

/**
 * Class EventHandler
 * @package RancherizeMailhog\Event
 */
class EventHandler {
	/**
	 * @var ConfigParser
	 */
	private $configParser;

	/**
	 * EventHandler constructor.
	 * @param ConfigParser $configParser
	 */
	public function __construct( ConfigParser $configParser ) {
		$this->configParser = $configParser;
	}

	/**
	 * @param MainServiceBuiltEvent $event
	 */
	public function built( MainServiceBuiltEvent $event ) {

		$mainService = $event->getMainService();
		$configuration = $event->getEnvironmentConfiguration();

		$jaegerConfig = $this->configParser->parse( $configuration );
		if ( !$jaegerConfig->isEnabled() )
			return;

		$jaegerService = new Service();
		$jaegerService->setName( 'Jaeger' );
		$jaegerService->setImage( $jaegerConfig->getImage() );
		$jaegerService->setNetworkMode( new ShareNetworkMode($mainService) );

		switch($jaegerConfig->getJaegerMethod()) {
            case 'grpc':
                $jaegerService->setCommand('--reporter.grpc.host-port='.$jaegerConfig->getJaegerHost());
                break;
        }

		$mainService->setEnvironmentVariable( 'JAEGER_AGENT_HOST', 'localhost' );
		$mainService->setEnvironmentVariable( 'JAEGER_AGENT_PORT', '6831' );
		$mainService->addSidekick($jaegerService);

		$event->getInfrastructure()->addService( $jaegerService );


	}
}