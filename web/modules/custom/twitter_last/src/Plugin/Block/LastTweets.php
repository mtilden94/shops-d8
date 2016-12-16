<?php
/**
 * @file
 * Contains \Drupal\twitter_last\Plugin\Block\LastTweets.
 */
namespace Drupal\twitter_last\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Abraham\TwitterOAuth\TwitterOAuth;
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
      $render_tweets[] = $this->renderTweet($tweet);
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

    $form['twitter']['customer_key'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Customer key'),
      '#default_value' => isset($config['customer_key']) ? $config['customer_key'] : '',
      '#required' => TRUE
    );

    $form['twitter']['customer_secret'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Customer secret'),
      '#default_value' => isset($config['customer_secret']) ? $config['customer_secret'] : '',
      '#required' => TRUE
    );

    $form['twitter']['access_token'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Access token'),
      '#default_value' => isset($config['access_token']) ? $config['access_token'] : '',
      '#required' => TRUE
    );

    $form['twitter']['access_token_secret'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Access token secret'),
      '#default_value' => isset($config['access_token_secret']) ? $config['access_token_secret'] : '',
      '#required' => TRUE,
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
  public function blockValidate($form, FormStateInterface $form_state) {
    $config = $form_state->getValue('twitter');
    $config_style = $form_state->getValue('style');

    $twitter = new TwitterOAuth(
      isset($config['customer_key']) ? $config['customer_key'] : '',
      isset($config['customer_secret']) ? $config['customer_secret'] : '',
      isset($config['access_token']) ? $config['access_token'] : '',
      isset($config['access_token_secret']) ? $config['access_token_secret'] : ''
    );

    $user_timeline = $twitter->get("statuses/user_timeline", array(
      "user_id" => 123355425,
      "count" => $config_style['tweets_count'],
      "exclude_replies" => true
    ));

    if(isset($user_timeline->errors)) {
      $form_state->setErrorByName("twitter][access_token", $user_timeline->errors[0]->message);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $config = $form_state->getValue('twitter');
    $config_style = $form_state->getValue('style');

    // Set customer key
    if(isset($config['customer_key'])) {
      $this->setConfigurationValue('customer_key', $config['customer_key']);
    }
    // Set customer secret
    if(isset($config['customer_secret'])) {
      $this->setConfigurationValue('customer_secret', $config['customer_secret']);
    }
    // Set access token
    if(isset($config['access_token'])) {
      $this->setConfigurationValue('access_token', $config['access_token']);
    }
    // Set access token secret
    if(isset($config['access_token_secret'])) {
      $this->setConfigurationValue('access_token_secret', $config['access_token_secret']);
    }

    $this->setConfigurationValue('tweets_count', $config_style['tweets_count']);
    $this->setConfigurationValue('wrapper_class', $config_style['wrapper_class']);
    $this->setConfigurationValue('more_link_display', $config_style['more_link_display']);
  }

  private function getTweets() {
    // Get block configuration
    $config = $this->getConfiguration();

    $twitter = new TwitterOAuth(
      isset($config['customer_key']) ? $config['customer_key'] : '',
      isset($config['customer_secret']) ? $config['customer_secret'] : '',
      isset($config['access_token']) ? $config['access_token'] : '',
      isset($config['access_token_secret']) ? $config['access_token_secret'] : ''
    );
    
    return $twitter->get("statuses/user_timeline", array(
      "user_id" => 123355425,
      "count" => $config['tweets_count'],
      "exclude_replies" => true
    ));
  }

  private function renderTweet($tweet) {
    $text = $tweet->text;

    // Replace Tags
    foreach ($tweet->entities->hashtags as $hashtag) {
      $url = Url::fromUri("https://twitter.com/hashtag/". $hashtag->text);
      $url->setOption('attributes', array(
        'target' => '_blank'
      ));

      $link = Link::fromTextAndUrl("#".$hashtag->text, $url)->toString();
      $text = str_replace("#".$hashtag->text, $link, $text);
    }

    // Replace Users
    foreach ($tweet->entities->user_mentions as $user) {
      $url = Url::fromUri("https://twitter.com/". $user->screen_name);
      $url->setOption('attributes', array(
        'target' => '_blank'
      ));

      $link = Link::fromTextAndUrl("@".$user->screen_name, $url)->toString();
      $text = str_replace("@".$user->screen_name, $link, $text);
    }

    // Replace Urls
    foreach ($tweet->entities->urls as $url_value) {
      $url = Url::fromUri($url_value->url);
      $url->setOption('attributes', array(
        'class' => array('external'),
        'target' => '_blank'
      ));

      $link = Link::fromTextAndUrl($url_value->url, $url)->toString();
      $text = str_replace($url_value->url, $link, $text);
    }


    return array(
      '#theme' => 'tweet_display',
      '#text' => array(
        '#type' => 'inline_template',
        '#template' => $text,
      ),
      '#created_at' => date('M j', strtotime($tweet->created_at)),
      '#user' => $tweet->user->screen_name,
    );
  }
}