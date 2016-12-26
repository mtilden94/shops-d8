<?php

namespace Drupal\eventbrite_pull\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\eventbrite_pull\Eventbrite;
/**
 *  Build Eventbrite Pull settings form.s
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'eventbrite_pull_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'eventbrite_pull.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('eventbrite_pull.settings');

    /*$eventbrite = new Eventbrite('VV5E5YJU6MWUFKDZY6JW');
    $eventbrite->get('organizers/'. 8460585411 .'/events');*/

    /*$node->eventbrite = (object)[
      'id' => md5(1),
      'created' => time(),
      'changed' => time()
    ];*/

    $form['oauth_token'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('OAuth token'),
      '#default_value' => $config->get('oauth_token'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    $form['organizer_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Organizer id'),
      '#default_value' => $config->get('organizer_id'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    $form['cron_enable'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Cron enable'),
      '#default_value' => $config->get('cron_enable'),
    );

    $form['node_published'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Node Published'),
      '#default_value' => $config->get('node_published'),
    );

    $form['delete_old'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Delete old events'),
      '#default_value' => $config->get('delete_old'),
    );

    $form['actions']['pull'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save & Pull'),
      '#submit' => array('::submitForm', '::runPull'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->cleanValues()->getValues();

    $this->config('eventbrite_pull.settings')
      ->setData($values)
      ->save();
  }

  public function runPull(array &$form, FormStateInterface $form_state) {
    $operations = $this->getBatchOperations();

  }

  public function getBatchOperations() {
    $config = $this->config('eventbrite_pull.settings');
    $operations = array();

    $eventbrite = new Eventbrite($config->get('oauth_token'));
    $data = $eventbrite->get('organizers/' . $config->get('organizer_id') . '/events');

    if($data) {
      foreach ($data->events as $event) {
        $operations = ['sds', [$event]];
      }

      return $operations;
    }

    return FALSE;
  }
}
