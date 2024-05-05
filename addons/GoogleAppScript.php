<?php


class GoogleAppScript {

    private $base_url;

    public function __construct($base_url) {
        $this->base_url = $base_url;
    }

    public function sendGetRequest($endpoint, $params) {
        $url = $this->base_url . $endpoint . '?' . http_build_query($params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    public function sendPostRequest($endpoint, $params) {
        $url = $this->base_url . $endpoint;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}