<?php
namespace Carawebs\Widgets\Data;

/**
 *
 */
class ContactData extends Data
{
    private $defaultData;

    //public $container;

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
     * Plugin or theme simply has to hook data to 'carawebs/address-data'
     */
    private function setData()
    {
        $this->container = apply_filters('carawebs/address-data', $this->defaultData);
    }
}
