<?php

declare(strict_types=1);

namespace Mdg\Catalog\Observer\CatalogProduct;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Event observer for the event "catalog_product_edit_action".
 * Adds the prefix to a product name or in case when the ProductCreated prefix was assigned replaces it.
 */
class ProductUpdated implements ObserverInterface
{
    /**
     * Prefix to apply.
     */
    private const PREFIX = 'EDITED ';

    /**
     * @inheritdoc
     */
    public function execute(Observer $observer)
    {
        /** @var ProductInterface $product */
        $product = $observer->getProduct();

        if ($product->getId()) {
            $this->updateProductNamePrefix($product);
        }
    }

    /**
     * Updates product's name prefix
     *
     * @param ProductInterface $product
     */
    private function updateProductNamePrefix(ProductInterface $product): void
    {
        $name = $product->getName();

        if (strstr($name, ProductCreated::PREFIX)) {
            $nameWithPrefix = str_replace(ProductCreated::PREFIX, self::PREFIX, $name);
        } else {
            $nameWithPrefix = self::PREFIX . $name;
        }

        $product->setName($nameWithPrefix);
    }
}

