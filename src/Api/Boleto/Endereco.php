<?php

namespace BoletoCloud\Api\Boleto;

/**
 * Class Endereco
 * @package BoletoCloud\Api\Boleto
 */
class Endereco implements ParserInteface
{
    /**
     * @var string
     */
    private $cep;

    /**
     * @var string
     */
    private $uf;

    /**
     * @var string
     */
    private $localidade;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var string
     */
    private $logradouro;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $complemento;

    /**
     * @var string
     */
    private $tipo;

    public function __construct(string $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getCep(): string
    {
        return $this->cep;
    }

    /**
     * @param string $cep
     * @return Endereco
     */
    public function setCep(string $cep): Endereco
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * @return string
     */
    public function getUf(): string
    {
        return $this->uf;
    }

    /**
     * @param string $uf
     * @return Endereco
     */
    public function setUf(string $uf): Endereco
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocalidade(): string
    {
        return $this->localidade;
    }

    /**
     * @param string $localidade
     * @return Endereco
     */
    public function setLocalidade(string $localidade): Endereco
    {
        $this->localidade = $localidade;

        return $this;
    }

    /**
     * @return string
     */
    public function getBairro(): string
    {
        return $this->bairro;
    }

    /**
     * @param string $bairro
     * @return Endereco
     */
    public function setBairro(string $bairro): Endereco
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogradouro(): string
    {
        return $this->logradouro;
    }

    /**
     * @param string $logradouro
     * @return Endereco
     */
    public function setLogradouro(string $logradouro): Endereco
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumero(): string
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     * @return Endereco
     */
    public function setNumero(string $numero): Endereco
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string
     */
    public function getComplemento(): string
    {
        return $this->complemento;
    }

    /**
     * @param string $complemento
     * @return Endereco
     */
    public function setComplemento(string $complemento): Endereco
    {
        $this->complemento = $complemento;

        return $this;
    }

    public function parser(): array
    {
        return [
            'boleto.' . $this->tipo . '.endereco.cep'         => $this->cep,
            'boleto.' . $this->tipo . '.endereco.uf'          => $this->uf,
            'boleto.' . $this->tipo . '.endereco.localidade'  => $this->localidade,
            'boleto.' . $this->tipo . '.endereco.bairro'      => $this->bairro,
            'boleto.' . $this->tipo . '.endereco.logradouro'  => $this->logradouro,
            'boleto.' . $this->tipo . '.endereco.numero'      => $this->numero,
            'boleto.' . $this->tipo . '.endereco.complemento' => $this->complemento,
        ];
    }
}