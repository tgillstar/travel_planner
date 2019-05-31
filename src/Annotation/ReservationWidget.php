<?php
namespace Drupal\travel_planner\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Reservation widget item annotation object.
 *
 * @see \Drupal\travel_planner\Plugin\ReservationWidgetManager
 * @see plugin_api
 *
 * @Annotation
 */
class ReservationWidget extends Plugin {
  /**
   * @var string
   */
  public $id;
  /**
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;
}
