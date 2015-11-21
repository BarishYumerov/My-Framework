<?php

namespace ConferenceScheduler\Core\Router;

use ReflectionClass as ReflectionClass;
use ReflectionMethod as ReflectionMethod;

class RoutesFinder{

    public static function getRoutes()
    {
        $allRoutes = [];

        $routes = self::findRoutes();
        $areaRoutes = self::findAreaRoutes();

        if ($routes !== null) {
            $allRoutes = array_merge($allRoutes, $routes['annotationRoutes']);
        }

        if($allRoutes !== null){
            $allRoutes = array_merge($allRoutes, $areaRoutes['annotationRoutes']);
        }

        $allRoutes = array_merge($allRoutes, $routes['routes']);
        $allRoutes = array_merge($allRoutes, $areaRoutes['routes']);

        self::createRoutesConfig($allRoutes);
    }

    private static function findRoutes(){
        $controllers = [];
        $routes = [];
        $annotationRoutes = [];

        if(!file_exists(CONTROLLERS_NAMESPACE)){
            return null;
        }

        $controllersFolder = opendir(CONTROLLERS_NAMESPACE);
        $controllerFile = readdir($controllersFolder);

        while($controllerFile){
            if ($controllerFile[0] == '.') {
                $controllerFile = readdir($controllersFolder);
                continue;
            }

            if(strpos($controllerFile, 'Base')){
                $controllerFile = readdir($controllersFolder);
                continue;
            }

            $controllers[] = substr($controllerFile, 0, strlen($controllerFile) - 4);
            $controllerFile = readdir($controllersFolder);
        }

        foreach ($controllers as $controller) {
            $controllerName = APPLICATION_NAME . '\\' . CONTROLLERS_NAMESPACE . '\\'. $controller;

            $class = new ReflectionClass($controllerName);
            $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                if(strpos($method->class, 'BaseController') === false &&
                    $method->name !== '__construct') {

                    $annotations = self::getAnnotationsForMethod($method);

                    $controllerRouteName = end(explode('\\', $controllerName));

                    $routes[] = [
                        'controller' => $controllerName,
                        'action' => $method->name,
                        'route' => strtolower(str_replace('Controller', '', $controllerRouteName)) . '/' . $method->name,
                        'annotations' => $annotations == null? [] : $annotations
                    ];
                    $annotationRoute = self::getRouteForMethod($method);
                    if ($annotationRoute !== null) {
                        $annotationRoutes[] = [
                            'controller' => $controllerName,
                            'action' => $method->name,
                            'route' => $annotationRoute,
                            'annotations' => $annotations == null? [] : $annotations
                        ];
                    }
                }
            }
        }

        closedir($controllersFolder);

        return [
            'routes' => $routes,
            'annotationRoutes' => $annotationRoutes
        ];
    }

    private static function findAreaRoutes()
    {
        $routes = [];
        $annotationRoutes = [];

        if (!file_exists(AREAS_NAMESPACE)) {
            return null;
        }

        $areasFile = opendir(AREAS_NAMESPACE);
        $areaName = readdir($areasFile);
        while ($areaName) {
            if ($areaName[0] == '.') {
                $areaName = readdir($areasFile);
                continue;
            }

            $controllersDirHandle = opendir(AREAS_NAMESPACE . '/' . $areaName . '/' . 'Controllers');
            if ($controllersDirHandle === null) {
                continue;
            }

            $file = readdir($controllersDirHandle);
            while ($file) {
                if ($file[0] == '.') {
                    $file = readdir($controllersDirHandle);
                    continue;
                }

                $className = substr($file, 0, strlen($file) - 4);
                $fullControllerName = APPLICATION_NAME . DIRECTORY_SEPARATOR . AREAS_DIR
                    . $areaName . '\\Controllers\\' . $className;

                $route = strtolower($areaName) . '/' . strtolower(str_replace('Controller', '', $className));

                $class = new ReflectionClass($fullControllerName);
                $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

                foreach ($methods as $method) {
                    if(strpos($method->class, 'BaseController') === false &&
                        $method->name !== '__construct') {

                        $annotations = self::getAnnotationsForMethod($method);

                        $routes[] = [
                            'controller' => $fullControllerName,
                            'action' => $method->name,
                            'route' => $route . '/' . $method->name,
                            'annotations' => $annotations == null? [] : $annotations
                        ];

                        $annotationRoute = self::getRouteForMethod($method);
                        if ($annotationRoute !== null) {
                            $annotationRoutes[] = [
                                'controller' => $fullControllerName,
                                'action' => $method->name,
                                'route' => $annotationRoute,
                                'annotations' => $annotations == null? [] : $annotations
                            ];
                        }
                    }
                }

                $file = readdir($controllersDirHandle);
            }

            closedir($controllersDirHandle);
            $areaName = readdir($areasFile);
        }
        closedir($areasFile);

        return [
            'routes' => $routes,
            'annotationRoutes' => $annotationRoutes
        ];
    }

    private static function getRouteForMethod(ReflectionMethod $method)
    {
        $comments = $method->getDocComment();
        preg_match("/@Route\(\"(.+)\"\)/", $comments, $matches);
        if (count($matches) > 0) {
            return $matches[1];
        }
        return null;
    }

    private static function getAnnotationsForMethod(ReflectionMethod $method)
    {
        $annotations = [];
        $annotationsText = $method->getDocComment();
        preg_match_all("/@([a-zA-Z]+)\([\"\'](.+)[\"\']\)/m", $annotationsText, $matches);
        if (count($matches) > 0) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                $key = strtolower($matches[1][$i]);
                $annotations[$key] = strtolower($matches[2][$i]);
            }
        }

        preg_match("/@Authorize/m", $annotationsText, $matches);
        if (count($matches) > 0) {
            $annotations['authorize'] = true;
        }

        if (count($annotations) > 0) {
            return $annotations;
        }

        return null;
    }

    private static function createRoutesConfig($routes)
    {
        $routeConfigFile = fopen(ROUTES, "w") or die("Unable to open Routes.php!");

        fwrite($routeConfigFile, "<?php \n");
        fwrite($routeConfigFile, "namespace " . APPLICATION_NAME . "\\Configs; \n");
        fwrite($routeConfigFile, "class Routes { \n");

        $currentDate = new \DateTime();
        $txt = "\t public static \$lastCheck = '" . $currentDate->format('Y-m-d H:i:s') . "';\n\n";
        fwrite($routeConfigFile, $txt);

        fwrite($routeConfigFile, "\t public static \$ROUTES = [ \n");
        foreach ($routes as $route) {

            $routeText = $route['route'];
            $controllerText = $route['controller'];
            $actionText = $route['action'];

            $annotationText = "\t\t\t 'annotations' => [\n";
            foreach ($route['annotations'] as $key => $value) {
                $valuesArray = explode(", ", $value);
                if (count($valuesArray) > 1) {
                    $annotationText .= "\t\t\t\t'" . $key . "' => ['" . implode(", ", $valuesArray) . "'],\n";
                } else {
                    $annotationText .= "\t\t\t\t'" . $key . "' => '" . $value . "',\n";
                }
            }
            $annotationText .= "\t\t\t ]\n";

            fwrite($routeConfigFile, "\t\t [ \n");
            fwrite($routeConfigFile, "\t\t\t 'controller' => '" . $controllerText . "',\n");
            fwrite($routeConfigFile, "\t\t\t 'action' => '" . $actionText . "',\n");
            fwrite($routeConfigFile, "\t\t\t 'route' => '" . $routeText . "',\n");
            fwrite($routeConfigFile, $annotationText);

            fwrite($routeConfigFile, "\t\t ], \n");
        }

        fwrite($routeConfigFile, "\t ]; \n");
        fwrite($routeConfigFile, "}\n");
        fwrite($routeConfigFile, "?>");

        fclose($routeConfigFile);
    }
}