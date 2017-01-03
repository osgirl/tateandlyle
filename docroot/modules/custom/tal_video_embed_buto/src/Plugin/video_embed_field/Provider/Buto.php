<?php

namespace Drupal\tal_video_embed_buto\Plugin\video_embed_field\Provider;

use Drupal\video_embed_field\ProviderPluginBase;

/**
 * A Buto provider plugin.
 *
 * @VideoEmbedProvider(
 *   id = "buto",
 *   title = @Translation("Buto")
 * )
 */
class Buto extends ProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function renderEmbedCode($width, $height, $autoplay) {

    return [
      '#type' => 'video_embed_iframe',
      '#provider' => 'buto',
      '#url' => sprintf('//embed.buto.tv/%s', $this->getVideoId()),
      '#query' => [
        'autoplay' => $autoplay,
      ],
      '#attributes' => [
        'width' => $width,
        'height' => $height,
        'frameborder' => '0',
        'allowfullscreen' => 'allowfullscreen',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getRemoteThumbnailUrl() {
    return $this->getButoThumbUrl();
  }

  /**
   * Get the buto oembed data.
   *
   * @return string
   *   Path of the image.
   */
  protected function getButoThumbUrl() {
    $url = '//embed.buto.tv/' . $this->getVideoId();
    $client = \Drupal::httpClient();
    $response = $client->get($url);
    $response_data = $response->getBody()->getContents();
    $thumb_url = '';
    if (!empty($response_data)) {
      $doc = new \DOMDocument();
      @$doc->loadHTML($response_data);
      $metas = $doc->getElementsByTagName('meta');
      for ($i = 0; $i < $metas->length; $i++) {
        $meta = $metas->item($i);
        if ($meta->getAttribute('property') == 'og:image') {
          $thumb_url = $meta->getAttribute('content');
        }
      }
    }
    else {
      return FALSE;
    }
    return $thumb_url;
  }

  /**
   * {@inheritdoc}
   */
  public static function getIdFromInput($input) {
    return isset($input) ? $input : FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->oEmbedData()->title;
  }

}
