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
}
