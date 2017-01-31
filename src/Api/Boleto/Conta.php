<?php

namespace BoletoCloud\Api\Boleto;

/**
 * Class Conta
 * @package BoletoCloud\Api\Boleto
 */
class Conta implements ParserInteface
{
    /**
     * @var string
     */
    private $banco;

    /**
     * @var string
     */
    private $agencia;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var int
     */
    private $carteira;

    /**
     * @return string
     */
    public function getBanco(): string
    {
        return $this->banco;
    }

    /**
     * @param string $banco
     * @return Conta
     */
    public function setBanco(string $banco): Conta
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * @return string
     */
    public function getAgencia(): string
    {
        return $this->agencia;
    }

    /**
     * @param string $agencia
     * @return Conta
     */
    public function setAgencia(string $agencia): Conta
    {
        $this->agencia = $agencia;

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
     * @return Conta
     */
    public function setNumero(string $numero): Conta
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return int
     */
    public function getCarteira(): int
    {
        return $this->carteira;
    }

    /**
     * @param int $carteira
     * @return Conta
     */
    public function setCarteira(int $carteira): Conta
    {
        $this->carteira = $carteira;

        return $this;
    }

    public function parser(): array
    {
        return [
            'boleto.conta.banco'    => $this->banco,
            'boleto.conta.agencia'  => $this->agencia,
            'boleto.conta.numero'   => $this->numero,
            'boleto.conta.carteira' => $this->carteira,
        ];
    }
}