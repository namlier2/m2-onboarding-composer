<?php

declare(strict_types=1);

namespace Mdg\Catalog\Plugin\Catalog\Api\Data\ProductInterface;

use Magento\Catalog\Api\Data\ProductInterface;
use Mdg\Catalog\Model\Config\AddToPrice as AddToPriceConfig;

/**
 * Add to price Plugin.
 * Increases price of a product by given configuration value
 * from "mdg_catalog_section/prices/add_to_price".
 */
class AddToPricePlugin
{
    /**
     * @var AddToPriceConfig
     */
    private $addToPriceConfig;

    /**
     * @param AddToPriceConfig $addToPriceConfig
     */
    public function __construct(AddToPriceConfig $addToPriceConfig)
    {
        $this->addToPriceConfig = $addToPriceConfig;
    }


    public function afterGetPrice(ProductInterface $subject, $result)
    {
        return $result + $this->addToPriceConfig->getValue('store');
    }
}
