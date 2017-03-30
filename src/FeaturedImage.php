<?php
namespace Carawebs\Widgets;
use Carawebs\Display;

class FeaturedImage extends \WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {

    $widget_ops = array(
      'classname' => 'featured-image',
      'description' => 'Featured Image',
    );
    parent::__construct( 'featured-image', 'Carawebs Featured Image', $widget_ops );

  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {

    $imagedata = Display\Image::featured_image( get_the_ID(), '', ['center-block'], true );

    // outputs the content of the widget
    extract( $args );
    echo $before_widget;
    echo $imagedata['image'];
    echo ! empty( $imagedata['caption'] )
      ? "<p class='wp-caption-text'>{$imagedata['caption']}</p>"
      : NULL;
    echo $after_widget;

  }

}
