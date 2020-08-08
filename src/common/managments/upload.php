<?php

namespace account\common\managments;

class upload
{
	const TYPES_IMG = 'img';
	const TYPES_ALL = 'all';
	const TYPES_TXT = 'txt';

	public $pasta          = '';
	public $tamanho        = 10485760;
	public $tipo           = 'all';
	public $nomeSequencial = true;
	public $Salvos         = array();
	public $Erros          = array();
	public $nomeArquivo   = '';

	private function autoName($type = null, $indice = null)
	{
		if(isset($type) && strlen($type) > 0)
			return time().'_'.$indice.'.'.$type;
		return NULL;
	}

	public function salveFILES($pasta)
	{
		// zera arrays
		$this->Salvos = array();
		$this->Erros  = array();

		$this->setPasta($pasta);
		if(empty($this->getPasta())){
			return false;
		}

		//SE ARRAY $_FILES VAZIO Nï¿½O Hï¿½ ARQUIVOS A SEREM SALVOS
		if(!isset($_FILES) || empty($_FILES)){
			$this->Erros[$input] = "Não existem arquivos para upload.";
			return false;
		}

		$indice = 1;
		foreach($_FILES as $input => $arquivo){
			if($arquivo['size'] >= $this->tamanho){
				$this->Erros[$input] = "Erro no tamanho máximo do arquivo.";
				continue;
			}

			// existe extensÃ£o
			$tp = substr($arquivo['name'], strrpos($arquivo['name'],'.')+1,strlen($arquivo['name']));
			if(!isset($tp) || empty($tp)){
				$this->Erros[$input] = "Não existe extensão.";
				continue;
			}

			//TIPO VálIDO
			if(!$this->tipoValido($tp)){
				$this->Erros[$input] = "Erro no tipo válido para o arquivo";
				continue;
			}

			// define nome do arquivo
			$fileName = $this->autoName( $tp, $indice);
			if(!isset($fileName) || empty($fileName)){
				$arquivo['input'] = $input;
				$this->Erros[]    = $arquivo;
				continue;
			}

			//MOVER ARQUIVO
			if(!move_uploaded_file($arquivo['tmp_name'],  $this->pasta.$fileName)){
				$arquivo['input'] = $input;
				$this->Erros[]    = $arquivo;
				continue;
			}

			//NOTIFICAR SALVAMENTO CORRETO
			$arquivo['input']    = $input;
			$arquivo['saveName'] = $fileName;
			$this->Salvos[] = $arquivo;
			$indice++;
		}

		return $this;
	}

	private function tipoValido($extArquivo)
	{
		if(!isset($extArquivo) || empty($extArquivo)){
			return false;
		}

		$defType = $this->defineType($extArquivo);

		if($this->tipo == 'all'){
			return true;
		}

		if($this->tipo == $defType){
			return true;
		}

		return false;
	}

	public function setType($type)
	{
		// inicia tipo
		$this->tipo = $this->defineType($type);
	}

	private function defineType($type)
	{
		// inicia tipo
		$tipos = null;
		switch($type){

			case "jpg": $tipos  = self::TYPES_IMG; break;
			case "jpeg": $tipos = self::TYPES_IMG; break;
			case "gif": $tipos  = self::TYPES_IMG; break;
			case "bmp": $tipos  = self::TYPES_IMG; break;
			case "png": $tipos  = self::TYPES_IMG; break;
			case "wmf": $tipos  = self::TYPES_IMG; break;
			case "txt": $tipos  = self::TYPES_TXT; break;
			case "cmv": $tipos  = self::TYPES_TXT; break;
			case "all": $tipos  = self::TYPES_ALL; break;
			default: $tipos = null; break;
		}

		return $tipos;
	}
	

	/**
	 * Get the value of pasta
	 */ 
	public function getPasta()
	{
		return $this->pasta;
	}

	/**
	 * Set the value of pasta
	 *
	 * @return  self
	 */ 
	public function setPasta($pasta)
	{
		if(isset($pasta) && !empty($pasta)){
			$this->pasta = $pasta;
		}
		return $this;
	}
}

?>