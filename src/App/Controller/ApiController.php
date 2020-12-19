<?php

declare(strict_types=1);

namespace App\Controller;

use App\Queue\Status;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use ProductsCatalog\Shared\Uid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class ApiController extends AbstractFOSRestController
{
    private const CACHE_MAX_AGE = 3600;

    protected function prepareValidationErrorsResponse(ConstraintViolationListInterface $validationErrors): Response
    {
        $messages = $this->prepareErrorMessages($validationErrors);

        return $this->handleView(
            $this->view(
                [
                    'code' => 400,
                    'error' => 'Validation error',
                    'messages' => $messages
                ],
                Response::HTTP_BAD_REQUEST
            )
        );
    }

    /**
     * @return string[]
     */
    private function prepareErrorMessages(ConstraintViolationListInterface $validationErrors): array
    {
        $messages = [];
        foreach ($validationErrors as $violation) {
            $messages[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $messages;
    }

    protected function preparePostSuccessResponse(Status $status, Uid $uid): Response
    {
        return $this->handleView(
            $this->view(
                [
                    '_links' => [
                      'status' => [
                          'href' => '//example.com/api/products/status/'.$uid
                      ]
                    ],
                    'status' => $status,
                    'uid' => $uid
                ],
                Response::HTTP_ACCEPTED,
                [
                    'Cache-Control' => 'no-cache, no-store, private',
                    'Pragma' => 'no-cache',
                    'Expires' => 0
                ]
            )
        );
    }

    protected function prepareNotFoundResponse(): Response
    {
        return $this->handleView(
            $this->view(
                null,
                Response::HTTP_NOT_FOUND
            )
        );
    }

    protected function prepareGetSuccessResponse($data, \DateTimeInterface $lastModified): Response
    {
        $expiresDate = new \DateTime('UTC');
        $interval = new \DateInterval(sprintf('PT%sS', self::CACHE_MAX_AGE));
        $expiresDate->add($interval);

        return $this->handleView(
            $this->view(
                $data,
                Response::HTTP_OK,
                [
                    'Last-Modified' => $lastModified->format('D, d M Y H:i:s \G\M\T'),
                    'Cache-Control' => sprintf('max-age=%s', self::CACHE_MAX_AGE),
                    'Expires' => $expiresDate->format('D, d M Y H:i:s \G\M\T'),
                ]
            )
        );
    }
}
