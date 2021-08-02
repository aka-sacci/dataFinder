<?php

namespace AkaSacci\PrintDataCnpj;

use Exception;

require_once "../vendor/autoload.php";

class GenerateDocument
{
    private $header = '
    <table width="100%" style="border-bottom: 1px solid #000000; vertical-align: center; font-family: sans-serif; font-size: 9pt; color: #000088;"><tr>
    <td width="33%"><img src="assets/brasao.png" width="100px"/></td>        
    <td width="33%" align="center" style="vertical-align: top;"><h1>REPÚBLICA FEDERATIVA DO BRASIL</h1><br/><br/>
    <h2 style="color: black">CADASTRO NACIONAL DA PESSOA JURÍDICA</h2>
    </td>
    </tr></table>';

    public function generateFromCNPJ(array $info): void
    {

        try {
            $this->checkStatus($info);
        } catch (Exception $e) {
            $this->writeErrorData($e->getMessage());
            die();
        }

        $this->writeData($info);
    }

    private function checkStatus(array $info): void
    {
        $status = $info['status'];
        if ($status == "ERROR") {
            throw new Exception($info['message']);
        }
    }

    private function writeData(array $info): void
    {
        $fantasia = "********";
        $complemento = "********";
        $email = "********";
        $telefone = "********";
        $efr = "********";
        $motivo_situacao = "********";
        $situacao_especial = "********";
        $data_situacao_especial = "********";
        if (!$info['fantasia'] == "") {
            $fantasia = $info['fantasia'];
        }
        if (!$info['complemento'] == "") {
            $complemento = $info['complemento'];
        }
        if (!$info['email'] == "") {
            $email = $info['email'];
        }
        if (!$info['telefone'] == "") {
            $telefone = $info['telefone'];
        }
        if (!$info['efr'] == "") {
            $efr = $info['efr'];
        }
        if (!$info['motivo_situacao'] == "") {
            $motivo_situacao = $info['motivo_situacao'];
        }
        if (!$info['situacao_especial'] == "") {
            $situacao_especial = $info['situacao_especial'];
        }
        if (!$info['data_situacao_especial'] == "") {
            $data_situacao_especial = $info['data_situacao_especial'];
        }

        $atividade = $info['atividade_principal'];
        $secundarias = $info['atividades_secundarias'];
        $end = array(
            'logradouro' => $info['logradouro'],
            'numero' => $info['numero'],
            'cep' => $info['cep'],
            'bairro' => $info['bairro'],
            'municipio' => $info['municipio'],
            'uf' => $info['uf'],
        );

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'c',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 33,
            'margin_bottom' => 10,
            'margin_header' => 3,
        ]);

        $l1 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="25%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666">NÚMERO DE INSCRIÇÃO</p>
        <p>' . $info['cnpj'] . '</p>
        <p>' . $info['tipo'] . '</p>
        </td>
        <td align="center">COMPROVANTE DE INSCRIÇÃO E DE SITUAÇÃO CADASTRAL</td>
        <td width="25%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">DATA DE ABERTURA</p>
        <p>' . $info['abertura'] . '</p>
        </td>
        </tr>
        </tbody>
        </table>';

        $l2 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="100%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">NOME EMPRESARIAL</p>
        <p>' . $info['nome'] . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l3 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="80%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        TÍTULO DO ESTABELECIMENTO (NOME DE FANTASIA)</p>
        <p>' . $fantasia . ' </p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="18%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">PORTE</p>
        <p>' . $info['porte'] . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l4 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="100%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        CÓDIGO E DESCRIÇÃO DA ATIVIDADE ECONÔMICA PRINCIPAL</p>
        <p>' . $atividade[0]->code . ' - ' . $atividade[0]->text . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l5 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="100%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        CÓDIGO E DESCRIÇÃO DAS ATIVIDADES ECONÔMICAS SECUNDÁRIAS</p>
        ' . $this->writeSecundaryActivities($secundarias) . '
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l6 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="100%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        CÓDIGO E DESCRIÇÃO DA NATUREZA JURÍDICA</p>
        ' .  $info['natureza_juridica'] . '
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l7 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="54%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        LOGRADOURO</p>
        <p>' . $end['logradouro'] . ' </p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="10%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">NÚMERO</p>
        <p>' . $end['numero'] . '</p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="32%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">COMPLEMENTO</p>
        <p>' . $complemento . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l8 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="26%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        CEP</p>
        <p>' . $end['cep'] . ' </p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="26%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        BAIRRO/DISTRITO</p>
        <p>' . $end['bairro'] . ' </p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="33%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">MUNICÍPIO</p>
        <p>' . $end['municipio'] . '</p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="6%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">MUNICÍPIO</p>
        <p>' . $end['uf'] . '</p>
        </td>
        </tr>
        </tbody>
        </table>';

        $l9 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="54%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        ENDEREÇO ELETRÔNICO</p>
        <p>' . $email . ' </p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="44%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">TELEFONE</p>
        <p>' . $telefone . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l10 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="100%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">ENTE FEDERATIVO RESPONSÁVEL (EFR)</p>
        <p>' . $efr . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l11 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="70%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        SITUAÇÃO CADASTRAL</p>
        <p>' . $info['situacao'] . ' </p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="28%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">DATA DA SITUAÇÃO CADASTRAL</p>
        <p>' . $info['data_situacao'] . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l12 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="100%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">MOTIVO DE SITUAÇÃO CADASTRAL</p>
        <p>' . $motivo_situacao . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $l13 = '
        <table width="100%" border="1" style="border-collapse: collapse; margin-bottom: 10px;">
        <tbody>
        <tr>
        <td width="70%">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666;">
        SITUAÇÃO ESPECIAL</p>
        <p>' . $situacao_especial . ' </p>
        </td>
        <td width="2%" style="border: 0px;"></td>
        <td width="28%" style="vertical-align: center">
        <p style="font-size: 9px; line-height: 0; font-weight: bold; color:#666666 ">DATA DA SITUAÇÃO ESPECIAL</p>
        <p>' . $data_situacao_especial . '</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        $mpdf->SetHTMLHeader($this->header);
        $mpdf->WriteHTML($l1);
        $mpdf->WriteHTML($l2);
        $mpdf->WriteHTML($l3);
        $mpdf->WriteHTML($l4);
        $mpdf->WriteHTML($l5);
        $mpdf->WriteHTML($l6);
        $mpdf->WriteHTML($l7);
        $mpdf->WriteHTML($l8);
        $mpdf->WriteHTML($l9);
        $mpdf->WriteHTML($l10);
        $mpdf->WriteHTML($l11);
        $mpdf->WriteHTML($l12);
        $mpdf->WriteHTML($l13);
        $mpdf->Output();
    }

    private function writeErrorData(string $message): void
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'c',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 35,
            'margin_bottom' => 10,
            'margin_header' => 3,
        ]);
        $mpdf->SetHTMLHeader($this->header);
        $mpdf->WriteHTML('<p>Erro: Não foi possível recuperar os dados referentes ao CNPJ cadastrado!</p>');
        $mpdf->WriteHTML('<p>Motivo: ' . $message . '</p>');
        $mpdf->Output();
    }

    private function writeSecundaryActivities(array $secundarias): string
    {

        $secundaryActivities = "";
        foreach ($secundarias as $key => $registro) {
            $id = $key;
            $secundaryActivities .= '<p style="margin-bottom: -15px;">' . $secundarias[$id]->code . ' - ' . $secundarias[$id]->text . '</p>';
        }
        return $secundaryActivities;
    }
}
