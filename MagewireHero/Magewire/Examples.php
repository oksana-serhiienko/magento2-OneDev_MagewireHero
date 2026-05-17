<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\MagewireHero\Magewire;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magewirephp\Magewire\Component;

class Examples extends Component
{
    public array $products = [];
    public bool $showProducts = false;
    public string $title = 'Hello Magewire';
    public string $myProp = 'Some value';
    public bool $toggleTextFlag = false;
    public string $greeting = '';
    public null|string $customerName = '';
    public array $address = [
        'street' => 'Bagging Bvd. 2150',
        'city' => 'Hobbiton',
        'postcode' => '1',
        'country' => 'The Shire',
    ];
    public string $titleToSend = '';
    public int $count = 0;

    public function __construct(
        private readonly ProductCollectionFactory $productCollectionFactory,
        private readonly PriceHelper              $priceHelper
    )
    {
    }

    /**
     * Load and assign a collection of 4 products with formatted price
     */
    public function loadProducts(): void
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'price']);
        $collection->setPageSize(4); // Limit to 4 items

        $this->products = array_map(function ($product) {
            return [
                'name' => $product->getName(),
                'price' => $this->priceHelper->currency($product->getFinalPrice(), true, false),
            ];
        }, $collection->getItems());

        $this->showProducts = true;
    }

    /**
     * Triggered by wire:init to preload greeting
     */
    public function initGreeting(): void
    {
        if (!$this->customerName) {
            $this->greeting = 'Welcome! Please enter your name.';
        }
    }

    /**
     * Clear the greeting text
     */
    public function clearGreeting(): void
    {
        $this->greeting = '';
    }

    /**
     * Update customerName attribute with greeting message
     * @param $value
     */
    public function updatedCustomerName(string $value): void
    {
        $this->greeting = 'Welcome! ' . $value;
    }

    /**
     * Update myProp attribute to uppercase
     */
    public function updatedMyProp(string $value): string
    {
        $this->myProp = strtolower($value);

        return $this->myProp;
    }

    /**
     * Magic getter example for 'myProp'
     */
    public function getMyProp(): string
    {
        return $this->myProp;
    }

    /**
     * "Has" method example (analog to isset())
     */
    public function hasMyProp(): bool
    {
        return isset($this->myProp) && $this->myProp !== '';
    }

    /**
     * Presentation of the updated process with array (street)
     */
    public function updatedAddressStreet(string $value): string
    {
        return $value;
    }

    /**
     * Send message to magewire.examples.emit with the new title
     */
    public function sendTitle(): void
    {
        $this->emitTo('magewire.examples.emit', 'adjustTitle', 'Hello Emit Message!');
    }
}
