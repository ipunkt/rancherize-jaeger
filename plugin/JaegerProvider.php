<?php namespace RancherizeJaeger;

use Rancherize\Blueprint\Events\MainServiceBuiltEvent;
use Rancherize\Plugin\Provider;
use Rancherize\Plugin\ProviderTrait;
use RancherizeJaeger\Event\EventHandler;
use RancherizeJaeger\Parser\ConfigParser;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class JaegerProvider
 */
class JaegerProvider implements Provider
{
    use ProviderTrait;

    /**
     */
    public function register()
    {
        $this->container[ConfigParser::class] = function () {
            return new ConfigParser();
        };

        $this->container[EventHandler::class] = function ( $c ) {
            return new EventHandler( $c[ConfigParser::class] );
        };
    }

    /**
     */
    public function boot()
    {
        /**
         * @var EventDispatcher $dispatcher
         */
        $dispatcher = $this->container['event'];
        $listener = $this->container[EventHandler::class];
        $dispatcher->addListener( MainServiceBuiltEvent::NAME, [$listener, 'built'] );
    }
}