<?php
namespace Carawebs\Widgets\Admin;

use DI;

/**
* Register custom widgets_init - entry point.
*
* Create an instance of this class within theme - hook to 'after_setup_theme'.
* @TODO Refine this process - see https://torquemag.io/2017/01/using-automatic-dependency-injection-wordpress-development/
*/
class Register {

    /**
     * The DI Container
     * @var DI\Container
     */
    protected $container;

    /**
     * Widgets to register
     * @var array
     */
    protected $widgets;

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
                'Email',
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
