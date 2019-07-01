<?php namespace RancherizeJaeger\Event;

use Rancherize\Blueprint\Events\MainServiceBuiltEvent;
use Rancherize\Blueprint\Events\ServiceBuiltEvent;
use Rancherize\Configuration\Services\ConfigurationFallback;
use RancherizeJaeger\Builder\Builder;
use RancherizeJaeger\Parser\ConfigParser;

/**
 * Class EventHandler
 * @package RancherizeMailhog\Event
 */
class EventHandler {
    /**
     * @var Builder
     */
    private $builder;

    /**
     * EventHandler constructor.
     * @param ConfigParser $configParser
     * @param Builder $builder
     */
	public function __construct(  Builder $builder ) {
        $this->builder = $builder;
    }

	/**
	 * @param MainServiceBuiltEvent $event
	 */
	public function built( MainServiceBuiltEvent $event ) {
        $this->builder
            ->setTargetService($event->getMainService())
            ->setEnvironmentConfig($event->getEnvironmentConfiguration())
            ->setInfrastructure($event->getInfrastructure())
            ->build();

	}

    /**
     * @param MainServiceBuiltEvent $event
     */
    public function serviceBuilt( ServiceBuiltEvent $event ) {

        $fallbackConfiguration = new ConfigurationFallback($event->getConfiguration(), $event->getEnvironmentConfiguration());

        $this->builder
            ->setTargetService($event->getService())
            ->setEnvironmentConfig($fallbackConfiguration)
            ->setInfrastructure($event->getInfrastructure())
            ->build();


    }

}