<?php

namespace Drupal\abt_common\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\datetime\Plugin\Field\FieldFormatter\DateTimeFormatterBase;
use Drupal\datetime_range\Plugin\Field\FieldFormatter\DateRangeCustomFormatter;
use Drupal\datetime_range\Plugin\Field\FieldFormatter\DateRangeDefaultFormatter;

/**
 * Plugin implementation of the 'Date summary' formatter for 'datetime' fields.
 *
 * @FieldFormatter(
 *   id = "datetime_summary",
 *   label = @Translation("Date summary"),
 *   field_types = {
 *     "daterange"
 *   }
 * )
 */
class DateTimeSummaryFormatter extends DateRangeCustomFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $iso_date = '';

      // Display the date using theme datetime.
      $elements[$delta] = array(
        '#cache' => [
          'contexts' => [
            'timezone',
          ],
        ],
        '#theme' => 'datetime_summary',
        '#html' => FALSE,
        '#attributes' => array(
          'datetime' => $iso_date,
        ),
      );

      $value = $item->getValue();
      $start_timestamp = strtotime($value['value']);
      $start_month = $this->dateFormatter->format($start_timestamp, 'custom', 'F');
      $start_year = $this->dateFormatter->format($start_timestamp, 'custom', 'Y');
      $end_timestamp = strtotime($value['end_value']);
      $end_month = $this->dateFormatter->format($end_timestamp, 'custom', 'F');
      $end_year = $this->dateFormatter->format($end_timestamp, 'custom', 'Y');
      $combined = $start_month == $end_month && $start_year == $end_year ? TRUE : FALSE;
      $elements[$delta]['#combined'] = $combined;
      if ($combined) {
        $elements[$delta]['#month'] = $start_month;
        $start_date = $this->dateFormatter->format($start_timestamp, 'custom', 'j');
        $end_date = $this->dateFormatter->format($end_timestamp, 'custom', 'j');
        $year = $this->dateFormatter->format($end_timestamp, 'custom', 'Y');
        $elements[$delta]['#year'] = $year;
        $dates = $start_date == $end_date ? $start_date : $start_date . $this->getSetting('separator') . $end_date;
        $elements[$delta]['#dates'] = $dates;
      }
      else {
        if ($start_year == $end_year) {
          $elements[$delta]['#end_year'] = $end_year;
        }
        else {
          $elements[$delta]['#start_year'] = $start_year;
          $elements[$delta]['#end_year'] = $end_year;
        }
        $elements[$delta]['#start_month'] = $start_month;
        $elements[$delta]['#end_month'] = $end_month;
        $start_date = $this->dateFormatter->format($start_timestamp, 'custom', 'j');
        $elements[$delta]['#start_date'] = $start_date;
        $end_date = $this->dateFormatter->format($end_timestamp, 'custom', 'j');
        $elements[$delta]['#end_date'] = $end_date;
      }

      if (!empty($item->_attributes)) {
        $elements[$delta]['#attributes'] += $item->_attributes;
        // Unset field item attributes since they have been included in the
        // formatter output and should not be rendered in the field template.
        unset($item->_attributes);
      }
    }

    return $elements;

  }
}
