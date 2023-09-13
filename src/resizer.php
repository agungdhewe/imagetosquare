<?php namespace Agungdhewe\Imagetosquare;
 
class Resizer {
	private string $_tempDir;
	private array $_bgColor;

	public function __construct() {
		$this->_tempDir = '/Volumes/ramdisk';
		$this->_bgColor = ['r'=>255, 'g'=>255, 'b'=>255];
	}

	public function setTempDir(string $location) : void {
		$this->_tempDir = $location;
	}


	public function resize(string $imagepath, string $targetpath, int $size) {
		try {
			if (!is_file($imagepath)) {
				throw new \Exception("'$imagepath' tidak ditemukan");
			}

			$targetsize = $size;
			$path_parts = pathinfo($imagepath);

			// ambil informasi ukuran image
			$imgsize = getimagesize($imagepath);
			$width = $imgsize[0];
			$height = $imgsize[1];
			$sizemax = $width > $height ? $width : $height;
	

			// buat image bg putih dengan ukuran sizemax
			$imgCanvas = imagecreatetruecolor($sizemax, $sizemax);
			$bgcolor = imagecolorallocate($imgCanvas, $this->_bgColor['r'], $this->_bgColor['g'], $this->_bgColor['b']);
			imagefill($imgCanvas, 0, 0, $bgcolor);

			// untk gabung image, imagepath harus ditaruh di tengah-tengah
			$locx = (int)(($sizemax - $width) / 2);
			$locy = (int)(($sizemax - $height) / 2);


			// gabungkan canvas dengan imagepath
			if ($path_parts['extension']=='jpg' || $path_parts['extension']=='jpeg') {
				$imgSource = imagecreatefromjpeg($imagepath);
			} else if ($path_parts['extension']=='png') {
				$imgSource = imagecreatefrompng($imagepath);
			} else {
				throw new \Exception("image $imagepath bukan PNG/JPG.");
			}
			
			imagecopymerge($imgCanvas, $imgSource, $locx, $locy, 0, 0, $width, $height, 100);

			// resise ukuran image ke $targetsize
			$imgStandart =  imagecreatetruecolor($targetsize, $targetsize);
			$bgcolor = imagecolorallocate($imgStandart, 255, 255, 255);
			imagefill($imgStandart, 0, 0, $bgcolor);
			imagecopyresized($imgStandart, $imgCanvas, 0, 0, 0, 0, $targetsize, $targetsize, $sizemax, $sizemax);
			
			$tempsquareimagepath = implode('/', [$this->_tempDir, basename($targetpath)]);
			imagejpeg($imgStandart, $tempsquareimagepath, 99);

			imagedestroy($imgStandart);
			imagedestroy($imgCanvas);
			imagedestroy($imgSource);

			copy($tempsquareimagepath, $targetpath);
			unlink($tempsquareimagepath);

		} catch (\Exception $ex) {
			throw $ex;
		}
	}

}

