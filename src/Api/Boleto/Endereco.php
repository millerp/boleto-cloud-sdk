<?php

namespace BoletoCloud\Api\Boleto;

/**
 * Class Endereco.
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
     *
     * @return Endereco
     */
    public function setCep(string $cep): self
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
     *
     * @return Endereco
     */
    public function setUf(string $uf): self
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
     *
     * @return Endereco
     */
    public function setLocalidade(string $localidade): self
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
     *
     * @return Endereco
     */
    public function setBairro(string $bairro): self
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
     *
     * @return Endereco
     */
    public function setLogradouro(string $logradouro): self
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
     *
     * @return Endereco
     */
    public function setNumero(string $numero): self
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
     *
     * @return Endereco
     */
    public function setComplemento(string $complemento): self
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * @param string $raiz
     *
     * @return array
     */
    public function parser(string $raiz): array
    {
        return [
            $raiz.'.'.$this->tipo.'.endereco.cep'         => $this->cep,
            $raiz.'.'.$this->tipo.'.endereco.uf'          => $this->uf,
            $raiz.'.'.$this->tipo.'.endereco.localidade'  => $this->localidade,
            $raiz.'.'.$this->tipo.'.endereco.bairro'      => $this->bairro,
            $raiz.'.'.$this->tipo.'.endereco.logradouro'  => $this->logradouro,
            $raiz.'.'.$this->tipo.'.endereco.numero'      => $this->numero,
            $raiz.'.'.$this->tipo.'.endereco.complemento' => $this->complemento,
        ];
    }
}
