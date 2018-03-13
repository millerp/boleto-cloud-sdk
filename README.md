# Boleto Cloud PHP SDK - [![Code Climate](https://codeclimate.com/github/millerp/boleto-cloud-sdk/badges/gpa.svg)](https://codeclimate.com/github/millerp/boleto-cloud-sdk) [![StyleCI]( https://styleci.io/repos/80548999/shield?style=flat&branch=master)](https://styleci.io/repos/80548999)
SDK de integraçao com a API Boleto Cloud

- Boleto Cloud - https://boletocloud.com/
- Documentação da API - https://boletocloud.com/app/dev/api

### Instalação
`composer require millerp/boleto-cloud`

### Exemplo
```php
<?php

use BoletoCloud\Api\Boleto;
use BoletoCloud\Api\Boleto\Beneficiario;
use BoletoCloud\Api\Boleto\Conta;
use BoletoCloud\Api\Boleto\Pagador;
use BoletoCloud\Api\Client;

require_once __DIR__."/vendor/autoload.php";

$client = new Client([
    'env'   => 'sandbox',
    'token' => 'api_key',
]);

$conta = new Conta();
$conta->setBanco("237")
    ->setAgencia("1234-5")
    ->setNumero("123456-0")
    ->setCarteira(12);

$beneficiarioEndereco = new Boleto\Endereco("beneficiario");
$beneficiarioEndereco->setCep("59020-000")
    ->setLogradouro("Avenida Hermes da Fonseca")
    ->setNumero("384")
    ->setBairro("Petrópolis")
    ->setLocalidade("Natal")
    ->setUf("RN")
    ->setComplemento("Sala 2A, segundo andar");

$beneficiario = new Beneficiario();
$beneficiario->setNome("DevAware Solutions")
    ->setCprf("15.719.277/0001-46")
    ->setEndereco($beneficiarioEndereco);

$pagadorEndereco = new Boleto\Endereco("pagador");
$pagadorEndereco->setCep("36240-000")
    ->setLogradouro("BR-499")
    ->setNumero("s/n")
    ->setBairro("Casa Natal")
    ->setLocalidade("Santos Dumont")
    ->setUf("MG")
    ->setComplemento("Sítio - Subindo a serra da Mantiqueira");

$pagador = new Pagador();
$pagador->setNome("Alberto Santos Dumont")
    ->setCprf("111.111.111-11")
    ->setEndereco($pagadorEndereco);

$boleto = new Boleto();
$boleto->setConta($conta)
    ->setBeneficiario($beneficiario)
    ->setPagador($pagador)
    ->setEmissao(new \DateTime('2017-01-31'))
    ->setVencimento(new \DateTime('2017-02-05'))
    ->setDocumento('EX1')
    ->setNumero(rand(10000000000, 99999999999) . '-P')
    ->setTitulo('DM')
    ->setValor(121.53)
    ->setInstrucao([
        'Atenção! NÃO RECEBER ESTE BOLETO.' . date('d-m-y H:i:s'),
        'Este é apenas um teste utilizando a API Boleto Cloud' . date('d-m-y H:i:s'),
        'Mais info em http://www.boletocloud.com/app/dev/api' . date('d-m-y H:i:s'),
    ]);

$retorno = $client->gerarBoleto($boleto);
```
