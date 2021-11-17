<?php

declare(strict_types=1);

namespace Mdg\Catalog\Plugin\MagentoCatalog\Model\Product;

use Magento\Catalog\Model\Product;
use Psr\Log\LoggerInterface;

/**
 * Log products saving.
 */
class LogProductsSavePlugin
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Minimum price to determine that it is not low.
     */
    private const MIN_PRICE = 100;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Product $subject
     * @param callable $proceed
     * @return Product
     */
    public function aroundSave(Product $subject, callable $proceed): Product
    {
        if (!$subject->getId()) {
            $this->logNewProduct($subject);
        }

        $result = $proceed();

        if ($result->getPrice() < self::MIN_PRICE) {
            $this->logLowPrice($result);
        }

        return $result;
    }

    /**
     * Logs new product in custom log-file.
     *
     * @param Product $product
     * @return void
     */
    private function logNewProduct(Product $product): void
    {
        $this->logger->info("SKU: {$product->getSku()} is NEW.");
    }

    /**
     * Logs low price in custom log-file.
     *
     * @param Product $product
     * @return void
     */
    private function logLowPrice(Product $product): void
    {
        $this->logger->info("SKU: {$product->getSku()} price is lower then 100!");
    }
}

