<?php namespace Maduser\Minimal\Services;

use Maduser\Minimal\Services\Exceptions\IocNotResolvableException;
use Maduser\Minimal\Services\Provider;

/**
 * Class Resolver
 *
 * @package AMaduser\Minimal\Services
 */
class Resolver
{
    /**
     * @var Provider
     */
    private $provider;

    /**
     * Resolver constructor.
     *
     * @param Provider $provider
     */
    public function __construct(
        Provider $provider
    ) {
        $this->provider = $provider;
    }

    /**
     * @param      $name
     * @param null $params
     *
     * @return mixed
     * @throws IocNotResolvableException
     */
    public function resolve($name, $params = null)
    {
        if ($registered = $this->provider->hasProvider($name)) {

            if (!is_object($registered) && !is_callable($registered)) {
                $registered = $this->provider->getInjector()
                                             ->make($registered, $params);
            }

            if ($this->isProvider($registered)) {
                return $registered->resolve($params);
            }

            return $registered;
        }

        throw new IocNotResolvableException($name, [
            'name' => $name,
            'params' => $params,
            'trace' => debug_backtrace(),
            'registry' => $this->provider->providers()
        ]);
    }

    /**
     * @param $instance
     *
     * @return bool
     */
    public function isProvider($instance)
    {
        return $instance instanceof Provider ||
            is_subclass_of($instance, \Maduser\Minimal\Providers\Provider::class);
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function registered($name)
    {
        if ($this->provider->hasSingleton($name)) {
            return $this->provider->getSingleton($name);
        }

        if ($this->provider->hasProvider($name)) {
            return $this->provider->getProvider($name);
        }

        return null;
    }

    /**
     * @param $name
     *
     * @return array|mixed|null
     */
    public function has($name)
    {
        return $this->provider->hasProvider($name);
    }

}