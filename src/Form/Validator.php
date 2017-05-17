<?php
namespace Carawebs\ContactForm\Form;

abstract class Validator
{

    /**
    * [selector description]
    * @param [type] $invalidInput [description]
    */
    public function validator($invalidInput)
    {
        $errors = [];
        $ourFormFieldData = [];
        foreach ($invalidInput as $name => $value) {
            if (!in_array($name, array_keys($this->formFields))) continue;
            $type = $this->formFields[$name]['type'];
            $ourFormFieldData[$name] = [$value, $type];
            if ('text' === $type) {
                if (empty($value)) {
                    $errors[] = "Please enter a value for $name";
                }
            }
            if ('textarea' === $type) {
                if (empty($value)) {
                    $errors[] = "Please enter a value for $name";
                }
            }
            // if ('email' === $type) {
            //     if (!is_email($value)) {
            //         $errors[] = "Please enter a valid email in the format name@example.com";
            //     }
            // }
        }
        return $errors;
    }

}
