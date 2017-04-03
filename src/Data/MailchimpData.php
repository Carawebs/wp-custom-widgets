<?php
namespace Carawebs\Widgets\Data;

/**
 *
 */
class MailchimpData extends Data
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
            'post_to_url' => '#',
        ];
    }

    /**
     * Plugin or theme simply has to hook data to 'carawebs/address-data'
     */
    private function setData()
    {
        $this->data = apply_filters('carawebs/mailchimp-data', $this->defaultData);
    }
}
