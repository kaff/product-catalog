<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ProductsController extends ApiController
{
    /**
     * @Rest\Route(
     *     "api/products",
     *     format="json",
     *     condition="request.attributes.get('version') == 'v1'",
     *     methods={"POST"}
     * )
     * @ParamConverter("post", converter="fos_rest.request_body")
     */
    public function postProductsAction(
        Rest\Post $post,
        ConstraintViolationListInterface $validationErrors
    ) {
        try {
            if($validationErrors->count()) {
                return $this->prepareValidationErrorsResponse($validationErrors);
            }
            
            return $this->preparePostSuccessResponse(['test'], $this->prepareLocationHeader());
        } catch (\Error $error) {
            $this->logError($error);
            throw new \RuntimeException('Internal error');
        }
    }

    /**
     *
     * @Rest\Route(
     *     "api/products/{uid}",
     *     format="json",
     *     methods={"GET"}
     * )
     */
    public function getProductsAction($uid)
    {
        //not implemented yet
        //method needed for proper URL generation for Location header
    }

    private function prepareLocationHeader()
    {
        return $this->generateUrl(
            'app_products_getproducts',
            [
                'uid' => '__SOME__UID__'
            ]
        );
    }
}
