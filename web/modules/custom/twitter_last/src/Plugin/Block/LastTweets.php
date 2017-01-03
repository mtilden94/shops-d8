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
use Drupal\Core\Cache\Cache;
/**
 * @Block(
 *   id = "last_tweets",
 *   admin_label = @Translation("Last Tweets"),
 *   category = @Translation("Blocks")
 * )
 */
class LastTweets extends BlockBase implements BlockPluginInterface {

  private $token_service;

  function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->token_service = \Drupal::token();
  }


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

    $more_link_url = "https://twitter.com/search?q=";
    $more_link_url .= urlencode($this->token_service->replace(!empty($config['url'])? $config['url'] : '#', static::getTokenData()), ['clear' => TRUE]);

    $build = array(
      'tweets' => array(
        '#theme' => 'tweets_list',
        '#tweets' => $render_tweets,
        '#attributes' => $attributes,
        '#more_link_display' => $config['more_link_display'],
        '#more_link' => array(
          'url' => $more_link_url,
          'link_title' => $this->token_service->replace(!empty($config['link_title'])? $config['link_title'] : 'More', static::getTokenData(), ['clear' => TRUE])
        )
      ),
      '#cache' => array(
        'max-age' => 3000,
        'tags' => $this->getCacheTags(),
        'contexts' => $this->getCacheContexts(),
      )
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      return Cache::mergeTags(parent::getCacheTags(), array('node:' . $node->id()));
    } else {
      return parent::getCacheTags();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
  }

  static function getTokenData() {
    $node = \Drupal::routeMatch()->getParameter('node');

    $data = ['user' => \Drupal::currentUser()];
    if($node) {
      $data['node'] = $node;
    }

    return $data;
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

    $form['style']['url'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Link more: Query'),
      '#default_value' => isset($config['url']) ? $config['url'] : '',
    );

    $form['style']['token_tree_url'] = array(
      '#theme' => 'token_tree_link',
      '#token_types' => array('node'),
      '#show_restricted' => TRUE,
    );

    $form['style']['link_title'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Link more: Title'),
      '#default_value' => isset($config['link_title']) ? $config['link_title']:'',
    );

    $form['style']['token_tree_link_title'] = array(
      '#theme' => 'token_tree_link',
      '#token_types' => array('node'),
      '#show_restricted' => TRUE,
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
    $this->setConfigurationValue('url', $config_style['url']);
    $this->setConfigurationValue('link_title', $config_style['link_title']);
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

      $parameters = array(
        "q" => $this->token_service->replace($config['query'], static::getTokenData(), ['clear' => TRUE]),
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