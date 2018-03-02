<?php

namespace BoletoCloud\Api\Boleto;

/**
 * Class Beneficiario.
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
     *
     * @return Beneficiario
     */
    public function setNome(string $nome): self
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
     *
     * @return Beneficiario
     */
    public function setCprf(string $cprf): self
    {
        $this->cprf = $cprf;

        return $this;
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
     *
     * @return Beneficiario
     */
    public function setEndereco(Endereco $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * @param string $raiz
     *
     * @return array
     */
    public function parser(string $raiz): array
    {
        return array_merge([
            $raiz.'.beneficiario.nome' => $this->nome,
            $raiz.'.beneficiario.cprf' => $this->cprf,
        ], $this->getEndereco()->parser($raiz));
    }
}
