<?php

namespace App\EventSubscriber;

use App\Todo\Domain\Exceptions\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onExceptionEvent(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        $response = new JsonResponse($message);

        if ($exception instanceof ValidationException) {
            $response->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } else if ($exception instanceof \LogicException) {
            $response->setStatusCode(JsonResponse::HTTP_CONFLICT);
        }

        $event->setResponse($response);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onExceptionEvent'
        ];
    }
}