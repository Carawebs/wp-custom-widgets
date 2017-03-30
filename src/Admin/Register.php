<?php
namespace Carawebs\Widgets\Admin;

use DI;

/**
* Register custom widgets_init
*
* Create an instance of this class from within your theme, hooked to the
* 'after_setup_theme' WP hook.
*/
class Register {
    function __construct( array $widgets = [] ) {
        $this->container = DI\ContainerBuilder::buildDevContainer();
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
            global $wp_widget_factory;
            $widgetClass = 'Carawebs\Widgets\\' . $widget;
            $widgetObject = $this->container->get($widgetClass);
            // Register with WordPress
            $wp_widget_factory->widgets[$widget] = $widgetObject;
        }
    }

    public function widgets_init() {
        add_action( 'widgets_init', [$this, 'register_widgets'] );
    }
}
