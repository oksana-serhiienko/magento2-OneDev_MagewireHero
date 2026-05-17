<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\CheckoutHero\Magewire;

use Magewirephp\Magewire\Component;
use Magento\Customer\Model\Session as CustomerSession;

class CustomerInfo extends Component
{

    public string $firstname = '';
    public string $lastname = '';

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
}
