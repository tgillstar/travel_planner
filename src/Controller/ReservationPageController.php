<?php
namespace Drupal\travel_planner\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\SimpleXMLElement;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\Component\Utility\Html;

use Drupal\travel_planner\Plugin\ReservationWidgetManager;

/**
 * Class ReservationPageController.
 */
class ReservationPageController extends ControllerBase {

  protected $tempStoreFactory;

  /**
 * Inject services.
 */
  public function __construct(PrivateTempStoreFactory $tempStoreFactory) {
      $this->tempStoreFactory = $tempStoreFactory;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tempstore.private')
    );
  }

  public function pageTitle($reservation) {
    return $reservation;
  }

  public function ingestEmail() {
    $raw_email = " ";
    $file_path = \Drupal::service('travel_planner.accept_email')->getEmail();
    $tempstore = $this->tempStoreFactory->get('travel_planner');

    // Create an email object
    $handle = fopen($file_path, "r");
    if ($handle) {
        while (!feof($handle)) {
            $raw_email .= fgets($handle, 4096);
        }
        fclose($handle);
    }
    $tempstore->set('raw_email', $raw_email);

    $raw_string_content = $tempstore->get('raw_email');

    // Parse the email object via HTML elements
    $dom = Html::load($raw_string_content);
    $html = "";

    foreach ($dom->getElementsByTagName('table') as $element) {
      $html .= $element->getElementsByTagName('tr');
    }

    // Save parsed email content
    $tempstore->set('processed_html', $html);

    $processed_html = $tempstore->get('processed_hmtl');

    return array(
        '#type' => 'markup',
        '#markup' => t($processed_html),
      );
  }

  public function pageContent($reservation) {
    $output = [];
    /** @var \Drupal\travel_planner\Plugin\ReservationWidgetInterface $widget */
  /*  foreach ($this->pluginManagerReservationWidget->getDefinitions() as $widget) {
      $output[$widget->getPluginId()] = $widget->buildWidget($reservation);
    }*/
    return $output;
  }
}
