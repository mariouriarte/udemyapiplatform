<?php
declare(strict_types=1);

namespace App\Controller\Listener;

use DateTimeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class JsonExceptionResponseTransformerListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpExceptionInterface) {
            $data = [
                'class' => \get_class($exception),
                'code'=> $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];

            $event->setResponse($this->prepareResponse($data));
        }
    }

    private function prepareResponse(array $data): JsonResponse
    {
        $response = new JsonResponse($data, $data['code']);
        $time = new \DateTime();
        $response->headers->set('Server-Time', $time->format(DateTimeInterface::ATOM));
        $response->headers->set('X-Error-Code', strval($data['code']));

        return $response;
    }

}
