<?php

namespace AppBundle\Service;

/**
 *
 * @package Fiv\Redmine
 */

class Client extends \Redmine\Client {
    /**
     * @var int
     */
    protected $port;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $httpAuthString = "";
    /**
     * @var int|null Redmine response code, null if request is not still completed
     */
    protected $responseCode = null;
    public function __construct($url, $apiKey, $httpAuthString = "") {
        $this->url = $url;
        $this->apiKey = $apiKey;
        $this->httpAuthString = $httpAuthString;
        $this->setPort(80);
    }
    /**
     * HTTP GETs a json $path and tries to decode it
     * @param  string $path
     * @return array
     */
    public function get($path) {
        if (false === $json = $this->runRequest($path, 'GET')) {
            return false;
        }
        return $this->decode($json);
    }
    /**
     * HTTP POSTs $params to $path
     * @param  string $path
     * @param  string $data
     * @return mixed
     */
    public function post($path, $data) {
        return $this->runRequest($path, 'POST', $data);
    }
    /**
     * HTTP PUTs $params to $path
     * @param  string $path
     * @param  string $data
     * @return array
     */
    public function put($path, $data) {
        return $this->runRequest($path, 'PUT', $data);
    }
    /**
     * HTTP PUTs $params to $path
     * @param  string $path
     * @return array
     */
    public function delete($path) {
        return $this->runRequest($path, 'DELETE');
    }
    /**
     * @param  string $path
     * @param  string $method
     * @param  string $data
     * @return false|\Redmine\Api\SimpleXMLElement|string
     * @throws \Exception If anything goes wrong on curl request
     */
    protected function runRequest($path, $method = 'GET', $data = '') {
        $this->responseCode = null;
        $curl = curl_init();
        if (!empty($this->httpAuthString)) {
            curl_setopt($curl, CURLOPT_USERPWD, $this->httpAuthString);
        }
        $requestUrl = $this->url . $path;
        if (strpos($requestUrl, '?') === false) {
            $requestUrl .= '?';
        }
        $requestUrl .= '&key=' . $this->apiKey;
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_PORT, $this->getPort());
        $urlInfo = parse_url($this->url . $path);
        $httpHeader = array();
        if ('xml' === substr($urlInfo['path'], -3)) {
            $httpHeader[] = 'Content-Type: text/xml';
        }
        if ('/uploads.json' === $path || '/uploads.xml' === $path) {
            $httpHeader[] = 'Content-Type: application/octet-stream';
        } elseif ('json' === substr($urlInfo['path'], -4)) {
            $httpHeader[] = 'Content-Type: application/json';
        }
        // Redmine specific headers
        if ($this->impersonateUser) {
            $httpHeader[] = 'X-Redmine-Switch-User: ' . $this->impersonateUser;
        }
        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);
                if (isset($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                if (isset($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            default: // GET
                break;
        }
        $response = curl_exec($curl);
        $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        if (curl_errno($curl)) {
            $e = new \Exception(curl_error($curl), curl_errno($curl));
            curl_close($curl);
            throw $e;
        }
        curl_close($curl);
        if ($response) {
            // if response is XML, return an SimpleXMLElement object
            if (strpos($contentType, 'application/xml') === 0) {
                return new \Redmine\Api\SimpleXMLElement($response);
            }
            return $response;
        }
        return true;
    }
}