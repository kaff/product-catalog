<?php

declare(strict_types=1);

namespace App\Controller;

use App\Presenter\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use ProductsCatalog\Application\UseCase;
use ProductsCatalog\Shared\Uid;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ProductsController extends ApiController
{
    private const ROUTE_PRODUCTS_GET = 'app_products_getproducts';

    /** @var UseCase\AddNewProduct */
    private $addNewProductUseCase;

    /** @var Product\Presenter */
    private $productPresenter;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        UseCase\AddNewProduct $addNewProductUseCase,
        Product\Presenter $productPresenter,
        LoggerInterface $logger
    ) {
        $this->addNewProductUseCase = $addNewProductUseCase;
        $this->productPresenter = $productPresenter;
        $this->logger = $logger;
    }

    /**
     * @Rest\Route(
     *     "api/products",
     *     format="json",
     *     condition="request.attributes.get('version') == 'v1'",
     *     methods={"POST"}
     * )
     * @ParamConverter("request", converter="fos_rest.request_body")
     */
    public function postProductsAction(
        UseCase\AddNewProduct\Request $request,
        ConstraintViolationListInterface $validationErrors
    ) {
        try {
            if ($validationErrors->count()) {
                return $this->prepareValidationErrorsResponse($validationErrors);
            }

            $response = $this->addNewProductUseCase->execute($request);
            $productViewObject = $this->productPresenter->present($response);

            return $this->preparePostSuccessResponse(
                $productViewObject,
                $this->prepareLocationHeader($response->product->getUid())
            );
        } catch (\Throwable $error) {
            $this->logger->error($error);
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
        //method is needed for proper URL generation for Location header
    }

    private function prepareLocationHeader(Uid $uid)
    {
        return $this->generateUrl(
            self::ROUTE_PRODUCTS_GET,
            [
                'uid' => $uid
            ]
        );
    }
}
