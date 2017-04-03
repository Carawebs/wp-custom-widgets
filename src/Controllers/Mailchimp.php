<?php
namespace Carawebs\Widgets\Controllers;

use Carawebs\Widgets\Data\MailchimpData;
/**
 *
 */
class Mailchimp extends Controller
{
    function __construct(MailchimpData $data)
    {
        $this->data = $data->data;
    }

    public function getData() : array
    {
        return $this->data;
    }
}
