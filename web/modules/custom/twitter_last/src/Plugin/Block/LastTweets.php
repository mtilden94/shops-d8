<?php
/**
 * @file
 * Contains \Drupal\twitter_last\Plugin\Block\LastTweets.
 */
namespace Drupal\twitter_last\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Abraham\TwitterOAuth\TwitterOAuth;
use Drupal\Core\Template\Attribute;
use Drupal\twitter_last\RenderTweet;
/**
 * @Block(
 *   id = "last_tweets",
 *   admin_label = @Translation("Last Tweets"),
 *   category = @Translation("Blocks")
 * )
 */
class LastTweets extends BlockBase implements BlockPluginInterface {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    $tweets = $this->getTweets();

    $render_tweets = array();
    foreach ($tweets as $tweet) {
      $renderTweet = new RenderTweet($tweet);
      $render_tweets[] = $renderTweet->build();
    }

    $attributes = new Attribute();
    $attributes->addClass('tweets '.$config['wrapper_class']);

    $build = array(
      'tweets' => array(
        '#theme' => 'tweets_list',
        '#tweets' => $render_tweets,
        '#attributes' => $attributes,
        '#more_link_display' => $config['more_link_display']
      ),
      '#cache' => array(
        'max-age' => 300
      )
    );

    return $build;
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['twitter'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Twitter'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );


    $form['twitter']['endpoint'] = array(
      '#type' => 'select',
      '#title' => t('Type'),
      '#options' => array(
        'search/tweets' => t('Search'),
        'statuses/user_timeline' => t('User Timeline'),
      ),
      '#default_value' => !empty($config['endpoint']) ? $config['endpoint'] : '',
    );

    $form['twitter']['query'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Query'),
      '#default_value' => isset($config['query']) ? $config['query'] : '',
      '#required' => TRUE,
    );

    $form['twitter']['token_tree'] = array(
      '#theme' => 'token_tree_link',
      '#token_types' => array('user', 'node'),
      '#show_restricted' => TRUE,
    );

    $form['style'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Style'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );

    $form['style']['tweets_count'] = array (
      '#type' => 'number',
      '#title' => $this->t('Tweets count'),
      '#default_value' => isset($config['tweets_count']) ? $config['tweets_count'] : 1,
      '#min' => 1,
    );

    $form['style']['wrapper_class'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Wrapper class'),
      '#default_value' => isset($config['wrapper_class']) ? $config['wrapper_class'] : '',
    );

    $form['style']['more_link_display'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Link more display'),
      '#default_value' => isset($config['more_link_display']) ? $config['more_link_display'] : 0,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $config = $form_state->getValue('twitter');
    $config_style = $form_state->getValue('style');

    $this->setConfigurationValue('endpoint', $config['endpoint']);
    $this->setConfigurationValue('query', $config['query']);

    $this->setConfigurationValue('tweets_count', $config_style['tweets_count']);
    $this->setConfigurationValue('wrapper_class', $config_style['wrapper_class']);
    $this->setConfigurationValue('more_link_display', $config_style['more_link_display']);
  }

  private function getTweets() {
    // Get module configuration
    $access_config = \Drupal::config('twitter_last.settings');

    // Get block configuration
    $config = $this->getConfiguration();

    $twitter = new TwitterOAuth(
      $access_config->get('customer_key'),
      $access_config->get('customer_secret'),
      $access_config->get('access_token'),
      $access_config->get('access_token_secret')
    );

    $endpoint = $config['endpoint'];

    if($config['endpoint'] == 'statuses/user_timeline') {
      $parameters = array(
        "user_id" => !empty($config['query'])? $config['query'] : '',
        "count" => $config['tweets_count'],
        "exclude_replies" => true
      );

      $tweets = $twitter->get($endpoint, $parameters);

      if(isset($tweets->errors)) {
        drupal_set_message($tweets->errors[0]->message, 'error');
        return array();
      }

      return $tweets;
    } else {
      $token_service = \Drupal::token();
      $node = \Drupal::routeMatch()->getParameter('node');
      
      $data = ['user' => \Drupal::currentUser()];
      if($node) {
        $data['node'] = $node;
      }

      $parameters = array(
        "q" => $token_service->replace($config['query'], $data),
        "count" => $config['tweets_count'],
      );

      $tweets = $twitter->get($endpoint, $parameters);

      if(isset($tweets->errors)) {
        drupal_set_message($tweets->errors[0]->message, 'error');
        return array();
      }

      return $tweets->statuses;
    }
  }
}