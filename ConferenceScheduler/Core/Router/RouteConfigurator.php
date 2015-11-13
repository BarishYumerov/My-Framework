<?php

namespace ConferenceScheduler\Core\Router;

class RouteCreator{

    public static function getRoutes()
    {
        $allRoutes = [];

        $routes = self::findRoutes();

        if ($routes !== null) {
            $allRoutes = array_merge($allRoutes, $routes['annotationRoutes']);
        }

        $allRoutes = array_merge($allRoutes, $areaRoutes['routes']);
        $allRoutes = array_merge($allRoutes, $routes['routes']);

        self::createRoutesConfig($allRoutes);
    }

    private static function findRoutes(){

    }
}