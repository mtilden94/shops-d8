<?php

ini_set("auto_detect_line_endings", true);

/*********************************************************

Pre Implementation Instructions:

1.  Create a taxonomy for Associated Projects:  SHOPS and SHOPS Plus (associated_project)
2.  Add Taxonomy to Resource Center Type. (associated_project)
3.  Add a field to Resource Center Type to hold retagged keywords. (retagged_keywords)

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

$kernel = new UpdateKernel('prod', $autoloader, FALSE);

$pubdate = strtotime('2016-11-01');
$shopsplus = 0;
$shops = 0;

require_once 'resource-center-assets/resource-center-fx.php';

/*********
 * Get List of New Countries
 *********/

$countries = array();
getCountries($countries);

/*********
 * Get List of New Tech Areas
 *********/

$techareas = array();
getTechAreas($techareas);

/*********
 * Get List of New Health Areas
 *********/

$healthareas = array();
getHealthAreas($healthareas);

/****
* Get list of keyword terms in a vocabulary.
****/

$keyword_collection = array();
getKeywordCollection($keyword_collection);

//echo print_r($keyword_collection, true);

$keyword_mappings = array();
$missing_elements = array();
createKeywordMappings($keyword_mappings, $missing_elements, $keyword_collection, $countries, $techareas, $healthareas);

//echo print_r($keyword_mappings, true);

drupal_flush_all_caches();

if (count($missing_elements) > 0){
  echo print_r($missing_elements, true);
  exit(0);
}

/***
  Get A Node of type Resource Center
****/

processResourceCenter($keyword_mappings);

?>
