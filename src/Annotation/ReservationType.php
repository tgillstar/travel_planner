<?php
namespace Drupal\travel_planner\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Reservation type item annotation object.
 *
 * @see \Drupal\travel_planner\Plugin\ReservationTypeManager
 * @see plugin_api
 *
 * @Annotation
 */
class ReservationType extends Plugin {
  /**
   * @var string
   */
  public $id;
  /**
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;
}
