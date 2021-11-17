<?php

declare(strict_types=1);

namespace Mdg\Catalog\Plugin\MagentoCatalog\Api\Data\ProductInterface;

use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Customization of Product's name setting.
 * Adds suffix " CUSTOMEZIED" to product name.
 */
class CustomizeNameSettingPlugin
{
    /**
     * Suffix to be added to name.
     */
    private const SUFFIX = ' CUSTOMIZED';

    /**
     * @param ProductInterface $subject
     * @param $name
     * @return string
     */
    public function beforeSetName(ProductInterface $subject, $name): string
    {
        if (!$this->isSuffixAlreadySet($name)) {
            $name.= self::SUFFIX;
        }

        return $name;
    }

    /**
     * Whether the suffix was already set to name.
     *
     * @param string $name
     * @return bool
     */
    private function isSuffixAlreadySet(string $name): bool
    {
        $rightPosition = strrpos($name, self::SUFFIX);

        if ($rightPosition === false) {
            return false;
        }

        $nameTail = substr($name, $rightPosition);

        return $nameTail == self::SUFFIX;
    }
}

