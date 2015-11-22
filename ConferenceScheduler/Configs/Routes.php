<?php 
namespace ConferenceScheduler\Configs; 
class Routes { 
	 public static $lastCheck = '2015-11-22 14:19:35';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'myConferences',
			 'route' => 'me/conferences',
			 'annotations' => [
				'route' => 'me/conferences',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'edit',
			 'route' => 'conference/{int id}/edit',
			 'annotations' => [
				'route' => 'conference/{int id}/edit',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'manage',
			 'route' => 'conference/{int id}/lectures/manage',
			 'annotations' => [
				'route' => 'conference/{int id}/lectures/manage',
				'authorize' => '1',
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
			 'action' => 'register',
			 'route' => 'account/register',
			 'annotations' => [
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
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'create',
			 'route' => 'conference/create',
			 'annotations' => [
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'myConferences',
			 'route' => 'conference/myConferences',
			 'annotations' => [
				'route' => 'me/conferences',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'edit',
			 'route' => 'conference/edit',
			 'annotations' => [
				'route' => 'conference/{int id}/edit',
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
			 'action' => 'manage',
			 'route' => 'lectures/manage',
			 'annotations' => [
				'route' => 'conference/{int id}/lectures/manage',
				'authorize' => '1',
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