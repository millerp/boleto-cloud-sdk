<?php

namespace BoletoCloud\Api\Boleto;

/**
 * Class Beneficiario
 * @package BoletoCloud\Api\Boleto
 */
class Beneficiario implements ParserInteface
{
    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $cprf;

    /**
     * @var Endereco
     */
    private $endereco;

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Beneficiario
     */
    public function setNome(string $nome): Beneficiario
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return string
     */
    public function getCprf(): string
    {
        return $this->cprf;
    }

    /**
     * @param string $cprf
     * @return Beneficiario
     */
    public function setCprf(string $cprf): Beneficiario
    {
        $this->cprf = $cprf;

        return $this;
    }

    public function parser(): array
    {
        return array_merge([
            'boleto.beneficiario.nome' => $this->nome,
            'boleto.beneficiario.cprf' => $this->cprf,
        ], $this->getEndereco()->parser());
    }

    /**
     * @return Endereco
     */
    public function getEndereco(): Endereco
    {
        return $this->endereco;
    }

    /**
     * @param Endereco $endereco
     * @return Beneficiario
     */
    public function setEndereco(Endereco $endereco): Beneficiario
    {
        $this->endereco = $endereco;

        return $this;
    }
}