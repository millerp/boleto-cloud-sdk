<?php

namespace BoletoCloud\Api;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Boleto
 * @package BoletoCloud\Api
 */
class Client
{

    private const HOSTNAME_PROD = 'https://app.boletocloud.com/api/v1/';

    private const HOSTNAME_SANDBOX = 'https://sandbox.boletocloud.com/api/v1/';

    /**
     * @var string
     */
    private $env = 'sandbox';

    /**
     * @var string
     */
    private $token;

    /**
     * @var GuzzleClient
     */
    private $httpClient;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * Boleto constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        if (!empty($params['env'])) {
            $this->token = $params['env'];
        }
        if (!empty($params['token'])) {
            $this->token = $params['token'];
        } elseif (!empty(getenv('BOLETO_CLOUD_TOKEN'))) {
            $this->token = getenv('BOLETO_CLOUD_TOKEN');
        } else {
            throw new \Exception('Token n&atilde;o informado.');
        }

        $this->buildClient();
    }

    /**
     * Set default options for Guzzle\Client
     */
    public function buildClient(): void
    {
        $this->baseUrl = (($this->env == 'sandbox') ? self::HOSTNAME_SANDBOX : self::HOSTNAME_PROD);
        $this->httpClient = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'auth'     => [$this->token, 'token'],
        ]);
    }

    public function gerarBoleto(Boleto $boleto)
    {
        try {
            $response = $this->httpClient->post('boletos', [
                'form_params' => $boleto->parser(),
                'query'       => $boleto->getInstrucao(),
                'proxy'       => [
                    'http'  => 'http://192.168.111.70:3128', // Use this proxy with "http"
                    'https' => 'http://192.168.111.70:3128', // Use this proxy with "https",
                ],
            ]);

            $boletoUrl = str_replace('/api/v1/', '', $this->baseUrl);
            $boletoUrl = $boletoUrl . $response->getHeader('Location')[0];

            return [
                'boleto_url'   => $boletoUrl,
                'boleto_token' => $response->getHeader('X-BoletoCloud-Token')[0],
                'pdf'          => $response->getBody(),
                'request'      => $response,
            ];

        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

}