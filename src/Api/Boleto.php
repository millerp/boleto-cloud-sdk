<?php

namespace BoletoCloud\Api;

use BoletoCloud\Api\Boleto\Beneficiario;
use BoletoCloud\Api\Boleto\Conta;
use BoletoCloud\Api\Boleto\Pagador;
use BoletoCloud\Api\Boleto\ParserInteface;

/**
 * Class Boleto
 * @package BoletoCloud\Api
 */
class Boleto implements ParserInteface
{
    /**
     * @var string
     */
    private $titulo;

    /**
     * @var bool
     */
    private $aceite;

    /**
     * @var string
     */
    private $documento;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var int
     */
    private $sequencial;

    /**
     * @var \DateTime
     */
    private $emissao;

    /**
     * @var \DateTime
     */
    private $vencimento;

    /**
     * @var float
     */
    private $valor;

    /**
     * @var float
     */
    private $juros;

    /**
     * @var float
     */
    private $multa;

    /**
     * @var string
     */
    private $instrucao;

    /**
     * @var Beneficiario
     */
    private $beneficiario;

    /**
     * @var Pagador
     */
    private $pagador;

    /**
     * @var Conta
     */
    private $conta;

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     * @return Boleto
     */
    public function setTitulo(string $titulo): Boleto
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAceite(): bool
    {
        return $this->aceite;
    }

    /**
     * @param bool $aceite
     * @return Boleto
     */
    public function setAceite(bool $aceite): Boleto
    {
        $this->aceite = $aceite;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumento(): string
    {
        return $this->documento;
    }

    /**
     * @param string $documento
     * @return Boleto
     */
    public function setDocumento(string $documento): Boleto
    {
        $this->documento = $documento;

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
     * @return Boleto
     */
    public function setNumero(string $numero): Boleto
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return int
     */
    public function getSequencial(): int
    {
        return $this->sequencial;
    }

    /**
     * @param int $sequencial
     * @return Boleto
     */
    public function setSequencial(int $sequencial): Boleto
    {
        $this->sequencial = $sequencial;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEmissao(): \DateTime
    {
        return $this->emissao;
    }

    /**
     * @param \DateTime $emissao
     * @return Boleto
     */
    public function setEmissao(\DateTime $emissao): Boleto
    {
        $this->emissao = $emissao;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getVencimento(): \DateTime
    {
        return $this->vencimento;
    }

    /**
     * @param \DateTime $vencimento
     * @return Boleto
     */
    public function setVencimento(\DateTime $vencimento): Boleto
    {
        $this->vencimento = $vencimento;

        return $this;
    }

    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     * @return Boleto
     */
    public function setValor(float $valor): Boleto
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * @return float
     */
    public function getJuros(): float
    {
        return $this->juros;
    }

    /**
     * @param float $juros
     * @return Boleto
     */
    public function setJuros(float $juros): Boleto
    {
        $this->juros = $juros;

        return $this;
    }

    /**
     * @return float
     */
    public function getMulta(): float
    {
        return $this->multa;
    }

    /**
     * @param float $multa
     * @return Boleto
     */
    public function setMulta(float $multa): Boleto
    {
        $this->multa = $multa;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstrucao(): string
    {
        return $this->instrucao;
    }

    /**
     * @param array $instrucao
     * @return Boleto
     */
    public function setInstrucao(array $instrucao): Boleto
    {
        foreach ($instrucao as $v) {
            $this->instrucao .= urlencode('boleto.instrucao') . '=' . urlencode($v) . '&';
        }

        return $this;
    }

    /**
     * @return Conta
     */
    public function getConta(): Conta
    {
        return $this->conta;
    }

    /**
     * @param Conta $conta
     * @return Boleto
     */
    public function setConta(Conta $conta): Boleto
    {
        $this->conta = $conta;

        return $this;
    }

    /**
     * @return Beneficiario|null
     */
    public function getBeneficiario(): ?Beneficiario
    {
        return $this->beneficiario;
    }

    /**
     * @param Beneficiario $beneficiario
     * @return Boleto
     */
    public function setBeneficiario(Beneficiario $beneficiario): Boleto
    {
        $this->beneficiario = $beneficiario;

        return $this;
    }

    /**
     * @return Pagador
     */
    public function getPagador(): Pagador
    {
        return $this->pagador;
    }

    /**
     * @param Pagador $pagador
     * @return Boleto
     */
    public function setPagador(Pagador $pagador): Boleto
    {
        $this->pagador = $pagador;

        return $this;
    }

    /**
     * @return array
     */
    public function parser(): array
    {
    	$beneficiario = (!empty($this->beneficiario)) ? $this->getBeneficiario()->parser() : [];
        return array_merge_recursive([
            'boleto.emissao'    => $this->emissao->format('Y-m-d'),
            'boleto.vencimento' => $this->vencimento->format('Y-m-d'),
            'boleto.documento'  => $this->documento,
            'boleto.numero'     => $this->numero,
            'boleto.titulo'     => $this->titulo,
            'boleto.valor'      => $this->valor,
        ], $this->getConta()->parser(), $beneficiario, $this->getPagador()->parser());
    }
}
