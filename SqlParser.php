<?php
/**
 * FileName: SqlParser.php
 * Created by Munna Khan.
 * Email: <engrmunnakhan@gmail.com>
 * Date: 6/13/19
 * Time: 11:16 PM
 */

class SqlParser
{
	private $ReadBuffer=4096;

	private $FileName;

	private $ParsedDB=[];

	private $BufferLine;

	private $CurrentDB=0;

	private $CurrentDBname;

	private $write=false;



	public function __construct($SourceFile)
	{
		$this->FileName=$SourceFile;
	}

	public function Prepare(){
		if ($fh = fopen($this->FileName, 'r')) {
			$i=0;
			while (!feof($fh)) {
				$i++;
				$line = fgets($fh,4096);
				if (preg_match_all('#\b(CREATE DATABASE)\b#', $line)){

					$this->CurrentDB++;
					$this->write=true;

					preg_match('/(\`[^\`]*\`)/', $line,$token);

					$this->CurrentDBname=str_replace("`", "", $token[0]);

					if($this->CurrentDB>1){
						$this->ReadBuffer="";

					}
				}
				if($this->write){
					$this->ParsedDB[$this->CurrentDBname][]=$line;
					$this->ReadBuffer.= $line;
				}

			}
			fclose($fh);
		}
		return $this;
	}

	public function Generate(){
		foreach ($this->ParsedDB as $DbName=>$Data){
			$Buffer="";
			foreach ($Data as $line){
				$Buffer.=$line;
			}

			$fileName=$DbName.".sql";

			$fname="output/".$fileName;
			if (!$fhandle = @fopen($fname, 'w')) {
				echo "Cannot open file ($fname)";
				exit;
			}
			if (!@fwrite($fhandle, $Buffer)) {
				echo "Cannot write to file ($fname)";
				exit;
			}
			fclose($fhandle);

			echo date('d-m-Y h:i')." File Created: ".$fileName."<br>";

		}

	}

}