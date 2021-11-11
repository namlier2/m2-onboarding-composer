<?php

declare(strict_types=1);

namespace Mdg\Catalog\Observer\CatalogProduct;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Event observer for the event "catalog_product_new_action".
 * Adds the prefix "NEW " to a product name.
 */
class ProductCreated implements ObserverInterface
{
    /**
     * Prefix to apply.
     */
    public const PREFIX = 'NEW ';

    /**
     * @inheritdoc
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        $product = $observer->getProduct();

        if ($product->getId()) {
            return;
        }

        $name = $product->getName();
        $nameWithPrefix = self::PREFIX . $name;
        $product->setName($nameWithPrefix);
    }
}

