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
          if ($tech_area === $keyword){
            $keyword_mappings[$keyword_collection[$keyword]]['retag'] = false;
          }else{
            $keyword_mappings[$keyword_collection[$keyword]]['retag'] = true;
          }
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
          if ($health_area === $keyword or $keyword === 'family planning/reproductive health'){
            $keyword_mappings[$keyword_collection[$keyword]]['retag'] = false;
          }else{
            $keyword_mappings[$keyword_collection[$keyword]]['retag'] = true;
          }
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
          if ($country === $keyword){
            $keyword_mappings[$keyword_collection[$keyword]]['retag'] = false;
          }else{
            $keyword_mappings[$keyword_collection[$keyword]]['retag'] = true;
          }
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

function getResourceTypeMappings(){

  $rt_vocab = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('resource_types');
  foreach ($rt_vocab as $rt){
    $rt_collection[strtolower($rt->name)] = $rt->tid;
  }

  $resourceTM = array(
    $rt_collection['article'] => $rt_collection['journal publication'],
    $rt_collection['chat transcript'] => $rt_collection['other'],
    $rt_collection['country assessment'] => $rt_collection['report'],
    $rt_collection['discussion paper'] => $rt_collection['other'],
    $rt_collection['global research report'] => $rt_collection['report'],
    $rt_collection['graphic'] => $rt_collection['other'],
    $rt_collection['handbook'] => $rt_collection['tool'],
    $rt_collection['link'] => $rt_collection['other'],
    $rt_collection['meeting notes'] => $rt_collection['other'],
    $rt_collection['occasional paper'] => $rt_collection['other'],
    $rt_collection['one pager'] => $rt_collection['information sheet'],
    $rt_collection['technical report'] => $rt_collection['report'],
    $rt_collection['working paper'] => $rt_collection['other'],
    $rt_collection['blog'] => null,
    $rt_collection['cd-rom'] => null,
    $rt_collection['citation'] => null,
    $rt_collection['literature review'] => null,
    $rt_collection['research study'] => null,
    $rt_collection['strategic analysis'] => null,
    $rt_collection['up close'] => null
  );


  return $resourceTM;

}

function processResourceCenter($keyword_mappings){

  $pubdate = strtotime('2016-11-01');
  $shopsplus = 0;
  $shops = 0;

  $typeMappings = getResourceTypeMappings();

  writeLog("Loading Projects ... ", true, false);

  $projects = array();
  getProjectCollection($projects);

  writeLog("Done", false);
  //echo print_r($projects, true);

  writeLog("Loading Resource Center Node Ids ... ", true, false);
  $query = \Drupal::entityQuery('node');
  $query->condition('type', 'resource');
  $ids = $query->execute();
  writeLog("Done", false);

  writeLog("Beginning loop through the Resource Center Ids");

  foreach ($ids as $key => $nId){
    if (($key % 10) == 0){ writeLog("Flushing cache ... ", true, false); drupal_flush_all_caches(); writeLog("Done", false); } // flush the cache every 10 nodes just to keep the memory clean.

    writeLog("Loading Node (" . $nId . ") ... ", true, false);
    $node = Drupal::entityTypeManager()->getStorage('node')->load($nId);
    writeLog("Done", false);

    $created = $node->get('created')->getValue();
    if ($created[0]['value'] > $pubdate){
      $shopsplus++;
      $node->set('field_associated_project', array($projects['shops plus']));
      writeLog("Node set to shops plus");
    }else{
      $shops++;
      $node->set('field_associated_project', array($projects['shops']));
      writeLog("Node set to shops");
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
              if (!in_array($ct_id, $new_countries)){
                $new_countries[] = $ct_id;
              }
              break;

            case "tech-area":
              if (!in_array($ct_id, $new_techareas)){
                $new_techareas[] = $ct_id;
              }
              break;

            case "health-area":
              if (!in_array($ct_id, $new_healthareas)){
                $new_healthareas[] = $ct_id;
              }
              break;

            case "retag":
              if ($ct_id){
                // Add this word back into the keyword area because it is different then the primary country, tech area, or health area.
                $new_keywords[] = $target;
              }
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
      $node->set('keywords', $new_keywords);
      writeLog("New Keywords: " . print_r($new_keywords, true));
      $node->set('field_country', $new_countries);
      writeLog("New Countries: " . print_r($new_countries, true));
      $node->set('field_technical_area', $new_techareas);
      writeLog("New TechAreas: " . print_r($new_techareas, true));
      $node->set('field_health_area', $new_healthareas);
      writeLog("New Health Areas: " . print_r($new_healthareas, true));
      $node->set('field_retagged_keywords', $retagged_keywords);
      writeLog("Retagged Keywords: " . print_r($retagged_keywords, true));
    }else{
      writeLog("No retagging needed.");
    }

    // Consolidate the resource types
    $newResourceTypes = array();
    $currentRTs = $node->get('resource_types')->getValue();
    foreach ($currentRTs as $currentItem) {
      if (isset($typeMappings[$currentItem['target_id']])){
        // we have a mapping or a deletion
        if (!is_null($typeMappings[$currentItem['target_id']])){
          // not a deletions, add the mapped id.
          $newResourceTypes[] = $typeMappings[$currentItem['target_id']];
        } // else we skip it cuz we're deleting it.
      }else{
        // its not set, so we're keeping it.
        $newResourceTypes[] = $currentItem['target_id'];
      }
    }
    writeLog("New Resource Types: " . print_r($newResourceTypes, true));
    $node->set('resource_types', $newResourceTypes);

    //echo "Saved Node $nId\n";
    writeLog("Saving Node ... ", true, false);
    $node->save();
    unset($node);
    writeLog("Done\n", false);
  } // end foreach
  writeLog("End looping through Resource Center Nodes.");
  writeLog("Shops Plus: $shopsplus");
  writeLog("Shops: $shops");

}

function writeLog($str, $addDate = true, $newline = true){

  global $log;

  if ($addDate){
    $str = date('r') . ": " . $str;
  }

  if ($newline){
    $str .= "\n";
  }

  if (fwrite($log, $str) === false){
    return false;
  }

  return true;
}

?>
