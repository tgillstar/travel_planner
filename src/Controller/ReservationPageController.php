<?php
namespace Drupal\travel_planner\Controller;

use DOMDocument;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\SimpleXMLElement;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Url;

use Drupal\travel_planner\AcceptEmailService;
use Drupal\travel_planner\Plugin\ReservationTypeManager;

/**
 * Class ReservationPageController.
 */
class ReservationPageController extends ControllerBase {

  protected $tempStoreFactory;
  protected $reservationTypeManager;
  private $form_builder;

  /**
  * Inject services.
  */
  public function __construct(PrivateTempStoreFactory $tempStoreFactory, ReservationTypeManager $reservationManager, FormBuilder $formBuilder) {
      $this->tempStoreFactory = $tempStoreFactory;
      $this->reservationTypeManager = $reservationManager;
      $this->formBuilder = $formBuilder;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tempstore.private'),
      $container->get('plugin.manager.reservation'),
      $container->get('formBuilder')
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
    $rawEmail = " ";
    $filePath = \Drupal::service('travel_planner.accept_email')->getEmail();
    $tempstore = $this->tempStoreFactory->get('travel_planner');

    // Create an email object
    $handle = fopen($filePath, "r");
    if ($handle) {
        while (!feof($handle)) {
            $rawEmail .= fgets($handle, 4096);
        }
        fclose($handle);
    }
    $tempstore->set('$rawEmail', $rawEmail);

    $rawStringContent = $tempstore->get('$rawEmail');

    $infoBlocks = [];

    // Retrieve DOM object
    $dom = new DOMDocument();

    // Parse the email object via HTML elements
    $dom->loadHTML($rawStringContent);
    $html = $dom->getElementsByTagName('table');
    $current = '';

    // Grab table blocks of information
    foreach ($html as $tables) {
      $infoBlocks[] = $dom->saveHTML($tables);
    }

    //Retrieve specific table with the itinerary
    $flightInfoBlocks = static::arraySearchPartial($infoBlocks, "itinerary");


    // Save parsed email content for content page generation
    /*$tempstore->set('processed_html', $doc);

    $processed_html = $tempstore->get('processed_hmtl');*/

    return array(
        '#type' => 'markup',
        '#markup' => t(serialize($infoBlocks[$flightInfoBlocks])),
      );
  }

  /**
  * Load a reservation plugin.
  */
  public function loadReservationPlugin($reservation) {
    $output = [];

    foreach ($this->reservationTypeManager->getDefinitions() as $type) {
      $output[$type->getPluginId()] = $type->buildPaneForm($reservation);
    }
    return $output;
  }
}
