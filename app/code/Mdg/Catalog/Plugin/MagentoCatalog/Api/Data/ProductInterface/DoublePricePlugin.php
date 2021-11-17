<?php

declare(strict_types=1);

namespace Mdg\Catalog\Plugin\MagentoCatalog\Api\Data\ProductInterface;

use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Doubling of product price.
 * Doubles product price on retrieving from product model.
 */
class DoublePricePlugin
{
    /**
     * @param ProductInterface $product
     * @param $price
     * @return float
     */
    public function afterGetPrice(ProductInterface $product, $price): float
    {
        $doublePrice = $price * 2;

        return (float)$doublePrice;
    }
}

