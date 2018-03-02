<?php

namespace Tests\BoletoCloud;

use BoletoCloud\Api\Boleto;
use BoletoCloud\Api\Boleto\Beneficiario;
use BoletoCloud\Api\Boleto\Conta;
use BoletoCloud\Api\Boleto\Pagador;
use BoletoCloud\Api\Client;

/**
 * Class BoletoTest.
 */
class BoletoTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new Client([
            'env'   => 'sandbox',
            'token' => 'api-key_toGAZFrBemHRcsFGQt6SqoE4AN6bNXtiS6oMabLyMnA=',
        ]);
    }

    public function testCriarBoletoAcerto()
    {
        $conta = new Conta();
        $conta->setBanco('237')
            ->setAgencia('1234-5')
            ->setNumero('123456-0')
            ->setCarteira(12);

        $beneficiarioEndereco = new Boleto\Endereco('beneficiario');
        $beneficiarioEndereco->setCep('59020-000')
            ->setLogradouro('Avenida Hermes da Fonseca')
            ->setNumero('384')
            ->setBairro('Petrópolis')
            ->setLocalidade('Natal')
            ->setUf('RN')
            ->setComplemento('Sala 2A, segundo andar');

        $beneficiario = new Beneficiario();
        $beneficiario->setNome('DevAware Solutions')
            ->setCprf('15.719.277/0001-46')
            ->setEndereco($beneficiarioEndereco);

        $pagadorEndereco = new Boleto\Endereco('pagador');
        $pagadorEndereco->setCep('36240-000')
            ->setLogradouro('BR-499')
            ->setNumero('s/n')
            ->setBairro('Casa Natal')
            ->setLocalidade('Santos Dumont')
            ->setUf('MG')
            ->setComplemento('Sítio - Subindo a serra da Mantiqueira');

        $pagador = new Pagador();
        $pagador->setNome('Alberto Santos Dumont')
            ->setCprf('111.111.111-11')
            ->setEndereco($pagadorEndereco);

        $boleto = new Boleto();
        $boleto->setConta($conta)
            ->setBeneficiario($beneficiario)
            ->setPagador($pagador)
            ->setEmissao(new \DateTime('2017-01-31'))
            ->setVencimento(new \DateTime())
            ->setDocumento('EX1')
            ->setNumero(rand(11111, 99999).rand(111111, 999999).'-P')
            ->setTitulo('DM')
            ->setValor(121.53)
            ->setInstrucao([
                'Atenção! NÃO RECEBER ESTE BOLETO.'.date('d-m-y H:i:s'),
                'Este é apenas um teste utilizando a API Boleto Cloud'.date('d-m-y H:i:s'),
                'Mais info em http://www.boletocloud.com/app/dev/api'.date('d-m-y H:i:s'),
            ]);

        $retorno = $this->client->gerarBoleto($boleto);
        $this->assertArrayHasKey('boleto_url', $retorno);
        $this->assertEquals(201, $retorno['request']->getStatusCode());
    }

    public function testCriarBoletoInformacaoIncorreta()
    {
        $conta = new Conta();
        $conta->setBanco('237')
            ->setAgencia('1234-5')
            ->setNumero('123456-0')
            ->setCarteira(15165165);

        $beneficiarioEndereco = new Boleto\Endereco('beneficiario');
        $beneficiarioEndereco->setCep('59020-000')
            ->setLogradouro('Avenida Hermes da Fonseca')
            ->setNumero('384')
            ->setBairro('Petrópolis')
            ->setLocalidade('Natal')
            ->setUf('RN')
            ->setComplemento('Sala 2A, segundo andar');

        $beneficiario = new Beneficiario();
        $beneficiario->setNome('DevAware Solutions')
            ->setCprf('15.719.277/0001-46')
            ->setEndereco($beneficiarioEndereco);

        $pagadorEndereco = new Boleto\Endereco('pagador');
        $pagadorEndereco->setCep('36240-000')
            ->setLogradouro('BR-499')
            ->setNumero('s/n')
            ->setBairro('Casa Natal')
            ->setLocalidade('Santos Dumont')
            ->setUf('MG')
            ->setComplemento('Sítio - Subindo a serra da Mantiqueira');

        $pagador = new Pagador();
        $pagador->setNome('Alberto Santos Dumont')
            ->setCprf('111.111.111-11')
            ->setEndereco($pagadorEndereco);

        $boleto = new Boleto();
        $boleto->setConta($conta)
            ->setBeneficiario($beneficiario)
            ->setPagador($pagador)
            ->setEmissao(new \DateTime('2017-01-31'))
            ->setVencimento(new \DateTime('2017-02-05'))
            ->setDocumento('EX1')
            ->setNumero(rand(10000000, 99999999).'-P')
            ->setTitulo('DM')
            ->setValor(121.53)
            ->setInstrucao([
                'Atenção! NÃO RECEBER ESTE BOLETO.'.date('d-m-y H:i:s'),
                'Este é apenas um teste utilizando a API Boleto Cloud'.date('d-m-y H:i:s'),
                'Mais info em http://www.boletocloud.com/app/dev/api'.date('d-m-y H:i:s'),
            ]);

        $retorno = $this->client->gerarBoleto($boleto);
        $this->assertArrayHasKey('erro', $retorno);
    }
}
