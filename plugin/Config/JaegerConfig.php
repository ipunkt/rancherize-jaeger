<?php namespace RancherizeJaeger\Config;

/**
 * Class JaegerConfig
 * @package RancherizeJaeger\Config
 */
class JaegerConfig {

	/**
	 * @var bool
	 */
	protected $enabled = false;

    /**
     * @var string
     */
	protected $jaegerMethod = 'grpc';

    /**
     * @var string
     */
	protected $jaegerHost = 'jaeger:14250';

	protected $image = 'jaegertracing/jaeger-agent:1.11';

	/**
	 * @return bool
	 */
	public function isEnabled(): bool {
		return $this->enabled;
	}

	/**
	 * @param bool $enabled
	 * @return JaegerConfig
	 */
	public function setEnabled( bool $enabled ): JaegerConfig {
		$this->enabled = $enabled;
		return $this;
	}

    /**
     * @return string
     */
    public function getJaegerMethod(): string
    {
        return $this->jaegerMethod;
    }

    /**
     * @param string $jaegerMethod
     * @return JaegerConfig
     */
    public function setJaegerMethod(string $jaegerMethod): JaegerConfig
    {
        $this->jaegerMethod = $jaegerMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getJaegerHost(): string
    {
        return $this->jaegerHost;
    }

    /**
     * @param string $jaegerHost
     * @return JaegerConfig
     */
    public function setJaegerHost(string $jaegerHost): JaegerConfig
    {
        $this->jaegerHost = $jaegerHost;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
    }

}