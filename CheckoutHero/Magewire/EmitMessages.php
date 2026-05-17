<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\CheckoutHero\Magewire;

use Magewirephp\Magewire\Component;

class EmitMessages extends Component
{

    public string $testMessage = '';

    // ToDo.: Set the onShippingAddressSaved function on shipping_address_saved event here

    /**
     * Set the test message, if the shipping address is saved
     */
    public function onShippingAddressSaved()
    {
        $this->testMessage = 'Shipping address has been saved!';
    }
}
