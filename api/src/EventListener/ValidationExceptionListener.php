<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ValidationExceptionListener
{
    public function __construct(
        protected NormalizerInterface $serializer,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // A bit of a quirk because Symfony turns ValidationFailedException into NotFoundHttpException when MapQueryString has validation errors
        // This checks if it's a NotFoundHttpException caused by a ValidationFailedException and allows returning JSON on the API response
        if ($exception instanceof NotFoundHttpException && $exception->getPrevious() instanceof ValidationFailedException) {
            /** @var ValidationFailedException $validationException */
            $validationException = $exception->getPrevious();
            $response = new JsonResponse($this->serializer->normalize($validationException, 'json'), Response::HTTP_BAD_REQUEST);

            $event->setResponse($response);
        }
    }
}
