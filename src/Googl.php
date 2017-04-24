<?php

namespace DominikVeils\Googl;

use RuntimeException;

/**
 * Class Googl
 * @package DominikVeils\Googl
 */
class Googl
{
    const BASE_URL = 'https://www.googleapis.com/urlshortener/v1/url?key=%s';
    
    /**
     * @var string
     */
    private $api_key;
    
    /**
     * @var Network
     */
    private $network;
    
    /**
     * @param string $api_key
     * @param Network $network
     */
    function __construct($api_key, Network $network = null)
    {
        $this->api_key = $api_key;
        $this->network = is_null($network) ? new Network : $network;
    }
    
    /**
     * @param string $long_url
     *
     * @return mixed
     * @throws RuntimeException
     */
    public function shorten($long_url)
    {
        $url = sprintf(static::BASE_URL, $this->api_key);
        $response = $this->network->post($url, [
            'longUrl' => $long_url
        ]);
        
        if ($response) {
            $response = json_decode($response, true);
            if (isset($response['error'])) {
                throw new RuntimeException($response['error']['message'], $response['error']['code']);
            }
            return $response['id'];
        }
    
        throw new RuntimeException("Could not create short url!");
    }
    
    /**
     * @param string $short_url
     *
     * @return string
     * @throws RuntimeException
     */
    public function expand($short_url)
    {
        $url = sprintf(static::BASE_URL, $this->api_key);
        $url .= '&' . http_build_query(['shortUrl' => $short_url]);
        
        $response = $this->network->get($url);
    
        if ($response) {
            $response = json_decode($response, true);
            if (isset($response['error'])) {
                throw new RuntimeException($response['error']['message'], $response['error']['code']);
            }
            return $response['longUrl'];
        }
    
        throw new RuntimeException("Could not expand url!");
    }
}