<?php

include('../../banco/conexao.php');

if($conexao){

    $requestData = $_REQUEST;

    $imagem = $_FILES['imagem'];

    if(!empty($requestData['nome']) &&
       !empty($requestData['descricao']) &&
       !empty($requestData['ativo'])
    ){

    }else{
        $dados = array(
            "tipo" => "info",
            "mensagem" => "Existe(m) campo(s) obrigatório(s) vazio(s)."
        );
    }
    
}else{
    $dados = array(
        "tipo" => "info",
        "mensagem" => "Ops... não foi possível conectar ao banco de dados"
    );
}

echo  json_encode ( $dados , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );