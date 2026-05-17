<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\CheckoutHero\Magewire;

use Magewirephp\Magewire\Component;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Phrase;

class CustomerInfo extends Component
{

    public string $firstname = '';
    public string $lastname = '';
    public string|Phrase $shippingOffer = '';

    public function __construct(
        protected readonly CustomerSession $customerSession,
    )
    {
    }

    /**
     * This method is automatically called when the component is first initialized on the frontend
     */
    public function mount(): void
    {
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            $this->firstname = $customer->getFirstname();
            $this->lastname = $customer->getLastname();
        }
    }

    /**
     * Add info to the customer about different offering based on the shipping method
     * @param string $method
     */
    public function setShippingOffer(string $method): void
    {
        if ($method === 'tablerate_bestway') {
            $this->shippingOffer = __('Congratulations! You will get additionally 10% discount.');
        } elseif ($method === 'flatrate_flatrate') {
            $this->shippingOffer = __('Congratulations! You will get additionally 5% discount.');
        } else {
            $this->shippingOffer = '';
        }
    }
}
