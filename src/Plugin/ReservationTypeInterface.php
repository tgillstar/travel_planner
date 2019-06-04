<?php
namespace Drupal\travel_planner\Plugin;

use Drupal\Component\Plugin\DerivativeInspectionInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Form\FormStateInterface;
/**
 * Defines an interface for Reservation type plugins.
 */
interface ReservationTypeInterface extends PluginInspectionInterface, DerivativeInspectionInterface {
  public function getId();

  public function getLabel();

  public function getWrapperElement();

  public function buildPaneSummary();

  public function buildPaneForm(array $form, FormStateInterface $formState, array &$completeForm);

  public function validatePaneForm(array &$form, FormStateInterface $formState, array &$completeForm);

  public function submitPaneForm(array &$form, FormStateInterface $formState, array &$completeForm);
}
