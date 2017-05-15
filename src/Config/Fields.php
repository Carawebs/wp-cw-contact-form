<?php
namespace Carawebs\ContactForm\Config;

/**
*
*/
class Fields extends BaseArrayAccess
{
    public function __construct()
    {
        $this->setData();
    }

    public function setData()
    {
        $this->container = get_option('carawebs_contact_fields');
    }
}
