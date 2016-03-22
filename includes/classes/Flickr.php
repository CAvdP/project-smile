<?php

/**
 * @class       Flickr
 * @version     1.0
 * @author      http://www.web-development-blog.com/archives/flickr-photo-search-api/
 * @description Class to connect with Flickr & retrieve data
 */
class Flickr
{
    private $endpoint = 'https://api.flickr.com/services/rest/?';
    private $apiKey;
    private $apiSecret;

    /**
     * Initialize object with desired client settings
     *
     * @param $apiKey
     * @param $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }   

    /**
     * Setting up a request for getting photos of user
     *
     * @param string $userId
     * @param string $photosetId
     * @param string $format
     * @param int $privacy
     * @return mixed|null
     */
    public function getPhotos($userId = '141096045@N04', $photosetId = '72157663898087443', $format = 'php_serial', $privacy = 5)
    {
        $params = [
            'method' => 'flickr.photosets.getPhotos',
            'api_key' => $this->apiKey,
            'user_id' => $userId,
            'photoset_id' => $photosetId,
            'format' => $format,
            'privacy_filter' => $privacy
        ];

        $url = $this->endpoint . http_build_query($params);
        $result = $this->curlRequest($url);
        return $result;
    }

    /**
     * Function for uploading photos
     *
     * @param string $userId
     * @param string $photosetId
     * @param string $format
     * @param int $privacy
     */
    public function uploadPhoto($userId = '141096045@N04', $photosetId = '72157663898087443', $format = 'php_serial', $privacy = 5)
    {

    }

    /**
     * Getting the data from the flickr api
     *
     * @param $url
     * @return mixed|null
     */
    private function curlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $data = curl_exec($ch);
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $returnCode == 200 ? unserialize($data) : null;
    }
}
