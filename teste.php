<?php 
	
	// arquivo para testar a conexao com o banco de dados
	include_once 'classes/cliente.class.php';
	
	$clientes = new cliente();
	$clientes->setValor('nome','Luiz');
	$clientes->setValor('sobrenome','Cebola');
	$clientes->valorpk = 5;
	//$clientes->setValor('bairro','Joao de Deus');
	//$clientes->setValor('numero','08');
	
	//$clientes->inserir($clientes);
	//$clientes->alterar($clientes);
	//$clientes->deletar($clientes);
	//$clientes->executaSQL();
	$clientes->seleciondaDados($clientes);
	while ($res =$clientes->retornaDados()) :
		echo $res->id. '/' .$res->nome. '/' .$res->sobrenome.'<br/>';
	endwhile;
	
	
	echo'<pre>';
	
		print_r($clientes);
		
	echo'</pre>';
	
	

 ?>
