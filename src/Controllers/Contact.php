<?php
namespace Carawebs\Widgets\Controllers;

use Carawebs\Widgets\Data\ContactData;
/**
 *
 */
class Contact extends Controller
{
    function __construct(ContactData $data)
    {
        $this->data = $data->container;
    }

    public function getAddress() : array
    {
        return $this->data['carawebs_address'] ?? [];
    }

    public function getCompanyDetails() : array
    {
        return $this->data['carawebs_company'] ?? [];
    }

    public function getSocialDetails() : array
    {
        return $this->data['carawebs_social'] ?? [];
    }
}
