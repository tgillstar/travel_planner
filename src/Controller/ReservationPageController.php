<?php
namespace Drupal\travel_planner\Controller;

use DOMDocument;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\SimpleXMLElement;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\Component\Utility\Html;

use Drupal\travel_planner\AcceptEmailService;
use Drupal\travel_planner\Plugin\ReservationTypeManager;

/**
 * Class ReservationPageController.
 */
class ReservationPageController extends ControllerBase {

  protected $tempStoreFactory;
  protected $reservationTypeManager;

  /**
  * Inject services.
  */
  public function __construct(PrivateTempStoreFactory $tempStoreFactory, ReservationTypeManager $reservation_manager) {
      $this->tempStoreFactory = $tempStoreFactory;
      $this->reservationTypeManager = $reservation_manager;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tempstore.private'),
      $container->get('plugin.manager.reservation')
    );
  }

  /**
  * Return Reservation page title
  */
  public function pageTitle($reservation) {
    return $reservation;
  }

  /**
  * Returns array index that has the specified keyword
  */
  static protected function arraySearchPartial($arr, $keyword) {
      foreach($arr as $index => $string) {
          if (strpos($string, $keyword) !== FALSE)
              return $index;
      }
  }

  /**
  * Displays the processed HTML with reservation information
  */
  public function acceptEmail() {
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

    //Retrieve specific table with the itinerary
    $flight_info_blocks = static::arraySearchPartial($infoBlocks, "itinerary");


    // Save parsed email content for content page generation
    /*$tempstore->set('processed_html', $doc);

    $processed_html = $tempstore->get('processed_hmtl');*/

    return array(
        '#type' => 'markup',
        '#markup' => t(serialize($infoBlocks[$flight_info_blocks])),
      );
  }

  /**
  * Generates a Reservation plugin.
  */
  public function generateReservationPlugin($reservation) {
    $output = [];

    foreach ($this->reservationTypeManager->getDefinitions() as $type) {
      $output[$type->getPluginId()] = $type->buildType($reservation);
    }
    return $output;
  }
}
