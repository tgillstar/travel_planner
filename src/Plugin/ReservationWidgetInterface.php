<?php
namespace Drupal\travel_planner\Plugin;
use Drupal\Component\Plugin\PluginInspectionInterface;
/**
 * Defines an interface for Reservation widget plugins.
 */
interface ReservationWidgetInterface extends PluginInspectionInterface {
  /**
   * Returns the render-able widget for provided reservation
   *
   * @param string $reservation
   *   The name of the reservation to build the widget for.
   *
   * @return array
   *   The render-able array.
   */
  public function buildWidget($reservation);
}
