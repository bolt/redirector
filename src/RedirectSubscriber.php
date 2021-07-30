<?php

declare(strict_types=1);

namespace BoltRedirector;

use Bolt\Widget\Injector\RequestZone;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RedirectSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (! RequestZone::isForFrontend($request)) {
            return;
        }

        $locations = [
            $request->getUri(),
            $request->getPathInfo()
        ];

        $redirect = $this->redirector->findFor($locations);

        if ($redirect) {
            $event->setResponse(new RedirectResponse($redirect));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]]
        ];
    }
}
