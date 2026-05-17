<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\MagewireHero\Magewire;

use Magewirephp\Magewire\Component;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Message\ManagerInterface;

class PracticeExamples extends Component
{

    public string $greetingName = '';
    public string $greeting = '';
    public bool $isGreetingVisible = false;
    public int $counter = 0;
    public array $profile = [
        'first_name' => '',
        'last_name' => '',
    ];
    public string $orderId = '';
    public array $orderDetails = [];
    public bool $orderNotFound = false;
    public string $orderExceptionMessage = '';

    public string $messageText = '';

    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly ManagerInterface         $messageManager
    )
    {
    }

    public function updateGreetingName(): void
    {
        $this->greeting = 'Hello, ' . $this->greetingName . '!';
        $this->isGreetingVisible = true;
    }

    public function incrementCounter(): void
    {
        $this->counter++;
    }

    public function resetCounter(): void
    {
        $this->counter = 0;
    }

    public function fetchOrderDetails(): void
    {
        $this->orderDetails = [];
        $this->orderExceptionMessage = '';
        $this->orderNotFound = false;

        if (empty($this->orderId)) {
            $this->orderExceptionMessage = 'Please enter a valid Order ID.';
            return;
        }

        try {
            $order = $this->orderRepository->get($this->orderId);

            $this->orderDetails = [
                'status' => $order->getStatus(),
                'total' => $order->getGrandTotal(),
                'currency' => $order->getOrderCurrencyCode(),
            ];
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->orderExceptionMessage = 'No order found with ID: ' . $this->orderId;
            $this->orderNotFound = true;
        } catch (\Exception $e) {
            $this->orderExceptionMessage = 'An unexpected error occurred: ' . $e->getMessage();
        }
    }

    public function submitMessage(): void
    {
        if (trim($this->messageText) === '') {

            $this->dispatchBrowserEvent('magewire-test-messages', [
                'type' => 'error',
                'message' => __('Please enter a message before submitting')->render()
            ]);
            return;
        }

        $this->dispatchBrowserEvent('magewire-test-messages', [
            'type' => 'success',
            'message' => __('You entered: "%1"', $this->messageText)->render()
        ]);


        $this->messageText = '';
    }
}
