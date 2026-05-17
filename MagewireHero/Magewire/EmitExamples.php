<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\MagewireHero\Magewire;

use Magewirephp\Magewire\Component;

class EmitExamples extends Component
{
    public string $receivedMessage = 'This is the default message';

    protected $listeners = ['adjustTitle'];

    public function adjustTitle(string $value): void
    {
        $this->receivedMessage = 'Received message: ' . $value;
    }
}
