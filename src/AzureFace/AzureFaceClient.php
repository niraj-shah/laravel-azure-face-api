<?php
namespace AzureFace;

use GuzzleHttp\Client as Guzzle;

class AzureFaceClient {

    /**
     * The API endpoint
     *
     * @var string
     */
    protected $endpoint = 'https://uksouth.api.cognitive.microsoft.com/face/v1.0/';

    /**
     * The API Key
     *
     * @var string
     */
    protected $api_key;

    /**
     * The Guzzle HTTP client instance
     *
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * Instantiate a new Client
     *
     * @param array $attributes
     * @return void
     */
    public function __construct($api_key, $endpoint = null, Guzzle $guzzle = null)
    {
        $this->setApiKey($api_key);

        if ($endpoint !== null) {
            $this->setEndpoint($endpoint);
        }

        $this->guzzle = $guzzle ?: new Guzzle;
    }

    /**
     * Get the API endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get the API endpoint
     *
     * @param string $endpoint
     * @return void
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Set the API Key
     *
     * @param string $api_key
     * @return void
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Get the API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * Make a API request
     *
     * @param $url The endoint to call
     * @param $method The type of call, e.g. POST
     * @param $payload Optional parameters to send in the request
     * @return array
     */
    public function request($url, $method = 'GET', $form = [], $params = [])
    {
        // add headers
        $payload['headers'] = [
            'Accept'  => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->getApiKey(),
          ];

        $payload['http_errors'] = false;

        $payload['json'] = $form;

        $endpoint = $this->endpoint . $url;
        if (count($params) > 0) {
            $endpoint .= '?' . http_build_query($params);
        }

        // make the request
        $response = $this->guzzle->request($method, $endpoint, $payload);

        if ($response->getStatusCode() == '200' || $response->getStatusCode() == '201') {
            $content = $response->getBody()->getContents();
            if (empty($content)) {
                return true;
            }
            return json_decode($content);
        } else if ($response->getStatusCode() == '404') {
            throw new \Exception('Client Error: 404 Not Found', 404);
        } else {
            $content = $response->getBody()->getContents();
            $errors = json_decode($content);

            if ($errors !== null && isset($errors->error)) {
                throw new \Exception('Client Error: ' . (isset($errors->error->message) ? $errors->error->message : $content), $response->getStatusCode());
            } else {
                throw new \Exception('Client Error: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase(), $response->getStatusCode());
            }
        }
    }

    /**
     * Make a GET API request
     *
     * @param $url The endoint to call
     * @param $payload Optional parameters to send in the request
     * @return array
     */
    public function detect($payload = [], $params = [])
    {
        return $this->request('detect', 'POST', $payload, $params);
    }

}
