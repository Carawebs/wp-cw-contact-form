<?php
namespace Carawebs\ContactForm\Form\Fields;

use Carawebs\ContactForm\Config\FileFormFieldsConfig;

/**
 *
 */
class FieldBuilder extends FieldMarkup
{
    private $formFields;

    private $fieldsMarkupArray;

    function __construct(FileFormFieldsConfig $formFieldsConfig)
    {
        $this->formFields = $formFieldsConfig;
        $this->buildFields();
    }

    public function buildFields()
    {
        $this->fieldsMarkupArray = [];
        foreach ($this->formFields->container as $key => $args) {
            switch ($args['type']) {
                case 'text':
                $this->fieldsMarkupArray['text'] = $this->text($args);
                break;
                case 'textarea':
                $this->fieldsMarkupArray['textarea'] = $this->textarea($args);
                break;
                case 'radio':
                $this->fieldsMarkupArray['radio'] = $this->radios($args);
                break;
                default:
                # code...
                break;
            }
        }
    }

    public function getFieldsMarkup()
    {
        return $this->fieldsMarkupArray;
    }
    public function getFieldsData()
    {
        return $this->formFields;
    }
}
