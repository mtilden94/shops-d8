<?php

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;
use CommerceGuys\Addressing\Validator\Constraints\AddressFormatConstraint;

//require_once 'core/includes/file.inc';

$autoloader = require_once 'autoload.php';

$request = Request::createFromGlobals();
$kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod');
$kernel->boot();


/*********
 * Get List of New Countries
 *********/

$countries = array();

$query = \Drupal::entityQuery('node');
$query->condition('type', 'countries');

$ids = $query->execute();

print_r($ids);
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

print_r($ids);
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

print_r($ids);
echo "Total: " . count($ids) . "\n\n";

foreach ($ids as $key => $val){
   $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
   $healthareas[$node->get('title')->value] = $key;
}

print_r($healthareas);

/***
  Get A Node of type Resource Center
****/

$node = Drupal::entityTypeManager()->getStorage('node')->load(4929);
print_r($node);

/***
  Load old Country Taxonomy
  **/

$currentCountries = $node->get('countries')->getValue();
foreach ($currentCountries as $key => $val){
  $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($val['target_id']);
  echo "\n\nCountry is: " . $term->get('name')->value . "\n";
  echo "Entity ID for New Country is: " . $countries[$term->get('name')->value] . "\n\n";
}

$node->setTitle('The new Title');
$node->save();

?>
