<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\UseCase\Interactor;

use ProductsCatalog\Application\Repository\ProductRepository;
use ProductsCatalog\Application\UseCase\AddNewProduct;
use ProductsCatalog\Domain\Currency;
use ProductsCatalog\Domain\Money;
use ProductsCatalog\Domain\Product;

class Interactor implements AddNewProduct
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(AddNewProduct\Request $request): AddNewProduct\Response
    {
        $product = new Product(
            $request->name,
            new Money(
                $request->priceAmount,
                new Currency($request->priceCurrency)
            )
        );

        $this->productRepository->save($product);
        $creationDate = new \DateTime();
        $this->dispatchProductCreatedEvent($product, $creationDate);

        return $this->mapToResponse($product, $creationDate);
    }

    private function dispatchProductCreatedEvent(Product $product, \DateTimeInterface $creationDate): void
    {
        //not implemented yet
    }

    private function mapToResponse(Product $product, \DateTimeInterface $creationDate): AddNewProduct\Response
    {
        //it could be external mapper class
        $response = new AddNewProduct\Response();
        $response->product = clone $product;
        $response->creationDate = $creationDate;

        return $response;
    }
}
