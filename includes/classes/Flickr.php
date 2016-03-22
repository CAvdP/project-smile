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
    private $upload_endpoint = 'https://up.flickr.com/services/upload/';
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
     * @param return mixed|null
     */
//    public function uploadPhoto($userId = '141096045@N04', $photosetId = '72157663898087443', $format = 'php_serial', $privacy = 5)
//    {
//        $params = [
//            'method' =>
//
//        ];
//
//        $url = $this->uploadEndPoint . http_build_query($params);
//        $result = $this->curlRequest($url);
//        return $result;
//    }

    function auth_getToken ($frob) {
        /* https://www.flickr.com/services/api/flickr.auth.getToken.html */
        $this->request('flickr.auth.getToken', array('frob'=>$frob));
        $_SESSION['phpFlickr_auth_token'] = $this->parsed_response['auth']['token'];
        return $this->parsed_response ? $this->parsed_response['auth'] : false;
    }


    function async_upload ($photo, $title = null, $description = null, $tags = null, $is_public = null, $is_friend = null, $is_family = null) {
        if ( function_exists('curl_init') ) {
            // Has curl. Use it!
            //Process arguments, including method and login data.
            $args = array(
                "async" => 1,
                "api_key" => $this->apiKey,
                "title" => $title,
                "description" => $description,
                "tags" => $tags,
                "is_public" => $is_public,
                "is_friend" => $is_friend,
                "is_family" => $is_family);
            if (!empty($this->token)) {
                $args = array_merge($args, array("auth_token" => $this->token));
            } elseif (!empty($_SESSION['phpFlickr_auth_token'])) {
                $args = array_merge($args, array("auth_token" => $_SESSION['phpFlickr_auth_token']));
            }
            ksort($args);
            $auth_sig = "";
            foreach ($args as $key => $data) {
                if ( is_null($data) ) {
                    unset($args[$key]);
                } else {
                    $auth_sig .= $key . $data;
                }
            }
            if (!empty($this->secret)) {
                $api_sig = md5($this->secret . $auth_sig);
                $args["api_sig"] = $api_sig;
            }
            $photo = realpath($photo);
            $args['photo'] = '@' . $photo;
            $curl = curl_init($this->upload_endpoint);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            $this->response = $response;
            curl_close($curl);
            $rsp = explode("\n", $response);
            foreach ($rsp as $line) {
                if (preg_match('/<err code="([0-9]+)" msg="(.*)"/', $line, $match)) {
                    if ($this->die_on_error)
                        die("The Flickr API returned the following error: #{$match[1]} - {$match[2]}");
                    else {
                        $this->error_code = $match[1];
                        $this->error_msg = $match[2];
                        $this->parsed_response = false;
                        return false;
                    }
                } elseif (preg_match("/<ticketid>(.*)</", $line, $match)) {
                    $this->error_code = false;
                    $this->error_msg = false;
                    return $match[1];
                }
            }
        } else {
            die("Sorry, your server must support CURL in order to upload files");
        }
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
