<?php
namespace Drupal\travel_planner;
use Drupal\Component\Plugin\PluginBase;
/**
 * Base class for Reservation type plugins.
 */
abstract class ReservationTypeBase extends PluginBase implements ReservationTypeInterface {

  public function __construct(array $configuration, $pluginId, $pluginDefinition) {
    parent::__construct($configuration, $pluginId, $pluginDefinition);
    $this->setConfiguration($configuration);
  }

  public function getConfiguration() {
    return $this->configuration;
  }

  public function setConfiguration(array $configuration) {
    $this->configuration = NestedArray::mergeDeep($this->defaultConfiguration(), $configuration);
  }

  public function defaultConfiguration() {
    return [];
  }

  public function getId() {
    return $this->pluginId;
  }

  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

  public function getWrapperElement() {
    return $this->pluginDefinition['wrapperElement'];
  }

  abstract public function displayFormFields() {}
}
