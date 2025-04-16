<?php

namespace Bitter\LazyScroll\Provider;

use Concrete\Core\Application\Application;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Foundation\Service\Provider;
use Concrete\Core\Page\Page;
use Concrete\Core\Routing\RouterInterface;
use Bitter\LazyScroll\Routing\RouteList;
use Concrete\Core\Site\Config\Liaison;
use Concrete\Core\Site\Service;
use Concrete\Core\View\View;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ServiceProvider extends Provider
{
    protected RouterInterface $router;
    protected EventDispatcherInterface $eventDispatcher;
    protected Liaison $siteConfig;

    public function __construct(
        Application              $app,
        RouterInterface          $router,
        EventDispatcherInterface $eventDispatcher,
        Service                  $siteService
    )
    {
        parent::__construct($app);

        $this->router = $router;
        $this->eventDispatcher = $eventDispatcher;

        $this->siteConfig = $siteService->getActiveSiteForEditing()->getConfigRepository();
    }

    public function register()
    {
        $this->registerRoutes();
        $this->registerAssets();
        $this->registerEventHandlers();
    }

    private function registerAssets()
    {
        $al = AssetList::getInstance();

        $al->register("javascript", "lazy-scroll", "js/lazy-scroll.js", [], "lazy_scroll");
        $al->register("css", "lazy-scroll", "css/lazy-scroll.css", [], "lazy_scroll");
        $al->registerGroup("lazy-scroll", [
            ["javascript", "lazy-scroll"],
            ["css", "lazy-scroll"]
        ]);
    }

    private function registerEventHandlers()
    {
        $this->eventDispatcher->addListener("on_before_render", function () {
            $c = Page::getCurrentPage();

            if ($c instanceof Page && !$c->isError() && !$c->isSystemPage()) {
                $v = View::getInstance();

                $v->requireAsset("javascript", "jquery");
                $v->requireAsset("lazy-scroll");

                /** @noinspection JSUnresolvedVariable, BadExpressionStatementJS */
                $v->addFooterAsset(
                    sprintf(
                        "<script>(function($) { $(function(){ $(\".ccm-page\").initSmoothScroll(%s) }) })(jQuery);</script>",
                        json_encode([
                            "scrollDuration" => (int)$this->siteConfig->get("lazy_scroll.scroll_duration", 1200)
                        ])
                    )
                );
            }
        });
    }

    private function registerRoutes()
    {
        $this->router->loadRouteList(new RouteList());
    }
}