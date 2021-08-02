<?php

require_once "../vendor/autoload.php";
use AkaSacci\GetcnpjPhp\Search;
use AkaSacci\PrintDataCnpj\GenerateDocument;

$mySearch = new Search();
$myDocument = new GenerateDocument();

try {
    $myCNPJ = setCNPJ();
} catch (Exception $e) {
    $arrayError = array(
        'status' => 'ERROR',
        'message' => $e->getMessage(),
        'errorCode' => $e->getCode()
     );
     return $myDocument->generateFromCNPJ($arrayError);
}

$data = $mySearch->getDataFromCNPJ($myCNPJ);
$myDocument->generateFromCNPJ($data);


function setCNPJ(): string
{

    if (!isset($_GET['inputCNPJ']) || $_GET['inputCNPJ'] == null) {
        throw new Exception("Digite um CNPJ!", 102);
    }
    return $_GET['inputCNPJ'];
}
