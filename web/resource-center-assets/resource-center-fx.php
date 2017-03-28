<?php

function getCountries(&$countries) {

  $query = \Drupal::entityQuery('node');
  $query->condition('type', 'countries');

  $ids = $query->execute();

  foreach ($ids as $key => $val){
     $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
     $countries[strtolower($node->get('title')->value)] = $val;
  }
}

function getTechAreas(&$techareas){

  $query = \Drupal::entityQuery('node');
  $query->condition('type', 'technical_area');

  $ids = $query->execute();

  foreach ($ids as $key => $val){
     $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
     $techareas[strtolower($node->get('title')->value)] = $val;
  }
}

function getHealthAreas(&$healthareas){
  $query = \Drupal::entityQuery('node');
  $query->condition('type', 'health_areas');

  $ids = $query->execute();

  foreach ($ids as $key => $val){
     $node = \Drupal::entityTypeManager()->getStorage('node')->load($val);
     $healthareas[strtolower($node->get('title')->value)] = $val;
  }
}

function getKeywordCollection(&$keyword_collection){
  $keyword_vocab = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('keywords');
  foreach ($keyword_vocab as $keyword){
    $keyword_collection[strtolower($keyword->name)] = $keyword->tid;
  }
}

function getProjectCollection(&$project_collection){
  $project_vocab = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('associated_project');
  foreach ($project_vocab as $project){
    $project_collection[strtolower($project->name)] = $project->tid;
  }
}

function createKeywordMappings(&$keyword_mappings, &$missing_elements, $keyword_collection, &$countries, &$techareas, &$healthareas){

  $keywordMappingFH = null;
  $keyword = null;
  $tech_area = null;
  $country = null;
  $health_area = null;


  if (($keywordMappingFH = fopen('./resource-center-assets/keyword-mappings.csv', 'r')) === FALSE){
    die("Cannot Open Keyword Mappings");
  }

  while (($data = fgetcsv($keywordMappingFH)) !== false){
    //echo "We have data: " . print_r($data, true);
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
          }else{
            // node is missing, lets try to create it.

            $node = \Drupal::entityTypeManager()->getStorage('node')->create(array(
              'type'        => 'technical_area',
              'title'       => ucwords($tech_area)
            ));
            $node->save();
            getTechAreas($techareas);

            if (isset($techareas[$tech_area])){
              // creation successfull
              $keyword_mappings[$keyword_collection[$keyword]]['tech-area'] = $techareas[$tech_area];
            }else{
              // creation failed. throw an error.
              $missing_elements[] = "Missing TechArea: " . $tech_area;
            }
          }
        }

        if (!is_null($health_area)){
          // we have a health area to Map
          if (isset($healthareas[$health_area])){
            // we have a matching health area to use for the mapping
            $keyword_mappings[$keyword_collection[$keyword]]['health-area'] = $healthareas[$health_area];
          }else{
            // node is missing, lets try to create it.
            $node = \Drupal::entityTypeManager()->getStorage('node')->create(array(
              'type'        => 'health_areas',
              'title'       => ucwords($health_area)
            ));
            $node->save();
            getHealthAreas($healthareas);
            if (isset($healthareas[$health_area])){
              $keyword_mappings[$keyword_collection[$keyword]]['health-area'] = $healthareas[$health_area];
            }else{
              $missing_elements[] = "Missing Health Area: " . $health_area;
            }
          }
        }
        if (!is_null($country)){
          // we have a country to Map
          if (isset($countries[$country])){
            // we have a matching country to use for the mapping
            $keyword_mappings[$keyword_collection[$keyword]]['country'] = $countries[$country];
          }else{
            $node = \Drupal::entityTypeManager()->getStorage('node')->create(array(
              'type'        => 'countries',
              'title'       => ucwords($country)
            ));
            $node->save();
            getCountries($countries);
            if (isset($countries[$country])){
              $keyword_mappings[$keyword_collection[$keyword]]['country'] = $countries[$country];
            }else{
              $missing_elements[] = "Missing Country: " . $country;
            }
          }
        }
      } // end if keyword
    } // if data == 4
  } // end while

  fclose($keywordMappingFH);

}

function processResourceCenter($keyword_mappings){

  $projects = array();
  getProjectCollection($projects);

  //echo print_r($projects, true);

  $query = \Drupal::entityQuery('node');
  $query->condition('type', 'resource');
  $ids = $query->execute();

  foreach ($ids as $key => $nId){
    if (($key % 10) == 0){ drupal_flush_all_caches(); } // flush the cache every 10 nodes just to keep the memory clean.

    $node = Drupal::entityTypeManager()->getStorage('node')->load($nId);

    $created = $node->get('created')->getValue();
    if ($created[0]['value'] > $pubdate){
      $shopsplus++;
      $node->set('field_associated_project', array($projects['shops plus']));
    }else{
      $shops++;
      $node->set('field_associated_project', array($projects['shops']));
    }

    $keywords = $node->get('keywords')->getValue();

    $new_keywords = array();
    $retagged_keywords = array();
    $new_countries = array();
    $new_techareas = array();
    $new_healthareas = array();

    foreach ($keywords as $key => $word_array){
      $target = $word_array['target_id'];
      if (isset($keyword_mappings[$target]) and count($keyword_mappings[$target]) > 0){
        // We have a mapping.
        $retagged_keywords[] = $target;
        foreach ($keyword_mappings[$target] as $ct => $ct_id){
          switch ($ct){
            case "country":
              $new_countries[] = $ct_id;
              break;

            case "tech-area":
              $new_techareas[] = $ct_id;
              break;

            case "health-area":
              $new_healthareas[] = $ct_id;
              break;
          } // end switch
        } // end foreach keyword mapping.

        // Now new_countries, new_techareas, and new_healthareas are set.  Lets make sure any old
        // values are not deleted.
        $current = $node->get('field_country')->getValue();
        foreach ($current as $currentItem){
          if (! in_array($currentItem['target_id'], $new_countries)){
            $new_countries[] = $currentItem['target_id'];
          }
        }
        $current = $node->get('field_technical_area')->getValue();
        foreach ($current as $currentItem){
          if (! in_array($currentItem['target_id'], $new_techareas)){
            $new_techareas[] = $currentItem['target_id'];
          }
        }
        $current = $node->get('field_health_area')->getValue();
        foreach ($current as $currentItem){
          if (! in_array($currentItem['target_id'], $new_healthareas)){
            $new_healthareas[] = $currentItem['target_id'];
          }
        }

      }else{
        // we'll just keep the keyword in the same field.
        $new_keywords[] = $target;
      }
    }


    if (count($retagged_keywords) > 0){
      echo "Node modified: $nId\n";
      $node->set('keywords', $new_keywords);
      $node->set('field_country', $new_countries);
      $node->set('field_technical_area', $new_techareas);
      $node->set('field_health_area', $new_healthareas);
      $node->set('field_retagged_keywords', $retagged_keywords);
    }

    // Consolidate the resource types

    //echo "Saved Node $nId\n";
    $node->save();
    unset($node);
  } // end foreach

  echo "Shops Plus: $shopsplus\n";
  echo "Shops: $shops\n";

}

?>
