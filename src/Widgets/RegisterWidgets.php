<?php
namespace Carawebs\ContactForm\Widgets;

/**
* Register custom widgets - entry point.
*
* Create an instance of this class within theme - hook to 'after_setup_theme'.
*/
class RegisterWidgets {

    // /**
    //  * The DI Container
    //  * @var DI\Container
    //  */
    // protected $container;

    /**
     * Widgets to register
     * @var array
     */
    protected $widgets;

    function __construct( array $widgets = [] ) {
        //$this->container = DI\ContainerBuilder::buildDevContainer();
        $this->set_widgets($widgets);
        $this->widgets_init();
    }

    public function set_widgets( array $widgets = [] ) {
        if (empty($widgets)) {
            $this->widgets = [
                'ContactForm',
            ];
        } else {
            $this->widgets = $widgets;
        }
    }

    public function register_widgets() {
        foreach( $this->widgets as $widget ) {
            global $wp_widget_factory;
            $widgetClass = 'Carawebs\\ContactForm\\Widgets\\' . $widget;
            // If using a DI container
            // $widgetObject = $this->container->get($widgetClass);
            $widgetObject = new $widgetClass;
            // Register with WordPress
            $wp_widget_factory->widgets[$widget] = $widgetObject;
        }
    }

    public function widgets_init() {
        add_action( 'widgets_init', [$this, 'register_widgets'] );
    }
}
