<?php

declare(strict_types=1);

namespace Mdg\Catalog\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Add to price config.
 */
class AddToPrice
{
    /**
     * Configuration path.
     */
    private const CONFIG_PATH = 'mdg_catalog/prices/add_to_price';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * The "mdg_catalog/prices/add_to_price" config value.
     * Returns value of the config value.
     *
     * @param string $scopeType
     * @param null $scopeCode
     * @return float
     */
    public function getValue(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null): float
    {
        $value = $this->scopeConfig->getValue(
            self::CONFIG_PATH,
            $scopeType,
            $scopeCode
        );

        return (float)$value;
    }
}
