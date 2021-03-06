<?php

namespace Application\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteStackInterface;
use Zend\Stdlib\RequestInterface;

class RouteListener extends AbstractListenerAggregate
{
    const REDIRECT_STATUS_CODE = 302;

    /** @var RouteStackInterface */
    protected $router;

    /** @var RequestInterface */
    protected $request;

    /** @var TranslatorInterface */
    protected $translator;


    /**
     * RouteListener constructor.
     *
     * @param RouteStackInterface $router
     * @param RequestInterface $request
     * @param TranslatorInterface $translator
     * @param PersistStrategyService $persistStrategyService
     */
    public function __construct(
        RouteStackInterface $router,
        RequestInterface $request,
        TranslatorInterface $translator
    ) {
        $this->router                 = $router;
        $this->request                = $request;
        $this->translator             = $translator;
    }

    public function attach(EventManagerInterface $events, $priority = 10)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE, [$this, 'onRoute'], $priority
        );
    }

    public function onRoute(MvcEvent $e)
    {
        /** @var LanguageTreeRouteStack $router */
        $router = $this->router;

        if (! $router instanceof LanguageTreeRouteStack) {
            return;
        }
        $routeMatch = $router->match($this->request);
        $locale     = $router->getLastMatchedLocale();
        $redirect   = $router->getRedirect();

        if (empty($locale)) {
            return;
        }

        $response = $e->getResponse();
        $response = $this->persistStrategyService->saveLocale(
            $locale, $response
        );

        if ($redirect) {
            $response->setStatusCode(self::REDIRECT_STATUS_CODE);
            $response->getHeaders()->addHeaderLine('Location', $redirect);

            return $response;
        }

        if (is_callable([$this->translator, 'setLocale'])) {
            $this->translator->setLocale($locale);
        }
    }
}
