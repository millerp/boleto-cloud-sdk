<?php

namespace BoletoCloud\Api\Boleto;

/**
 * Class Conta.
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
     * @var string
     */
    private $token;

    /**
     * @return string
     */
    public function getBanco(): string
    {
        return $this->banco;
    }

    /**
     * @param string $banco
     *
     * @return Conta
     */
    public function setBanco(string $banco): self
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
     *
     * @return Conta
     */
    public function setAgencia(string $agencia): self
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
     *
     * @return Conta
     */
    public function setNumero(string $numero): self
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
     *
     * @return Conta
     */
    public function setCarteira(int $carteira): self
    {
        $this->carteira = $carteira;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return Conta
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $raiz
     *
     * @return array
     */
    public function parser(string $raiz): array
    {
        return ($this->token != null) ?
            [$raiz.'.conta.token' => $this->token] :
            [
                $raiz.'.conta.banco'    => $this->banco,
                $raiz.'.conta.agencia'  => $this->agencia,
                $raiz.'.conta.numero'   => $this->numero,
                $raiz.'.conta.carteira' => $this->carteira,
            ];
    }
}
