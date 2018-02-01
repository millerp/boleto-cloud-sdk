<?php

namespace BoletoCloud\Api\Boleto;

/**
 * Class Pagador
 * @package BoletoCloud\Api\Boleto
 */
class Pagador implements ParserInteface
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
     * @return Pagador
     */
    public function setNome(string $nome): Pagador
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
     * @return Pagador
     */
    public function setCprf(string $cprf): Pagador
    {
        $this->cprf = $cprf;

        return $this;
    }

	/**
	 * @param string $raiz
	 * @return array
	 */
    public function parser(string $raiz): array
    {
        return array_merge([
	        $raiz . '.pagador.nome' => $this->nome,
	        $raiz . '.pagador.cprf' => $this->cprf,
        ], $this->getEndereco()->parser($raiz));
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
     * @return Pagador
     */
    public function setEndereco(Endereco $endereco): Pagador
    {
        $this->endereco = $endereco;

        return $this;
    }
}
