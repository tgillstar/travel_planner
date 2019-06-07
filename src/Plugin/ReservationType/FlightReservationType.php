<?php

namespace Drupal\travel_planner\Plugin\ReservationType;

use Drupal\travel_planner\ReservationTypeBase;

/**
 * Provides the flight reservation pane.
 *
 * @MyFormPane(
 *   id = "flight_reservation_type",
 *   label = @Translation("Flight Reservation Type"),
 *   displayFormFields = "List of field definitions for the Flight Reservation content type"
 *   wrapper_element = "fieldset",
 * )
 */
class FlightReservationType extends ReservationTypeBase {

 /**
  * {@inheritdoc}
  */
  public function description() {
    return $this->t("This is a Flight Reservation Type.");
  }

  /**
   * {@inheritdoc}
   */
  public function displayFormFields() {
      $formFieldDefintions = \Drupal::service('entity_field.manager')->getFieldDefinitions('node','flight_reservation');
    //return serialize($formFieldDefintions);
    return "Display Form Fields for the Flight Reservation Type.";
  }
}
