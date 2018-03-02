<?php

namespace BoletoCloud\Api;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Boleto.
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
     *
     * @param array $params
     *
     * @throws \Exception
     */
    public function __construct(array $params = [])
    {
        if (!empty($params['env'])) {
            $this->env = $params['env'];
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
     * Set default options for Guzzle\Client.
     */
    public function buildClient(): void
    {
        $this->baseUrl = (($this->env == 'sandbox') ? self::HOSTNAME_SANDBOX : self::HOSTNAME_PROD);
        $this->httpClient = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'auth'     => [$this->token, 'token'],
        ]);
    }

    /**
     * @param Boleto $boleto
     *
     * @return array|mixed
     */
    public function gerarBoleto(Boleto $boleto)
    {
        try {
            $response = $this->httpClient->post('boletos', [
                'form_params' => $boleto->parser('boleto'),
                'query'       => $boleto->getInstrucao(),
            ]);

            $boletoUrl = str_replace('/api/v1/', '', $this->baseUrl);
            $boletoUrl = $boletoUrl.$response->getHeader('Location')[0];

            return [
                'boleto_url'   => $boletoUrl,
                'boleto_token' => $response->getHeader('X-BoletoCloud-Token')[0],
                'pdf'          => $response->getBody(),
                'request'      => $response,
            ];
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * @param string $token
     *
     * @return array|mixed
     */
    public function resgatarBoleto(string $token)
    {
        try {
            $response = $this->httpClient->get('boletos/'.$token);

            return [
                'pdf'          => $response->getBody(),
                'request'      => $response,
            ];
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * @param Boleto\Conta $conta
     *
     * @return array|mixed
     */
    public function exportarArquivoRemessa(Boleto\Conta $conta)
    {
        try {
            $response = $this->httpClient->post('arquivos/cnab/remessas', [
                'form_params' => $conta->parser('remessa'),
            ]);

            if ($response->getStatusCode() != 201) {
                // Nenhum boleto para remessa ou algum outro erro ocorreu
                return [
                    'arquivo_url'  => null,
                    'arquivo_nome' => null,
                    'arquivo'      => null,
                    'request'      => $response,
                ];
            }

            $arquivoUrl = str_replace('/api/v1/', '', $this->baseUrl);
            $arquivoUrl = $arquivoUrl.$response->getHeader('Location')[0];

            $contentDisposition = $response->getHeader('Content-Disposition');
            if (!empty($contentDisposition[0])) {
                $parts = explode('filename=', $contentDisposition[0]);
                $arquivoNome = (!empty($parts[1])) ? $parts[1] : null;
            } else {
                $arquivoNome = null;
            }

            return [
                'arquivo_url'  => $arquivoUrl,
                'arquivo_nome' => $arquivoNome,
                'arquivo'      => $response->getBody(),
                'token'        => $response->getHeader('X-BoletoCloud-Token')[0],
                'request'      => $response,
            ];
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * @param string $arquivo
     *
     * @return array|mixed
     */
    public function processarArquivoRetorno(string $arquivo)
    {
        try {
            $response = $this->httpClient->post('arquivos/cnab/retornos', [
                'multipart' => [
                    [
                        'name'     => 'arquivo',
                        'contents' => fopen($arquivo, 'r'),
                    ],
                ],
            ]);

            if ($response->getStatusCode() != 201) {
                // Arquivo nao processado ou ja processado anteriormente
                return [
                    'arquivo'      => null,
                    'json'         => null,
                    'request'      => $response,
                ];
            }

            return [
                'arquivo'      => $response->getBody(),
                'json'         => json_decode($response->getBody()->getContents(), true),
                'token'        => $response->getHeader('X-BoletoCloud-Token')[0],
                'request'      => $response,
            ];
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }
}
