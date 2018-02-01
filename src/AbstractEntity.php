<?php

namespace linkprofit\AmoCRM;
use Exception;

/**
 * Class AbstractEntity
 * @package linkprofit\AmoCRM
 */
abstract class AbstractEntity
{
    /**
     * @var string
     */
    protected $link;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var
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
     * Perform curl request, save response and http code
     */
    protected function performRequest()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $this->link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->fields));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->getCookiePath());
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->getCookiePath());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $this->response = curl_exec($curl);
        $this->httpCode = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
    }

    /**
     * Encoding response from json, throw exception in case of wrong http code
     */
    protected function encodeResponse()
    {
        try {
            if ($this->httpCode!= 200 && $this->httpCode != 204) {
                throw new Exception(isset($this->httpErrors[$this->httpCode]) ? $this->httpErrors[$this->httpCode] : 'Undescribed error', $this->httpCode);
            }
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage() . PHP_EOL . 'Error code: ' . $e->getCode());
        }

        $this->response = json_decode($this->response, true);
        $this->response = $this->response['response'];
    }

    /**
     * @return string
     */
    protected function getCookiePath()
    {
        return dirname(dirname(__FILE__)) . '/cookie.txt';
    }
}