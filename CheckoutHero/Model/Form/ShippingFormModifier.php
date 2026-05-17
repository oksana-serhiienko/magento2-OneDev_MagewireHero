<?php declare(strict_types=1);

/**
 * OneDev_OksanaSerhiienko
 */

namespace OneDev\CheckoutHero\Model\Form;

use Hyva\Checkout\Model\Form\AbstractEntityForm;
use Hyva\Checkout\Model\Form\AbstractEntityFormModifier;
use Hyva\Checkout\Model\Form\EntityField\AbstractEntityField;

class ShippingFormModifier extends AbstractEntityFormModifier
{
    // Modifying exists 'additional_note' field
    public function apply(AbstractEntityForm $form): AbstractEntityForm
    {
        // TODO: Implement apply() method.
        $form->modifyField('additional_note', function (AbstractEntityField $field): void {
            $field->setLabel('Leave a message?');
            $field->setAttribute('placeholder', 'Optional note to the courier');
            $field->setAttribute('id', 'shipping-additional-note');
            $field->setAttribute('class', 'additional-note-field custom-style');
            $field->setAttribute('data-tooltip', 'This message will be printend on the delivery slip');

            $field->setAttribute('pattern', '^[A-Za-z\s]+$');
            $field->setAttribute('data-msg-pattern', 'Only letters and spaces are allowed in this field');
        });

        // Register the conditional modification
        $form->registerModificationListener(
            'clear_note_for_at',
            'form:shipping:updated',
            [$this, 'clearNoteFieldIfCountryIsAT']
        );

        return $form;

    }

    /**
     * Clear additional_note field if the country AT selected + Set 'Vienna' as a city
     * @param AbstractEntityForm $form
     */
    public function clearNoteFieldIfCountryIsAT(AbstractEntityForm $form): void
    {
        $country = $form->getField('country_id')->getValue();

        if ($country === 'AT') {
            $form->getField('additional_note')->empty();
            $form->getField('city')->setValue('Vienna');
        }

    }

}
