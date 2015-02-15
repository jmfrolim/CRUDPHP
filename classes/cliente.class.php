<?php
    include_once 'classes/base.class.php';
	
	class cliente extends base {
		
		public function __construct($campos = array())
		{
			parent :: __construct();
			$this->tabela = "cliente";
			if(sizeof($campos)<= 0):
				$this->campo_valores = array(
				"nome" => NULL,
				"sobrenome"	=>NULL			
				);
			else:
				$this->campo_valores = $campos;
			endif;
			$this->campopk= "id";
		}
	}
?>