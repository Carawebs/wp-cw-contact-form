<?php
namespace Carawebs\ContactForm\Data;

/**
*
*/
class Fields extends Base
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
