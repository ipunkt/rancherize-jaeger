<?php namespace RancherizeJaeger\Builder;

use Rancherize\Blueprint\Infrastructure\Infrastructure;
use Rancherize\Blueprint\Infrastructure\Service\NetworkMode\ShareNetworkMode;
use Rancherize\Blueprint\Infrastructure\Service\Service;
use Rancherize\Configuration\Configuration;
use RancherizeJaeger\Parser\ConfigParser;

/**
 * Class Builder
 * @package RancherizeJaeger\Builder
 */
class Builder
{

    /**
     * @var Service
     */
    private $targetService;

    /**
     * @var Configuration
     */
    private $environmentConfig;

    /**
     * @var Infrastructure
     */
    private $infrastructure;
    /**
     * @var ConfigParser
     */
    private $configParser;

    /**
     * Builder constructor.
     * @param ConfigParser $configParser
     */
    public function __construct(ConfigParser $configParser) {
        $this->configParser = $configParser;
    }

    public function build()
    {
        $jaegerConfig = $this->configParser->parse($this->environmentConfig);
        if (!$jaegerConfig->isEnabled()) {
            return;
        }

        $jaegerService = new Service();
        $targetService = $this->targetService;
        $jaegerService->setName(function () use ($targetService) {
            return 'Jag-' . $targetService->getName();
        });
        $jaegerService->setImage($jaegerConfig->getImage());
        $jaegerService->setNetworkMode(new ShareNetworkMode($this->targetService));

        switch ($jaegerConfig->getJaegerMethod()) {
            case 'grpc':
                $jaegerService->setCommand('--reporter.grpc.host-port=' . $jaegerConfig->getJaegerHost());
                break;
        }

        $this->targetService->setEnvironmentVariable('JAEGER_AGENT_HOST', 'localhost');
        $this->targetService->setEnvironmentVariable('JAEGER_AGENT_PORT', '6831');
        $this->targetService->addSidekick($jaegerService);

        $this->infrastructure->addService($jaegerService);
    }


    public function setTargetService(Service $service)
    {
        $this->targetService = $service;
        return $this;
    }

    public function setEnvironmentConfig(Configuration $environmentConfig)
    {
        $this->environmentConfig = $environmentConfig;
        return $this;
    }

    public function setInfrastructure(Infrastructure $infrastructure)
    {
        $this->infrastructure = $infrastructure;
        return $this;
    }
}