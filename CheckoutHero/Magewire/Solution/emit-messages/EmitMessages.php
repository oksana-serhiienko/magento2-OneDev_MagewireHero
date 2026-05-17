<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\CheckoutHero\Magewire;

use Magewirephp\Magewire\Component;

class EmitMessages extends Component
{

    public string $testMessage = '';

    protected $listeners = [
        'shipping_address_saved' => 'onShippingAddressSaved',
    ];

    /**
     * Set the test message, if the shipping address is saved
     */
    public function onShippingAddressSaved()
    {
        $this->testMessage = 'Shipping address has been saved!';
    }
}
