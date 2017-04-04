<?php
namespace Carawebs\Widgets\Data;

/**
 *
 */
class ContactData extends Data
{
    private $defaultData;

    function __construct()
    {
        $this->setDefaultData();
        $this->setData();
    }

    /**
     * Fetch this from the DB - registered by carawebs/wp-contact
     */
    private function setDefaultData()
    {
        if (class_exists('\Carawebs\Contact\Data\Combined')) {
            $this->defaultData = new \Carawebs\Contact\Data\Combined;
        }
    }

    /**
     * Set data for this \ArrayAccess object.
     */
    private function setData()
    {
        $this->container = apply_filters('carawebs/combined-contact-data', $this->defaultData);
    }
}
