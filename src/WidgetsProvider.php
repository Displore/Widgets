<?php

namespace Displore\Widgets;

class WidgetsProvider
{
    /**
     * Providers are the files that provide a widget.
     * 
     * @var array
     */
    protected $providers;

    /**
     * This matches widget names with their providers.
     * 
     * @var array
     */
    protected $widgets;

    /**
     * Construct a new instance.
     * 
     * @param array      $providers
     * @param array|null $cachedWidgets
     */
    public function __construct(array $providers, array $cachedWidgets = null)
    {
        $this->providers = $providers;
        if ( ! is_null($cachedWidgets)) {
            $this->widgets = $cachedWidgets;
        }
    }

    /**
     * Set a new widget.
     * 
     * @param string $name
     * @param string $provider
     */
    public function set($name, $provider)
    {
        $this->widgets[$name] = $provider;
    }

    /**
     * Get a widget.
     * 
     * @param string     $name
     * @param array|null $parameters
     *
     * @throws WidgetNotFoundException
     */
    public function get($name, array $parameters = null)
    {
        if (isset($this->widgets[$name])) {
            return $this->widgets[$name]->getWidget($parameters);
        } elseif (isset($this->providers[$name])) {
            return $this->getProvider($name)->getWidget($parameters);
        }
        throw new \Exception('Widget not found');
    }

    /**
     * Get the provider for the widget.
     * 
     * @param string $widget
     *
     * @return object
     */
    public function getProvider($widget)
    {
        return $this->widgets[$widget] = new $this->providers[$widget]();
    }

    /**
     * Get all registered widgets.
     * 
     * @return array
     */
    public function getWidgets()
    {
        return $this->widgets;
    }
}
