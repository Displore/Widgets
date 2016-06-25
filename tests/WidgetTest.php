<?php

include 'widgets/Headline.php';

use Displore\Widgets\WidgetsProvider;
use Displore\Widgets\DynamicWidgetsProvider;

class WidgetTest extends TestCase
{
    public function test_basic_get_widget()
    {
        $providers = [
            'headline'  =>  Test\Widgets\Headline::class,
        ];

        $service = new WidgetsProvider($providers);

        $widget = $service->get('headline');

        $this->assertEquals('Hello world', $widget);
    }

    public function test_basic_set_widget()
    {
        $providers = [];

        $service = new WidgetsProvider($providers);

        $widget = $service->set('headline', new Test\Widgets\Headline);
        $widget = $service->get('headline');

        $this->assertEquals('Hello world', $widget);
    }

    public function test_dynamic_get_widget()
    {
        $class = (new ReflectionClass(new Test\Widgets\Headline))->getFileName();
        $dir = dirname($class);

        $service = (new DynamicWidgetsProvider)
                    ->withPath($dir)
                    ->withNamespace('Test\\Widgets')
                    ->scanForProviders();

        $widget = $service->get('Headline');

        $this->assertEquals('Hello world', $widget);
    }

    public function test_dynamic_set_widget()
    {
        $class = (new ReflectionClass(new Test\Widgets\Headline))->getFileName();
        $dir = dirname($class);

        $service = (new DynamicWidgetsProvider)
                    ->withPath($dir)
                    ->withNamespace('Test\\Widgets')
                    ->scanForProviders();

        $widget = $service->set('head-line', new Test\Widgets\Headline);
        $widget = $service->get('head-line');

        $this->assertEquals('Hello world', $widget);
    }
}
