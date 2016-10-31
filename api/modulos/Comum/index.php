<?php

	require_once( "BairroDAO.php");
	require_once( "EnderecoDAO.php");
	require_once("PessoaDAO.php");
	require_once( "JornaleiroDAO.php");
	require_once("PontoVendaDAO.php");
	require_once("NotaVendaDAO.php");
	require_once("JornalDAO.php");
	require_once("PrecoCapaDAO.php");
	require_once("ItemNotaDAO.php");


	 $pdo = new PDO('mysql:host=localhost;dbname=a_outra', "root", '');



	 $cidadeDAO = new CidadeDAO( $pdo);
	 $bairroDAO = new BairroDAO( $cidadeDAO , $pdo);
	 $enderecoDAO = new EnderecoDAO( $pdo,$bairroDAO);

	 
	 //$cidade = new Cidade("Ouro Preto","MG");
	 
	 //$cidadeDAO->adicionar($cidade);
	 //$cidadeDAO->alterar($cidade);
	 //$cidade = $cidadeDAO->comId(3);
	 //$cidadeDAO->remover($cidade);
	// $cidade = $cidadeDAO->listar();
	//var_dump($cidade);
	
	 //$bairro = new Bairro( "Ponte da Saudade",$cidade,4);
	 //$bairro = new Bairro( "Olaria",$cidade);
	 
	 //$bairroDAO->remover($bairro);
	 //$bairroDAO->adicionar( $bairro);
	 //$bairroDAO->alterar($bairro);
	 //$bairro = $bairroDAO->comId(4);
	 //$bairro = $bairroDAO->listar();
	 //var_dump($bairro);
	 
	 //$endereco = null;
	 //$endereco = new Endereco( "Hands of Fate", 50,"Memory seems to fate", $bairro,5);
	 //$endereco = new Endereco( "Avenida do Vale Campos",58," ",$bairro);
	 //$enderecoDAO->adicionar( $endereco);
	 //$enderecoDAO->alterar( $endereco);
	 //$enderecoDAO->remover( $endereco);
	 $endereco = $enderecoDAO->comId(3);
	 //$endereco = $enderecoDAO->listar();
	 //var_dump($endereco);
	 
	 $pessoaDAO = new PessoaDAO( $pdo );

	 //$pessoa = new PessoaFisica();
	// $pessoa = new PessoaJuridica();
	 //$pessoa->setNome("Giulliano Guimaraes Amendola");
	 //$pessoa->setEmail("giullianoamendola@gmail.com");
	 //$pessoa->setTelefone(25290175);
	 //$pessoa->setRg( 2452453266);
	 //$pessoa->setCpf( 14412452252);
	 //$pessoa->setId(4);
	 //$pessoa->setCnpj( 252652486);
	 //$pessoa->setNomeContato( "Giu");
	 //$pessoaDAO->adicionar( $pessoa );
	 //$pessoaDAO->remover( $pessoa );
	// $pessoa = $pessoaDAO->comId(6);
	 //$pessoa = $pessoaDAO->listar();
	//var_dump( $pessoa );


	$jornaleiroDAO = new JornaleiroDAO( $pdo, $pessoaDAO);

	//$jornaleiro = new Jornaleiro( 2, $pessoa);

	//$jornaleiroDAO->adicionar($jornaleiro);
	//$jornaleiroDAO->alterar( $jornaleiro); COM PROBLEMAS
	//$jornaleiroDAO->remover($jornaleiro);
	$jornaleiro = $jornaleiroDAO->comId(1);
	//$jornaleiro = $jornaleiroDAO->listar();


	//var_dump($jornaleiro);

	$pontoVendaDAO = new PontoVendaDAO( $pdo , $jornaleiroDAO, $enderecoDAO );
	
	$pontoVenda  = new PontoVenda( "Maome", $jornaleiro, $endereco, 3 );
	//$pontoVendaDAO->adicionar( $pontoVenda );
	//$pontoVenda = $pontoVendaDAO->comId(1);
	//$pontoVendaDAO->remover($pontoVenda);
	$pontoVendaDAO->alterar( $pontoVenda ); 
	//$pontoVenda = $pontoVendaDAO->listar();

	var_dump( $pontoVenda );

	$notaVendaDAO = new NotaVendaDAO( $pdo , $pontoVendaDAO) ;
	//FORMATAR AS DATAS
	//USAR STRINGS SO PARA TESTAR A PERSISTENCIA 
	$notaVenda = new NotaVenda( "29/06/2016" , "29/07/2016" , 30.75 , $pontoVenda,1 );

	//$notaVendaDAO->adicionar( $notaVenda );
	//$notaVendaDAO->alterar( $notaVenda );
	//$notaVendaDAO->remover($notaVenda);
	//$notaVenda = $notaVendaDAO->comId(3);
	//$notaVenda = $notaVendaDAO->listar();
	//var_dump($notaVenda);

	$jornalDAO = new JornalDAO( $pdo );

	//$jornal = new Jornal( "Folha de Sao Paulo",2);
	//$jornalDAO->adicionar( $jornal );
	//$jornalDAO->remover( $jornal );
	//$jornalDAO->alterar( $jornal );
	//$jornal = $jornalDAO->listar();
	//$jornal = $jornalDAO->comId( 3 );


	//var_dump($jornal);

	$itemNotaDAO = new ItemNotaDAO( $pdo , $jornalDAO, $notaVendaDAO  );

	//$itemNota = new ItemNota( 6 , 5  , $notaVenda , $jornal );

	//$itemNota = $itemNotaDAO->listar();

	//var_dump($itemNota);


	 





?>