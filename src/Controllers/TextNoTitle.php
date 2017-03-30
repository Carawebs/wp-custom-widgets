<?php
namespace Carawebs\Widgets\Controllers;

/**
 *
 */
class TextNoTitle extends Controller
{
    private $foo;

    function __construct()
    {
        $this->setFoo();
    }

    public function setFoo()
    {
        $this->foo = [
            'line_1' => '10, Acacia Ave',
            'line_2' => 'Cloonanass',
            'town' => 'Sixmilebridge'
        ];
    }

    public function getFoo()
    {
        return $this->foo;
    }
}
