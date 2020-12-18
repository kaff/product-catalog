<?php

declare(strict_types=1);

namespace ProductsCatalog\Application\Command;

use ProductsCatalog\Application\Bus\CommandBus\Command;
use ProductsCatalog\Application\Bus\CommandBus\CommandHandler;
use ProductsCatalog\Application\Repository\ProductRepository;
use ProductsCatalog\Domain\Currency;
use ProductsCatalog\Domain\Money;
use ProductsCatalog\Domain\Product;
use ProductsCatalog\Shared\Uid;

class AddNewProductHandler implements CommandHandler
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \ProductsCatalog\Application\Command\AddNewProductCommand $command
     */
    public function handle(Command $command): void
    {
        $product = new Product(
            $command->getName(),
            new Money(
                $command->getPriceAmount(),
                new Currency($command->getPriceCurrency())
            ),
            new Uid($command->getUid())
        );

        $this->productRepository->save($product);
        $creationDate = new \DateTime();
        $this->dispatchProductCreatedEvent($product, $creationDate);
    }

    private function dispatchProductCreatedEvent(Product $product, \DateTimeInterface $creationDate): void
    {
        //not implemented yet
    }
}
