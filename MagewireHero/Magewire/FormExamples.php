<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\MagewireHero\Magewire;

use Magewirephp\Magewire\Component\Form;

class FormExamples extends Form
{
    public $email;
    public $userName;
    public $vatId;

    protected $rules = [
        'email' => 'required|email',
        'userName' => 'required|min:4',
        'vatId' => 'required|regex:/^(?:NL)?[a-z0-9]{9}B[a-z0-9]{2}$/i'
    ];

    protected $messages = [
        'vatId:required' => ('Please specify a valid EU VAT ID to proceed'),
        'vatId:regex' => ('":value" is not a valid EU VAT ID'),
    ];

    public function updated($value)
    {
        $this->validate();
        return $value;
    }

}
