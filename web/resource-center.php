<?php

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;
use CommerceGuys\Addressing\Validator\Constraints\AddressFormatConstraint;

//require_once 'core/includes/file.inc';

$autoloader = require_once 'autoload.php';

$request = Request::createFromGlobals();
$kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod');
$kernel->boot();

// Open an SQL File

$sql = fopen('./resources.sql', 'w+');

/*********
 * Get List of New Countries
 *********/

$countries = array();

$query = \Drupal::entityQuery('node');
$query->condition('type', 'countries');

$ids = $query->execute();

//print_r($ids);
echo "Total: " . count($ids) . "\n\n";

foreach ($ids as $key => $val){
   $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
   $countries[$node->get('title')->value] = $val;
}

print_r($countries);

/*********
 * Get List of New Tech Areas
 *********/

$techareas = array();

$query = \Drupal::entityQuery('node');
$query->condition('type', 'technical_area');

$ids = $query->execute();

//print_r($ids);
echo "Total: " . count($ids) . "\n\n";

foreach ($ids as $key => $val){
   $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
   $techareas[$node->get('title')->value] = $key;
}

print_r($techareas);

/*********
 * Get List of New Health Areas
 *********/

$healthareas = array();

$query = \Drupal::entityQuery('node');
$query->condition('type', 'health_areas');

$ids = $query->execute();

//print_r($ids);
echo "Total: " . count($ids) . "\n\n";

foreach ($ids as $key => $val){
   $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
   $healthareas[$node->get('title')->value] = $key;
}

print_r($healthareas);

/***
  Get A Node of type Resource Center
****/

$query = \Drupal::entityQuery('node');
$query->condition('type', 'resource');
$ids = $query->execute();

foreach ($ids as $key => $nId){
  $node = Drupal::entityTypeManager()->getStorage('node')->load($nId);

  /***
    Load old Country Taxonomy
    **/
  $currentCountries = $node->get('countries')->getValue();
  $delta = 0;
  foreach ($currentCountries as $key => $val){
    $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($val['target_id']);
    //echo "\n\nCountry is: [" . $term->get('name')->value . "]\n";
    $countryId = $countries[trim($term->get('name')->value)];
    //echo "Country ID: " . $countryId . "\n\n";
    //echo "Entity ID for New Country is: " . $countryId . "\n\n";
    if ($countryId > 0){
      fwrite($sql, "INSERT INTO node_revision__field_country VALUES ('resource', 0, $nId, $nId, 'und', $delta, $countryId);\n");
      fwrite($sql, "INSERT INTO node__field_country VALUES ('resource', 0, $nId, $nId, 'und', $delta, $countryId);\n");
      $delta++;
    }
  }
}
/*

Need to add countries to two tables:

node_revision__field_country
node__field_country

Fields: [same for both tables]

bundle: resource
deleted: 0
entity_id: [Node ID]
revision_id: [Node ID]
langcode: und
delta: [0 - increments with each country]
field_country_target_id: [country node id]

*/

fclose($sql);

?>
