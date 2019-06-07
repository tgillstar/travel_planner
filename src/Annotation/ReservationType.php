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
    * The plugin ID.
    *
    * @var string
    */
   public $id;

   /**
    * The label of the plugin.
    *
    * @var \Drupal\Core\Annotation\Translation
    *
    * @ingroup plugin_translatable
    */
   public $label;

   /**
     * The description of the Reservation Type.
     *
     * @var \Drupal\Core\Annotation\Translation
     *
     * @ingroup plugin_translatable
     */
    public $description;

   /**
    * The wrapper element to use when rendering the pane's form.
    *
    * E.g: 'container', 'fieldset'. Defaults to 'container'.
    *
    * @var string
    */
   public $wrapperElement;
}
