<?php
namespace Drupal\travel_planner\Plugin;
use Drupal\Component\Plugin\PluginInspectionInterface;
/**
 * Defines an interface for Reservation type plugins.
 */
interface ReservationTypeInterface extends PluginInspectionInterface {
  /**
   * Returns the render-able type for provided reservation
   *
   * @param string $reservation
   *   The name of the reservation to build the type for.
   *
   * @return array
   *   The render-able array.
   */
  public function buildType($reservation);
}
