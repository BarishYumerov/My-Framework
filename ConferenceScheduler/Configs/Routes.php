<?php 
namespace ConferenceScheduler\Configs; 
class Routes { 
	 public static $lastCheck = '2015-11-28 12:54:24';

	 public static $ROUTES = [ 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'remove',
			 'route' => 'conference/{int id}/remove/admin/{int id}',
			 'annotations' => [
				'route' => 'conference/{int id}/remove/admin/{int id}',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'admins',
			 'route' => 'conference/{int id}/admins/manage',
			 'annotations' => [
				'route' => 'conference/{int id}/admins/manage',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'details',
			 'route' => 'conference/{int id}/details',
			 'annotations' => [
				'route' => 'conference/{int id}/details',
			 ]
		 ], 
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
			 'action' => 'myAdmin',
			 'route' => 'me/conferences/admin',
			 'annotations' => [
				'route' => 'me/conferences/admin',
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
			 'controller' => 'ConferenceScheduler\Application\Controllers\HomeController',
			 'action' => 'invites',
			 'route' => 'me/invites',
			 'annotations' => [
				'route' => 'me/invites',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\HomeController',
			 'action' => 'mySchedule',
			 'route' => 'me/schedule',
			 'annotations' => [
				'route' => 'me/schedule',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\InvitesController',
			 'action' => 'accept',
			 'route' => 'invite/{int id}/accept',
			 'annotations' => [
				'route' => 'invite/{int id}/accept',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\InvitesController',
			 'action' => 'decline',
			 'route' => 'invite/{int id}/decline',
			 'annotations' => [
				'route' => 'invite/{int id}/decline',
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
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'add',
			 'route' => 'conference/{int id}/add/lecture',
			 'annotations' => [
				'route' => 'conference/{int id}/add/lecture',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'edit',
			 'route' => 'lecture/{int id}/manage',
			 'annotations' => [
				'route' => 'lecture/{int id}/manage',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'removeSpeaker',
			 'route' => 'lecture/{int id}/remove/speaker/{int id}',
			 'annotations' => [
				'route' => 'lecture/{int id}/remove/speaker/{int id}',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'inviteSpeaker',
			 'route' => 'lecture/{int id}/invite/speaker',
			 'annotations' => [
				'route' => 'lecture/{int id}/invite/speaker',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'addVisit',
			 'route' => 'lecture/{int id}/visit',
			 'annotations' => [
				'route' => 'lecture/{int id}/visit',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'notVisit',
			 'route' => 'lecture/{int id}/notvisit',
			 'annotations' => [
				'route' => 'lecture/{int id}/notvisit',
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
			 'action' => 'remove',
			 'route' => 'conference/remove',
			 'annotations' => [
				'route' => 'conference/{int id}/remove/admin/{int id}',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'admins',
			 'route' => 'conference/admins',
			 'annotations' => [
				'route' => 'conference/{int id}/admins/manage',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\ConferenceController',
			 'action' => 'details',
			 'route' => 'conference/details',
			 'annotations' => [
				'route' => 'conference/{int id}/details',
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
			 'action' => 'myAdmin',
			 'route' => 'conference/myAdmin',
			 'annotations' => [
				'route' => 'me/conferences/admin',
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
			 'controller' => 'ConferenceScheduler\Application\Controllers\HomeController',
			 'action' => 'invites',
			 'route' => 'home/invites',
			 'annotations' => [
				'route' => 'me/invites',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\HomeController',
			 'action' => 'mySchedule',
			 'route' => 'home/mySchedule',
			 'annotations' => [
				'route' => 'me/schedule',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\InvitesController',
			 'action' => 'accept',
			 'route' => 'invites/accept',
			 'annotations' => [
				'route' => 'invite/{int id}/accept',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\InvitesController',
			 'action' => 'decline',
			 'route' => 'invites/decline',
			 'annotations' => [
				'route' => 'invite/{int id}/decline',
				'authorize' => '1',
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
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'add',
			 'route' => 'lectures/add',
			 'annotations' => [
				'route' => 'conference/{int id}/add/lecture',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'edit',
			 'route' => 'lectures/edit',
			 'annotations' => [
				'route' => 'lecture/{int id}/manage',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'removeSpeaker',
			 'route' => 'lectures/removeSpeaker',
			 'annotations' => [
				'route' => 'lecture/{int id}/remove/speaker/{int id}',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'inviteSpeaker',
			 'route' => 'lectures/inviteSpeaker',
			 'annotations' => [
				'route' => 'lecture/{int id}/invite/speaker',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'addVisit',
			 'route' => 'lectures/addVisit',
			 'annotations' => [
				'route' => 'lecture/{int id}/visit',
				'authorize' => '1',
			 ]
		 ], 
		 [ 
			 'controller' => 'ConferenceScheduler\Application\Controllers\LecturesController',
			 'action' => 'notVisit',
			 'route' => 'lectures/notVisit',
			 'annotations' => [
				'route' => 'lecture/{int id}/notvisit',
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