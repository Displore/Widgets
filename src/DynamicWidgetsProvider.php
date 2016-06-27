<?php

namespace Displore\Widgets;

class DynamicWidgetsProvider
{
    /**
     * This matches widget names with their providers.
     * 
     * @var array
     */
    protected $widgets;

    /**
     * The path where the widget classes are.
     *
     * @var string
     */
    public $widgetPath;

    /**
     * The namespace for the widget classes.
     * 
     * @var string
     */
    public $namespace;

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
            return $this->getProvider($name)->getWidget($parameters);
        }
        throw new \Exception('Widget not found');
    }

    /**
     * Get the provider for the widget.
     * 
     * @param string $name
     *
     * @return object
     */
    public function getProvider($name)
    {
        return new $this->widgets[$name]();
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

    /**
     * Scan the widgets folder for classes.
     * 
     * @throws Exception
     *
     * @return $this
     */
    public function scanForProviders()
    {
        if ( ! isset($this->widgetPath)) {
            throw new \Exception('Widgets path not defined');
        }

        $files = glob($this->widgetPath.'/*.php');

        foreach ($files as $file) {
            $this->set($this->makeName($file), $this->makeProvider($file));
        }

        return $this;
    }

    /**
     * Make the name for the widget from its filepath.
     * 
     * @param string $file
     *
     * @return string
     */
    public function makeName($file)
    {
        return pathinfo($file, PATHINFO_FILENAME);
    }

    /**
     * Make the namespaced name of the widget provider class.
     * 
     * @param string $file
     *
     * @return string
     */
    public function makeProvider($file)
    {
        return $this->namespace.'\\'.$this->makeName($file);
    }

    /**
     * Define where to search for widgets.
     * 
     * @param string $widgetPath
     *
     * @throws Exception
     *
     * @return $this
     */
    public function withPath($widgetPath)
    {
        if (is_dir($widgetPath)) {
            $this->widgetPath = $widgetPath;

            return $this;
        }
        throw new \Exception('Widgets path not accessible');
    }

    /**
     * Define the widgets' namespace.
     * 
     * @param string $namespace
     *
     * @return $this
     */
    public function withNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }
}
