<?php 
namespace ConferenceScheduler\Configs; 
class Routes { 
	 public static $lastCheck = '2015-11-14 14:50:36';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\AccountController',
			 'action' => 'getAll',
			 'route' => 'account/getAll',
			 'annotations' => [
				'route' => 'pesho/all',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\AccountController',
			 'action' => 'getOne',
			 'route' => 'account/getOne',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\HomeController',
			 'action' => 'index',
			 'route' => 'home/index',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'getAll',
			 'route' => 'lectures/getAll',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'getOne',
			 'route' => 'lectures/getOne',
			 'annotations' => [
				'route' => 'lectures/{int id}/details',
			 ]
		 ], 
	 ]; 
}
?>