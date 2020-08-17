<?php

    include('../../banco/conexao.php');

    if($conexao){

        $sql = "SELECT p.idproduto, p.nome, p.descricao, p.estoque, p.estoque_min,
        p.valor, p.ativo, p.idcategoria, c.nome as categoria, p.imagem, p.datacricao,
        p.datamodificacao
        FROM produtos p
        INNER JOIN categorias c ON p,idcategoria = c.idcategoria
        WHERE p.ativo = 'S'";

        } else{
            $dados = array(
                "tipo" => "info",
                "mensagem" => "Não possível localizar a categoria.",
                "dados" => array()
            );
        }
