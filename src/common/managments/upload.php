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
	public $files          = array();

	private function autoName($type = null, $indice = null)
	{
		if(isset($type) && strlen($type) > 0)
			return time().'_'.$indice.'.'.$type;
		return NULL;
	}

	public function save($pasta)
	{
		$folder = $_ENV['FOLDERUPLOAD'];
		$this->setPasta($pasta);
		if(empty($this->getPasta())){
			$this->setFiles(array("Não existe pasta de salvamento."), 'error');
			return false;
		}

		//SE ARRAY $_FILES VAZIO Nï¿½O Hï¿½ ARQUIVOS A SEREM SALVOS
		if(!isset($_FILES) || empty($_FILES)){
			$this->setFiles(array("Não existem arquivos para upload."), 'error');
			return false;
		}

		$indice = 1;
		foreach($_FILES as $input => $arquivo){
			$arq = array();

			if($arquivo['size'] >= $this->tamanho){
				$arq = array('status' => 'false','mensagem' => "Erro no tamanho máximo do arquivo.");
				$this->setFiles($arq, $input);
				continue;
			}

			// existe extensÃ£o
			$tp = substr($arquivo['name'], strrpos($arquivo['name'],'.')+1,strlen($arquivo['name']));
			if(!isset($tp) || empty($tp)){
				$arq = array('status' => 'false','mensagem' => "Não existe extensão.");
				$this->setFiles($arq, $input);
				continue;
			}

			//TIPO VálIDO
			if(!$this->tipoValido($tp)){
				$arq = array('status' => 'false','mensagem' => "Erro no tipo válido para o arquivo");
				$this->setFiles($arq, $input);
				continue;
			}

			// define nome do arquivo
			$fileName = $this->autoName( $tp, $indice);
			if(!isset($fileName) || empty($fileName)){
				$arq = array('status' => 'false','mensagem' => "Não existe nome para o arquivo.");
				$this->setFiles($arq, $input);
				continue;
			}

			//MOVER ARQUIVO
			if(!move_uploaded_file($arquivo['tmp_name'],  $folder.$this->pasta.'/'.$fileName)){
				$arq = array('status' => 'false','mensagem' => "Erro na transferência do arquivo.");
				$this->setFiles($arq, $input);
				continue;
			}

			//NOTIFICAR SALVAMENTO CORRETO
			$arq = array('status' => 'true','mensagem' => $this->getPasta().'/'.$fileName);
			$this->setFiles($arq, $input);
			$indice++;
		}

		return $this->getFiles();
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

	/**
	 * Get the value of files
	 */ 
	public function getFiles()
	{
		return $this->files;
	}

	/**
	 * Set the value of files
	 *
	 * @return  self
	 */ 
	public function setFiles(array $value,string $index)
	{
		if(isset($value) && !empty($value)){
			$this->files[$index] = $value;
		}
		return $this;
	}
}

?>