<?php
    
    include_once 'banco.class.php';
	abstract class base extends banco{
		public $tabela = "";
		public $campo_valores = array();
		public $campopk = NULL;
		public $valorpk = NULL;
		public $extra_select = "";
		
		public function Addcampo($campo= NULL,$valor = NULL)
		{
			if($campo != NULL):
				$this->campo_valores[$campo] = $valor;
			endif;
		}
		public function Dellcampo($campo=NULL)
		{
			if(array_key_exists($campo, $this->campo_valores)):
				unset($this->campo_valores[$campo]);
			endif;
		}
		
		public function setValor ($campo =NULL, $valor =NULL)
		{
			if($campo != NULL && $valor != NULL):
				$this->campo_valores[$campo] = $valor;
			endif;
		}
		
		public function getValor ($campo)
		{
			if($campo != NULL && array_key_exists($campo,$this->campo_valores)):
				return  $this->campo_valores[$campo];
			else :
				return FALSE;
			endif;
			
		}
	}
?>