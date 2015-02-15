<?php 
	
	//declaração da classe e suas propriedades
	abstract class banco {
		public $servidor = "localhost";
		public $usuario = "root";
		public $senha= "";
		public $nomebanco = "crud";
		public $conexao= NULL;
		public $dataset= NULL;
		public $linhasafetadas= -1;
		
		//metodo constutor
		public function __construct(){
			$this->conecta();
			
		}
		//metodo destrutor fecha a conexao com o banco de cada objeto
		public function __destruct(){
			if($this->conexao != null):
				mysql_close($this->conexao);
			endif;
		}
		//metodo concta recebe como parametros as propriedades da classe
		public function conecta(){
			$this->conexao = mysql_connect($this->servidor, $this->usuario,$this->senha, TRUE)or die($this->trataerro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),TRUE));
			mysql_select_db($this->nomebanco)or die($this->trataerro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),TRUE));
			mysql_query ("SET NAMES 'utf8'") ;
			mysql_query("SET character_set_connection=utf8");
			mysql_query("SET character_set_client=utf8");
			mysql_query("SET character_set_result=utf8");
			
		}
		//metodo inserir dados no banco recebendo como parametro um objeto
		public function inserir($objeto)
		{
			$sql = "INSERT INTO ".$objeto->tabela." (";
			for ($i=0; $i <count($objeto->campo_valores); $i++) :
				$sql .= key($objeto->campo_valores);
				if($i<(count($objeto->campo_valores)-1)):
					$sql .= ", ";
				else:
					$sql .=")";
				endif;
				next($objeto->campo_valores);		
			endfor;
				//echo $sql;
			reset($objeto->campo_valores);
			$sql .= "VALUES (";
			for ($i=0; $i < count($objeto->campo_valores); $i++) :
					$sql .= is_numeric($objeto->campo_valores[key($objeto->campo_valores)]) ? $objeto->campo_valores[key($objeto->campo_valores)]:
					"'".$objeto->campo_valores[key($objeto->campo_valores)]."'";
				if($i<(count($objeto->campo_valores)-1)):
					$sql .= ", ";
				else:
					$sql .=")";
				endif;
				next($objeto->campo_valores);
			endfor;
			
			return $this->executaSQL($sql);
			
		}
		//metodo para alterar um registro no banco recebendo como parametro um objeto
		public function alterar($objeto)
		{
			$sql = "UPDATE ".$objeto->tabela." SET ";
			for ($i=0; $i <count($objeto->campo_valores); $i++) :
				$sql .= key($objeto->campo_valores). "=";
				$sql .= is_numeric($objeto->campo_valores[key($objeto->campo_valores)]) ? $objeto->campo_valores[key($objeto->campo_valores)]:
					"'".$objeto->campo_valores[key($objeto->campo_valores)]."'";
				if($i<(count($objeto->campo_valores)-1)):
					$sql .= ", ";
				else:
					$sql .= " ";
				endif;
				next($objeto->campo_valores);		
			endfor;
				//echo $sql;
			$sql .="WHERE ".$objeto->campopk."=";	
			$sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";  
			echo $sql;			
			return $this->executaSQL($sql);
		}
		//metodo para deletar registro no banco recebendo como parametro um objeto
		public function deletar ($objeto){
			$sql = " DELETE FROM ".$objeto->tabela;			
			$sql .=" WHERE ".$objeto->campopk."=";	
			$sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";  
			echo $sql;			
			return $this->executaSQL($sql);
		}
		
		
		public function seleciondaDados($objeto){
			$sql = "SELECT * FROM ".$objeto->tabela;
			if($objeto->extra_select != NULL):
				$sql .= " ".$objeto->extra_select;
			endif;
			
			return $this->executaSQL($sql);
		}
		public function executaSQL($sql = NULL)
		{
			if( $sql != NULL):
				$query = mysql_query($sql) or $this->trataerro(__FILE__,__FUNCTION__);
				$this->linhasafetadas = mysql_affected_rows($this->conexao);
				if(substr(trim(strtolower($sql)),0,6) == 'select'):
						$this->dataset = $query;
						return $query;
				else:
					return $this->linhasafetadas;
				endif;
			else:
				$this->trataerro(__FILE__,__FUNCTION__,NULL,"Comando SQL nao informado",FALSE);
			endif;			
		}
		
		public function retornaDados($tipo = NULL){
			switch (strtolower($tipo)) {
				case 'array':
					return mysql_fetch_array($this->dataset);
					break;
				case 'assoc':
					return mysql_fetch_assoc($this->dataset);
					
				case 'objeto':
					return mysql_fetch_object($this->dataset);
					break;

					break;
				default:
					return mysql_fetch_object($this->dataset);					
					break;
			}
		}
		//Metodo para tratar ERROS
		public function trataerro($arquivo=NULL,$rotina = NULL,$numerro= NULL,$messagemErro =NULL,$geraExecept =FALSE){
			if($arquivo == NULL) $arquivo ="nao informado";
			if ($rotina == NULL) $rotina = "nao informado";
			if ($numerro == NULL)$numerro = mysql_errno($this->conexao);
			if ($messagemErro == NULL) $messagemErro = mysql_error($this->conexao);
			$resultado = 'Ocorreu um erro com so seguintes detalhes:<br/>
						 <strong>Arquivo:</strong>'.$arquivo.'
						 <strong>Rotina:</strong>'.$rotina.'
					     <strong>Codigo:</strong>'.$numerro.'
						 <strong>Mesagem:</strong>'.$messagemErro;
						 
			if($resultado == NULL):
				echo ($resultado);
			else:
				die ($resultado);
			endif;	
		
		}
	}
 ?>