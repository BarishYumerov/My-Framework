<?php 
namespace ConferenceScheduler\Configs; 
class Routes { 
	 public static $lastCheck = '2015-11-18 17:52:52';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\AccountController',
			 'action' => 'getOne',
			 'route' => 'account/{int id}/get',
			 'annotations' => [
				'route' => 'account/{int id}/get',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'getOne',
			 'route' => 'lectures/pesho',
			 'annotations' => [
				'route' => 'lectures/pesho',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\AccountController',
			 'action' => 'getAll',
			 'route' => 'account/getAll',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\AccountController',
			 'action' => 'getOne',
			 'route' => 'account/getOne',
			 'annotations' => [
				'route' => 'account/{int id}/get',
				'authorize' => '1',
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
				'route' => 'lectures/pesho',
			 ]
		 ], 
	 ]; 
}
?>