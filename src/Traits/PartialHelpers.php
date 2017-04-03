<?php
namespace Carawebs\Widgets\Traits;

/**
 * Select partials - give preference to theme partials
 */
trait PartialHelpers
{
    public function partialSelector($partial)
    {
        if (file_exists(get_template_directory().'/partials/'.$partial.'.php')) {
            return (get_template_directory().'/partials/'.$partial.'.php');
        } else {
            return (dirname(__FILE__, 2) .'/partials/'.$partial.'.php');
        }
    }
}
