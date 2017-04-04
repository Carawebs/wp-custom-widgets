<?php
namespace Carawebs\Widgets;

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


      $image = get_the_post_thumbnail( get_the_ID(), 'full', ['class'=>'center-block img-fluid']);
      $caption = get_post( get_post_thumbnail_id() )->post_excerpt;
    // $imagedata = Display\Image::featured_image( get_the_ID(), '', ['center-block'], true );

    // outputs the content of the widget
    extract( $args );
    echo $before_widget;
    echo $image;
    echo !empty($caption) ? "<span class='wp-caption-text'>$caption</span>" : NULL;
    echo $after_widget;

  }

}
