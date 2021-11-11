<?php

declare(strict_types=1);

namespace Mdg\Catalog\Observer\CatalogProduct;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

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
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        $product = $observer->getProduct();
        $name = $product->getName();

        if (str_contains(ProductCreated::PREFIX, $name)) {
            $nameWithPrefix = $this->replacePrefix($name);
        } else {
            $nameWithPrefix = $this->addPrefix($name);
        }

        $product->setName($nameWithPrefix);
    }

    /**
     * Replaces the prefix from the ProductCreated observer by the new one.
     *
     * @param string $name
     * @return string
     */
    private function replacePrefix(string $name): string
    {
        return str_replace(ProductCreated::PREFIX, self::PREFIX, $name);
    }

    /**
     * Adds the prefix.
     *
     * @param string $name
     * @return string
     */
    private function addPrefix(string $name): string
    {
        return self::PREFIX . $name;
    }
}

