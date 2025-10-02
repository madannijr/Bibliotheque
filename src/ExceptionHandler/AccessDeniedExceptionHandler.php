<?php

namespace App\ExceptionHandler;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AccessDeniedExceptionHandler
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedHttpException) {

            $message = 'Vous n\'êtes pas autorisé à accéder à cette ressource.';

            $response = new Response($message, Response::HTTP_FORBIDDEN);

            $event->setResponse($response);
        }
    }


}

