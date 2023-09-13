<?php namespace Agungdhewe\Imagetosquare;
 
class BatchResize {
	public readonly string $SourceDir;
	public readonly string $TargetDir;
	public readonly string $List;
	public readonly int $TargetSize;
	public readonly string $TempDir;


	public function setSource(string $source) : void {
		$this->SourceDir = $source;
	}

	public function setTarget(string $target) : void {
		$this->TargetDir = $target;
	}

	public function setTargetSize(int $targetsize) : void {
		$this->TargetSize = $targetsize;
	}

	public function setList(string $list) :  void {
		$this->List = $list;
	}

	public function setTempDir(string $tempdir) :  void {
		$this->TempDir = $tempdir;
	}

	public function run() {

		$r = new resizer();
		$r->setTempDir($this->TempDir);
		try {
			if (!is_dir($this->SourceDir)) {
				throw new \Exception("Direktory source '".$this->SourceDir."' tidak ditemukan");
			}

			if (!is_dir($this->TargetDir)) {
				throw new \Exception("Direktory target '".$this->TargetDir."' tidak ditemukan");
			}

			if (!is_file($this->List)) {
				throw new \Exception("File list '".$this->List."' tidak ditemukan");
			}

			$rows = $this->readJsonListFile($this->List);
			foreach ($rows as $row) {
				$sourcepath = implode('/', [$this->SourceDir, $row->sourcename]);
				$targetpath = implode('/', [$this->TargetDir, $row->targetname]);
				if (!is_file($sourcepath)) {
					throw new \Exception("'$sourcepath' tidak ditemukan");
				} else {
					echo "reizing $sourcepath \r\n";
					$r->resize($sourcepath, $targetpath, $this->TargetSize);
				}
			}

		} catch (\Exception $ex) {
			throw $ex;
		}
	}


	public function readJsonListFile(string $filepath) : array {
		try {

	
			$fp = fopen($filepath, 'r');
			$content = fread($fp, filesize($filepath));
			$arr = json_decode($content);

			if (json_last_error()!=0) {
				throw new \Exception("ada kesalahan format pada file '$filepath'");
			}

			return $arr;
		} catch (\Exception $ex) {
			throw $ex;
		}
	}

}