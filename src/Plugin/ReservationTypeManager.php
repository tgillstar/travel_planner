<?php
namespace Drupal\travel_planner\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
/**
 * Provides the Reservation type plugin manager.
 */
class ReservationTypeManager extends DefaultPluginManager {
  /**
   * Constructs a new ReservationTypeManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/ReservationType', $namespaces, $module_handler, 'Drupal\travel_planner\Plugin\ReservationTypeInterface', 'Drupal\travel_planner\Annotation\ReservationType');
    $this->alterInfo('reservation_type_info');
    $this->setCacheBackend($cache_backend, 'reservation_type_info');
  }
}
