<?php 
namespace ConferenceScheduler\Configs; 
class Routes { 
	 public static $lastCheck = '2015-11-20 09:43:25';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'getOne',
			 'route' => 'lectures/pesho',
			 'annotations' => [
				'route' => 'lectures/pesho',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Areas\Admin\Controllers\AdminController',
			 'action' => 'index',
			 'route' => 'admin/KillThemAll',
			 'annotations' => [
				'route' => 'admin/killthemall',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\AccountController',
			 'action' => 'login',
			 'route' => 'account/login',
			 'annotations' => [
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\AccountController',
			 'action' => 'logout',
			 'route' => 'account/logout',
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
				'route' => 'lectures/pesho',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Areas\Admin\Controllers\AdminController',
			 'action' => 'index',
			 'route' => 'admin/admin/index',
			 'annotations' => [
				'route' => 'admin/killthemall',
			 ]
		 ], 
	 ]; 
}
?>