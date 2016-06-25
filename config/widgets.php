<?php

return [

    /*
     * Instead of using the providers array, the widget can be dynamically resolved.
     * This does however mean that all Widget files are cycled through on each request.
     * The path and namespace variables have to be set when dynamic resolving is turned on.
     */

    'dynamic' => false,

    'path' => app_path().'/Widgets',

    'namespace' => 'App\\Widgets',

    'providers' => [
        //'example' => App\Widgets\ExampleWidget::class,
    ],

];
