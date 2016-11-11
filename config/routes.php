<?php

Router::plugin(
    'PbxManager',
    ['path' => '/pbx-manager'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
