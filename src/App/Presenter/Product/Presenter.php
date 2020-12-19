<?php

declare(strict_types=1);

namespace App\Presenter\Product;

use ProductsCatalog\Application\Query\GetProduct\DTO;

final class Presenter
{
    public function present(DTO\Product $product): ViewObject
    {
        $view = new ViewObject();
        $view->uid = (string) $product->uid;
        $view->priceAmount = $product->price->getAmount();
        $view->priceCurrency = (string) $product->price->getCurrency();
        $view->name = $product->name;

        return $view;
    }
}
