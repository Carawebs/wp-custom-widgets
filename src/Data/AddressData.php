<?php
namespace Carawebs\Widgets\Data;

/**
 *
 */
class AddressData extends Data
{
    private $defaultData;

    public $data;

    function __construct()
    {
        $this->setDefaultData();
        $this->setData();
    }

    /**
     * Fetch this from the DB?
     */
    private function setDefaultData()
    {
        $this->defaultData = [
            'address_line_1' => 'Cloonanass',
            'address_line_2' => 'Sixmilebridge',
            'address_county' => 'Co. Clare'
        ];
    }

    /**
     * Plugin or theme simply has to hook data to 'carawebs/address-data'
     */
    private function setData()
    {
        $this->data = apply_filters('carawebs/address-data', $this->defaultData);
    }
}
