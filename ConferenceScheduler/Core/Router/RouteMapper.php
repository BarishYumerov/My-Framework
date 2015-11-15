<?php

namespace ConferenceScheduler\Core\Router;

use ConferenceScheduler\Configs\Routes;

class RouteMapper
{
    public static function map($route)
    {
        foreach (Routes::$ROUTES as $existingRoute) {
            if (strpos($existingRoute['route'], '{') === false) {
                if (strtolower($route) === strtolower($existingRoute['route'])) {
                    return $existingRoute;
                }
            } else {
                $parameterRoute = new ParameterRoute($existingRoute['route']);
                if ($parameterRoute->isMatching($route)) {
                    $existingRoute['parameters'] = $parameterRoute->parameterValues;
                    return $existingRoute;
                }
            }
        }
        return false;
    }
}