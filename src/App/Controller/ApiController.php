<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
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

    /**
     * @param mixed $data
     */
    protected function preparePostSuccessResponse($data, string $locationHeader): Response
    {
        return $this->handleView(
            $this->view(
                $data,
                Response::HTTP_CREATED,
                [
                    'Location' => $locationHeader,
                    'Cache-Control' => 'no-cache, no-store, private',
                    'Pragma' => 'no-cache',
                    'Expires' => 0
                ]
            )
        );
    }
}
