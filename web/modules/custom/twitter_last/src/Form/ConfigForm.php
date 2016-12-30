<?php

namespace Drupal\twitter_last\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Abraham\TwitterOAuth\TwitterOAuth;
/**
 *  Build Twitter Last settings form.s
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'twitter_last_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'twitter_last.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('twitter_last.settings');

    $form['twitter'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Twitter'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      '#token_insert' => TRUE,
    );

    $form['twitter']['customer_key'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Customer key'),
      '#default_value' => $config->get('customer_key'),
      '#required' => TRUE
    );

    $form['twitter']['customer_secret'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Customer secret'),
      '#default_value' => $config->get('customer_secret'),
      '#required' => TRUE
    );

    $form['twitter']['access_token'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Access token'),
      '#default_value' => $config->get('access_token'),
      '#required' => TRUE
    );

    $form['twitter']['access_token_secret'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Access token secret'),
      '#default_value' => $config->get('access_token_secret'),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $config = $form_state->cleanValues()->getValues();

    $twitter = new TwitterOAuth(
      isset($config['customer_key']) ? $config['customer_key'] : '',
      isset($config['customer_secret']) ? $config['customer_secret'] : '',
      isset($config['access_token']) ? $config['access_token'] : '',
      isset($config['access_token_secret']) ? $config['access_token_secret'] : ''
    );

    $tweets = $twitter->get("search/tweets", array(
      'q' => '@twitter'
    ));

    if(isset($tweets->errors)) {
      $form_state->setErrorByName("twitter][access_token", $tweets->errors[0]->message);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->cleanValues()->getValues();

    $this->config('twitter_last.settings')
      ->setData($values)
      ->save();
  }
}
