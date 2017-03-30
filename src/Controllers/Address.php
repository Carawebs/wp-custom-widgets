<?php
namespace Carawebs\Widgets\Controllers;

use Carawebs\Widgets\Data\AddressData;
/**
 *
 */
class Address extends Controller
{
    function __construct(AddressData $data)
    {
        $this->data = $data->data;
        $this->config();
        var_dump($this->data);
        //$this->setAddress();
    }

    private function config()
    {
        // Reference a Class, from a config file

    }

    // private function setAddress($address = []) : array
    // {
    //     $this->address = [
    //         'Cloonanass', 'Sixmilebridge'
    //     ];
    //     return $address;
    // }

    public function getAddress() : array
    {
        // return $this->address;
        return $this->data;
    }
}
