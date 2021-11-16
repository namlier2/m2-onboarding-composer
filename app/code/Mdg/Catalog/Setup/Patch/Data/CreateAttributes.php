<?php

declare(strict_types=1);

namespace Mdg\Catalog\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;

/**
 * Creates few attributes.
 */
class CreateAttributes implements DataPatchInterface, PatchRevertableInterface, PatchVersionInterface
{
    /**
     * @var EavSetup
     */
    private EavSetup $eavSetup;

    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(EavSetupFactory $eavSetupFactory, ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->eavSetup = $eavSetupFactory->create(['setup' => $moduleDataSetup]);
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->eavSetup->addAttribute(
            Product::ENTITY,
            'mdg_extra_text',
            [
                'attribute_set' => 'Default',
                'group' => 'General',
                'label' => 'Mdg Extra text',
                'type' => 'varchar',
                'input' => 'text',
                'sort_order' => 10,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                // Admin
                'visible' => true,
                'is_used_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_visible_in_grid' => true,
                'required' => false,
                // Storefront
                'visible_on_front' => true,
                'is_html_allowed_on_front' => true,
            ]
        );

        $this->eavSetup->addAttribute(
            Product::ENTITY,
            'mdg_time_of_manufacture',
            [
                'attribute_set' => 'Default',
                'group' => 'General',
                'label' => 'Mdg Time of manufacture',
                'type' => 'varchar',
                'input' => 'select',
                'sort_order' => 20,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                // Admin
                'visible' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => true,
                'required' => true,
                // Frontend
                'visible_on_front' => true,
                'is_html_allowed_on_front' => false,
                'option' => [
                    'values' => [
                        'moonlight',
                        'thunderstorm',
                        'wildfire',
                        'whatever',
                    ],
                ],
                'default' => 'whatever',
            ]
        );

        $this->eavSetup->addAttribute(
            Product::ENTITY,
            'mdg_audio_video_interface',
            [
                'attribute_set' => 'Default',
                'group' => 'General',
                'label' => 'Mdg audio video interface',
                'sort_order' => 20,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'type' => 'varchar',
                'input' => 'multiselect',
                'backend' => ArrayBackend::class,
                // Admin
                'visible' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'required' => true,
                // Frontend
                'visible_on_front' => true,
                'is_html_allowed_on_front' => false,
                'option' => [
                    'values' => [
                        'vga',
                        'cga',
                        'ega',
                        'hdmi',
                        'display port'
                    ],
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function revert()
    {
        $this->eavSetup->removeAttribute(Product::ENTITY, 'mdg_extra_text');
        $this->eavSetup->removeAttribute(Product::ENTITY, 'mdg_time_of_manufacture');
        $this->eavSetup->removeAttribute(Product::ENTITY, 'mdg_audio_video_interface');
    }

    /**
     * @inheritdoc
     */
    public static function getVersion()
    {
        return '0.0.2';
    }
}
