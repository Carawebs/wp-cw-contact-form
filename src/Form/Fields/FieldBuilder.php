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

    function __construct(FileFormFieldsConfig $formFieldsConfig, $namePrefix)
    {
        $this->formFields = $formFieldsConfig;
        $this->namePrefix = $namePrefix;
        $this->buildFields();
    }

    public function buildFields()
    {
        $this->fieldsMarkupArray = [];
        foreach ($this->formFields->container as $key => $args) {
            switch ($args['type']) {
                case 'text':
                $this->fieldsMarkupArray[] = $this->text($args);
                break;
                case 'email':
                $this->fieldsMarkupArray[] = $this->text($args);
                break;
                case 'textarea':
                $this->fieldsMarkupArray[] = $this->textarea($args);
                break;
                case 'tel':
                $this->fieldsMarkupArray[] = $this->tel($args);
                break;
                case 'radio':
                $this->fieldsMarkupArray[] = $this->radios($args);
                break;
                case 'heading':
                $this->fieldsMarkupArray[] = $this->heading($args);
                break;
                case 'paragraph':
                $this->fieldsMarkupArray[] = $this->paragraph($args);
                break;
                default:
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
