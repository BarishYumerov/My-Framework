<?php
declare(strict_types=1);

namespace ConferenceScheduler\Core\Router;

use ConferenceScheduler\Configs\Routes;

class RouteMapper
{
    public static function map(string $route)
    {
        foreach (Routes::$ROUTES as $existingRoute) {
            if (strpos($existingRoute['route'], '{') === false) {
                if (strtolower($route) === strtolower($existingRoute['route'])) {
                    return $existingRoute;
                }
            } else {
                $parameterRoute = new ParameterRoute($existingRoute['route']);
                if ($parameterRoute->isMatching(strtolower($route))) {
                    $existingRoute['parameters'] = $parameterRoute->parameterValues;
                    return $existingRoute;
                }
            }
        }
        return false;
    }
}