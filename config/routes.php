<?php
// Router::plugin(
//     'PbxManager',
//     ['path' => '/pbx-manager'],
//     function (RouteBuilder $routes) {
//         $routes->fallbacks(DashedRoute::class);
//     }
// );

Router::connect('/pbx-manager',array(
		'plugin' => 'PbxManager',
		'controller' => 'Recording',
		'action' => 'index'
));
Router::connect('/pbx-manager/admin',array(
		'plugin' => 'PbxManager',
		'controller' => 'Admin',
		'action' => 'index'
));