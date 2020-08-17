<?php

include('../../banco/conexao.php');

if($conexao){
    $requestData = $_REQUEST;

    $colunas = $requestData['columns'];

    $sql = "SELECT p.idproduto, p.nome, p.ativo,
                   p.idcategoria, c.nome as categoria,
                   DATE_FORMAT(p.datamodificacao, '%d/%m/%Y %H:%i:%s') as datamodificacao,
            FROM produtos p
            INNER JOIN categorias c ON c.idcategoria = p.idcategoria
            WHERE 1=1";

    $resultado = mysqli_query($conexao, $sql);
    $qtddeLinhas = mysqli_num_rows($resultado);

    $filtro = $requestData['search']['value'];
    if(!empty($filtro)){

        $sql .= " AND (p.idproduto LIKE '$filtro%' ";
        $sql .= " OR p.nome LIKE '$filtro%' ";
        $sql .= " OR c.nome LIKE '$filtro' )";
    }

    $resultado = mysqli_query($conexao, $sql);
    $totalFiltrados = mysqli_num_rows($resultado);

    $colunaOrdem = $requestData['order'] [0]['column'];
    $ordem = $colunas[$colunaOrdem]['data'];
    $direcao = $requestData['order'][0]['dir'];

    $sql .="ORDER BY $ordem $direcao LIMIT {$requestData['start']}, 
    {$requestData['length']}";

    $resultado = mysqli_query($conexao, $sql);

    $dados = array();
    while($linha = mysqli_fetch_assoc($resultado)){
        $dados[] = array_map('utf8_encode', $linha);
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($qtdeLinhas),
        "recordsFiltered" => intval($totalFiltrados),
        "data" => $dados
    );

    mysqli_close($conexao);

}else{
    $json_data = array(
       "draw" => 0,
       "recordsTotal" => 0,
       "recordsFiltered" => 0,
       "data" => array()
    );
}

echo json_encode($json_data);