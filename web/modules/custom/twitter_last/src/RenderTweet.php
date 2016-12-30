<?php

namespace Drupal\twitter_last;

use Drupal\Core\Url;
use Drupal\Core\Link;

class RenderTweet {

  protected $content;
  protected $tweet;

  function __construct($tweet) {
    $this->tweet = $tweet;
    $this->content = $tweet->text;

    $this->replaceTags();
    $this->replaceUsers();
    $this->replaceUrls();
  }

  public function build() {
    return array(
      '#theme' => 'tweet_display',
      '#text' => array(
        '#type' => 'inline_template',
        '#template' => $this->content,
      ),
      '#created_at' => date('M j', strtotime($this->tweet->created_at)),
      '#user' => $this->tweet->user->screen_name,
    );
  }

  private function createLink($text, $uri) {
    $url = Url::fromUri($uri);
    $url->setOption('attributes', array(
      'target' => '_blank'
    ));

    return $link = Link::fromTextAndUrl($text, $url)->toString();
  }

  private function entityReplace($text, $uri) {
    $link = $this->createLink($text, $uri);
    $this->content = str_replace($text, $link, $this->content);
  }

  private function replaceTags() {
    foreach ($this->tweet->entities->hashtags as $hashtag) {
      $this->entityReplace(
        "#".$hashtag->text,
        "https://twitter.com/hashtag/". $hashtag->text
      );
    }
  }

  private function replaceUsers() {
    foreach ($this->tweet->entities->user_mentions as $user) {
      $this->entityReplace(
        "@".$user->screen_name,
        "https://twitter.com/". $user->screen_name
      );
    }
  }

  private function replaceUrls() {
    foreach ($this->tweet->entities->urls as $url_value) {
      $this->entityReplace(
        $url_value->url,
        $url_value->url
      );
    }
  }


}