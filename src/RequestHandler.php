<?php

namespace linkprofit\AmoCRM;

use Exception;

/**
 * Class RequestHandler
 * @package linkprofit\AmoCRM
 */
class RequestHandler
{
    /**
     * @var mixed
     */
    protected $response;

    /**
     * @var integer
     */
    protected $httpCode;

    /**
     * @var array
     */
    protected $httpErrors = [
        301 => 'Moved permanently',
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable'
    ];

    /**
     * @var array
     */
    protected $successHttpCodes = [
        200, 204
    ];

    /**
     * @var string
     */
    protected $subdomain;

    /**
     * @param string $link
     * @param array $fields
     * @param string $contentType
     * @param string $requestType
     */
    public function performRequest($link, array $fields, $contentType = 'application/json', $requestType = 'POST')
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $requestType);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getStringFields($fields, $contentType));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: ' . $contentType]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->getCookiePath());
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->getCookiePath());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $this->response = curl_exec($curl);
        $this->httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
    }

    /**
     * @return bool
     */
    public function getResponse()
    {
        if (!$this->response) {
            return false;
        }

        $this->encodeResponse();

        return $this->response;
    }

    /**
     * @param $subdomain string
     */
    public function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;
    }

    /**
     * @return string
     */
    public function getSubdomain()
    {
        return $this->subdomain;
    }

    /**
     * Encoding response from json, throw exception in case of wrong http code
     */
    protected function encodeResponse()
    {
        try {
            if (!in_array($this->httpCode, $this->successHttpCodes)) {
                throw new Exception(isset($this->httpErrors[$this->httpCode]) ? $this->httpErrors[$this->httpCode] : 'Undescribed error', $this->httpCode);
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL . 'Error code: ' . $e->getCode();
        }

        $this->response = json_decode($this->response, true);
    }

    /**
     * @return string
     */
    protected function getCookiePath()
    {
        return dirname(dirname(__FILE__)) . '/cookie.txt';
    }

    /**
     * @param array $fields
     * @param       $contentType
     *
     * @return string
     */
    private function getStringFields(array $fields, $contentType)
    {
        if ($contentType === 'application/json') {
            return json_encode($fields);
        }

        return http_build_query($fields);
    }
}