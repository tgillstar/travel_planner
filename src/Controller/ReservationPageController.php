<?php
namespace Drupal\travel_planner\Controller;

use DOMDocument;
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

    $infoBlocks = [];

    // Retrieve DOM object
    $dom = new DOMDocument();

    // Parse the email object via HTML elements
    $dom->loadHTML($raw_string_content);
    $html = $dom->getElementsByTagName('table');
    $current = '';

    // Grab table blocks of information
    foreach ($html as $tables) {
      $infoBlocks[] = $dom->saveHTML($tables);
    }

    // Save parsed email content for content page generation
    /*$tempstore->set('processed_html', $doc);

    $processed_html = $tempstore->get('processed_hmtl');*/

    return array(
        '#type' => 'markup',
        '#markup' => t(serialize($infoBlocks)),
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
