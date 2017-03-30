<?php
namespace Carawebs\Widgets\Admin;

/**
* Register custom widgets_init
*
* Create an instance of this class from within your theme, hooked to the
* 'after_setup_theme' WP hook.
*/
class Register {
    function __construct( array $widgets = [] ) {
        $this->set_widgets($widgets);
        $this->widgets_init();
    }

    public function set_widgets( array $widgets = [] ) {
        if (empty($widgets)) {
            $this->widgets = [
                'Services',
                'CTA',
                'Social',
                'Contact',
                'Address',
                'FeaturedImage',
                'TextNoTitle',
                'Mailchimp'
            ];
        } else {
            $this->widgets = $widgets;
        }
    }

    public function register_widgets() {
        foreach( $this->widgets as $widget ) {
            register_widget( 'Carawebs\Widgets\\' . $widget );
        }
    }

    public function widgets_init() {
        add_action( 'widgets_init', [$this, 'register_widgets'] );
    }
}
