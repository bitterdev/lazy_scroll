<?php

namespace Bitter\LazyScroll\Routing;

use Bitter\LazyScroll\API\V1\Middleware\FractalNegotiatorMiddleware;
use Bitter\LazyScroll\API\V1\Configurator;
use Concrete\Core\Routing\RouteListInterface;
use Concrete\Core\Routing\Router;

class RouteList implements RouteListInterface
{
    public function loadRoutes(Router $router)
    {
        $router
            ->buildGroup()
            ->setNamespace('Concrete\Package\LazyScroll\Controller\Dialog\Support')
            ->setPrefix('/ccm/system/dialogs/lazy_scroll')
            ->routes('dialogs/support.php', 'lazy_scroll');
    }
}