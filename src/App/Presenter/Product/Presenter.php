<?php

declare(strict_types=1);

namespace App\Presenter\Product;

use ProductsCatalog\Application\UseCase\AddNewProduct\Response;

final class Presenter
{
    public function present(Response $response): ViewObject
    {
        $view = new ViewObject();
        $view->uid = (string) $response->product->getUid();
        $view->priceAmount = $response->product->getPrice()->getAmount();
        $view->priceCurrency = (string) $response->product->getPrice()->getCurrency();
        $view->name = $response->product->getName();

        return $view;
    }
}
