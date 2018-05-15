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
        foreach ($invalidInput as $name => $value) {
            $this->logger($name);
            $unprefixedName = str_replace($this->namePrefix, '', $name);
            if (!in_array($unprefixedName, array_keys($this->formFields))) continue;

            $type = $this->formFields[$unprefixedName]['type'];
            $required = isset($this->formFields[$unprefixedName]['required']);
            $label = $this->formFields[$unprefixedName]['label'];

            if ('text' === $type) {
                if (empty($value) && $required) {
                    $errors[] = "Please enter a value for $label";
                }
            }
            if ('textarea' === $type) {
                if (empty($value) && $required) {
                    $errors[] = "Please enter a value for $label";
                }
            }
            if ('radio' === $type) {
                if (empty($value) && $required) {
                    $errors[] = "Please enter a value for $label";
                }
            }
            if ('checkbox' === $type) {
                if ($value!= "on" && $required) {
                    $errors[] = "Please enter a value for $label";
                }
            }
            if ('email' === $type) {
                if (empty($value) && $required) {
                    $errors[] = "Please enter a value for $label";
                }
                if (!is_email($value)) {
                    $errors[] = "Please enter a valid email in the format name@example.com";
                }
            }
        }
        return $errors;
    }

    public function sanitize($unsanitizedData)
    {
        $sane = [];
        foreach ($unsanitizedData as $name => $value) {

            $unprefixedName = str_replace($this->namePrefix, '', $name);
            if (!in_array($unprefixedName, array_keys($this->formFields))) continue;

            $type = $this->formFields[$unprefixedName]['type'];
            $niceName = !empty($this->formFields[$unprefixedName]['nice_name'])
                ? $this->formFields[$unprefixedName]['nice_name']
                : $this->formFields[$unprefixedName]['name'];

            if ('email' === $type) {
                $sane[$niceName] = sanitize_email($value);
            }
            if ('text' === $type) {
                $sane[$niceName] = sanitize_text_field($value);
            }
            if ('radio' === $type) {
                $sane[$niceName] = sanitize_text_field($value);
            }
            if ('textarea' === $type) {
                $sane[$niceName] = sanitize_text_field($value);
            }
        }
        return $sane;
    }
}
