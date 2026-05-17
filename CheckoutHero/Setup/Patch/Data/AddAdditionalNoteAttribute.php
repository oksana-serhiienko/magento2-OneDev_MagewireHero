<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\CheckoutHero\Setup\Patch\Data;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResourceModel;

class AddAdditionalNoteAttribute implements DataPatchInterface
{
    public function __construct(
        private EavSetupFactory $eavSetupFactory,
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavConfig $eavConfig,
        private AttributeResourceModel $attributeResourceModel
    ) {
    }

    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            'customer_address',
            'additional_note',
            [
                'input' => 'text',
                'is_visible_in_grid' => false,
                'visible' => true,
                'user_defined' => true,
                'is_filterable_in_grid' => false,
                'system' => false,
                'label' => 'Additional Note',
                'source' => null,
                'position' => 10,
                'type' => 'static',
                'is_used_in_grid' => false,
                'required' => false,
            ]
        );

        $attribute = $this->eavConfig->getAttribute('customer_address', 'additional_note');
        $attribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer',
                'adminhtml_checkout',
                'adminhtml_customer_address',
                'customer_account_edit',
                'customer_address_edit',
            ]
        );

        $this->attributeResourceModel->save($attribute);

        $eavSetup->addAttributeToGroup(
            'customer_address',
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            'additional_note',
            null
        );

        return $this;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
