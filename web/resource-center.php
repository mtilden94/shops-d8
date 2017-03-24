<?php

ini_set("auto_detect_line_endings", true);

/*********************************************************

Pre Implementation Instructions:

1.  Create a taxonomy for Associated Projects:  SHOPS and SHOPS Plus
2.  Add Taxonomy to Resource Center Type.

Post Implementation Instructions:

1. Update views to use SHOPS Plus from the taxonomy for Resources.
2. Add Filters back to the resouce center search.


**********************************************************/


use Drupal\Core\DrupalKernel;
use Drupal\Core\Update\UpdateKernel;
use Symfony\Component\HttpFoundation\Request;
use CommerceGuys\Addressing\Validator\Constraints\AddressFormatConstraint;

require_once 'core/includes/bootstrap.inc';

require_once 'core/includes/file.inc';

$autoloader = require_once 'autoload.php';

/*
$request = Request::createFromGlobals();
$kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod');
$kernel->boot();
*/

$kernel = new UpdateKernel('prod', $autoloader, FALSE);
//$request = Request::createFromGlobals();

// Open an SQL File

$sql = fopen('./resources.sql', 'w+');
$pubdate = strtotime('2016-11-01');
$shopsplus = 0;
$shops = 0;

/*********
 * Get List of New Countries
 *********/

$countries = array();

$query = \Drupal::entityQuery('node');
$query->condition('type', 'countries');

$ids = $query->execute();

//print_r($ids);
//echo "Total: " . count($ids) . "\n\n";

foreach ($ids as $key => $val){
   $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
   $countries[strtolower($node->get('title')->value)] = $val;
}

//print_r($countries);

/*********
 * Get List of New Tech Areas
 *********/

$techareas = array();

$query = \Drupal::entityQuery('node');
$query->condition('type', 'technical_area');

$ids = $query->execute();

//print_r($ids);
//echo "Total: " . count($ids) . "\n\n";

foreach ($ids as $key => $val){
   $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
   $techareas[strtolower($node->get('title')->value)] = $key;
}

//print_r($techareas);

/*********
 * Get List of New Health Areas
 *********/

$healthareas = array();

$query = \Drupal::entityQuery('node');
$query->condition('type', 'health_areas');

$ids = $query->execute();

//print_r($ids);
//echo "Total: " . count($ids) . "\n\n";

foreach ($ids as $key => $val){
   $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
   $healthareas[strtolower($node->get('title')->value)] = $key;
}

//print_r($healthareas);

/****
* Get list of keyword terms in a vocabulary.
****/

$keyword_vocab = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('keywords');
$keyword_collection = array();
foreach ($keyword_vocab as $keyword){
  $keyword_collection[strtolower($keyword->name)] = $keyword->tid;
}
//echo print_r($keyword_collection, true);

if (($keywordMappingFH = fopen('./resource-center-assets/keyword-mappings.csv', 'r')) === FALSE){
  die("Cannot Open Keyword Mappings");
}

$keyword_mappings = array();
while (($data = fgetcsv($keywordMappingFH)) !== false){
  echo "We have data: " . print_r($data, true);
  if (count($data) == 4){
    $keyword = strtolower($data[0]);
    $tech_area = (!empty($data[1])) ? strtolower($data[1]) : null;
    $health_area = (!empty($data[2])) ? strtolower($data[2]) : null;
    $country = (!empty($data[3])) ? strtolower($data[3]) : null;

    if (isset($keyword_collection[$keyword])){
      // We have a matching keyword.
      $keyword_mappings[$keyword_collection[$keyword]] = array();
      if (!is_null($tech_area)){
        // we have a tech area to Map
        if (isset($techareas[$tech_area])){
          // we have a matching tech area to use for the mapping
          $keyword_mappings[$keyword_collection[$keyword]]['tech-area'] = $techareas[$tech_area];
        }
      }
      if (!is_null($health_area)){
        // we have a health area to Map
        if (isset($healthareas[$health_area])){
          // we have a matching health area to use for the mapping
          $keyword_mappings[$keyword_collection[$keyword]]['health-area'] = $healthareas[$health_area];
        }
      }
      if (!is_null($country)){
        // we have a country to Map
        if (isset($countries[$country])){
          // we have a matching country to use for the mapping
          $keyword_mappings[$keyword_collection[$keyword]]['country'] = $countries[$country];
        }
      }
    } // end if keyword
  } // if data == 4
} // end while

fclose($keywordMappingFH);

echo print_r($keyword_mappings, true);

/***
  Get A Node of type Resource Center
****/

$query = \Drupal::entityQuery('node');
$query->condition('type', 'resource');
$ids = $query->execute();

foreach ($ids as $key => $nId){
  if (($key % 10) == 0){ drupal_flush_all_caches(); }

  $node = Drupal::entityTypeManager()->getStorage('node')->load($nId);

  /***
    Load old Country Taxonomy
    **
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

  */

  //  check dates on node, set the shops and shops+ checkboxes accordingly.
  //  Lets use November 1, 2016 as the cutoff for shops to shops+
  //  1153 is shops plus id
  //  1152 is shops id

//  if ($nId == 18041){

    $created = $node->get('created')->getValue();
    if ($created[0]['value'] > $pubdate){
      $shopsplus++;
      $node->set('field_associated_project', array(1153));
    }else{
      $shops++;
      $node->set('field_associated_project', array(1152));
    }


  // Load the old keywords.

  $keywords = $node->get('keywords')->getValue();
  //echo print_r($keywords, true);

  // map the keywords to tech, health, and country content types.

  // Consolidate the resource types



    //$node->save();
    //echo "Saved Node $nId\n";
//  }  // end if 18041
  unset($node);
} // end foreach

echo "Shops Plus: $shopsplus\n";
echo "Shops: $shops\n";

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
