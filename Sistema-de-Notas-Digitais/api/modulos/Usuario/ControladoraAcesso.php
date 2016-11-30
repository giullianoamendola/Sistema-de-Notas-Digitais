<?php

	class ControladoraAcesso{

		private $perfil ;
		
		function __construct( $perfil ){
			$this->perfil = $perfil ;
		}

		function __invoke( $request, $response, $next ){
			
			$acesso = false;

			if(isset($_SESSION['usuario'])){
				if(  in_array($_SESSION['usuario']['perfil'], $this->perfil) ){
					$acesso = true ;
				}	
					
			}	
			
			$response = $next( $request->withAttribute('acesso',$acesso), $response );
			return $response ;
		}


	}




?>