<?php
class Helper {

    public static function requestPost($url, $data) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if (self::isJson($response)) {
            return json_encode(["status"=>$httpCode, "body"=>json_decode($response)]);
        } else {
            return json_encode(["status"=>$httpCode, "body"=>$response]);
        }
    }

    public static function requestGet($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if (self::isJson($response)) {
            return json_encode(["status"=>$httpCode, "body"=>json_decode($response)]);
        } else {
            return json_encode(["status"=>$httpCode, "body"=>$response]);
        }
    }

    public static function redirect($url) {
        $root = "";
        header('Location: ' . $root . $url, true, 302);
        die();
    }

    public static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
