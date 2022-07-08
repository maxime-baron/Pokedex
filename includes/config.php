<?php
// See all errors
error_reporting(E_ALL);
ini_set('display_errors', true);

function apiCall($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($curl, CURLOPT_CAINFO, $_SERVER['DOCUMENT_ROOT'] .  "/../ssl/cacert-2022-04-26.pem");

    $result = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($result);
    return $result;
}
