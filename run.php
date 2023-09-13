<?php
require_once __DIR__ . '/vendor/autoload.php';
use Agungdhewe\Imagetosquare\BatchResize;


$SOURCE = 'data/source';
$TARGET = 'data/result';
$LIST = 'data/listdata.json';
$TARGETSIZE = 1000;
$TEMP = 'data/temp';

try {

	$inipath = __DIR__ . '/process.ini';
	if (is_file($inipath)) {
		$ini_array = parse_ini_file("process.ini");
		
		if (!array_key_exists('SOURCE', $ini_array)) {
			throw new \Exception('SOURCE belum didefinisikan di process.ini');
		}

		if (!array_key_exists('TARGET', $ini_array)) {
			throw new \Exception('TARGET belum didefinisikan di process.ini');
		}

		if (!array_key_exists('LIST', $ini_array)) {
			throw new \Exception('LIST belum didefinisikan di process.ini');
		}

		if (!array_key_exists('TARGETSIZE', $ini_array)) {
			throw new \Exception('TARGETSIZE belum didefinisikan di process.ini');
		}
		if (!array_key_exists('TEMP', $ini_array)) {
			throw new \Exception('TEMP belum didefinisikan di process.ini');
		}

		

		$SOURCE = $ini_array['SOURCE'];
		$TARGET = $ini_array['TARGET'];
		$LIST = $ini_array['LIST'];
		$TARGETSIZE = $ini_array['TARGETSIZE'];
		$TEMP = $ini_array['TEMP'];

	}

	echo "\r\n";
	echo "===============================\r\n";
	echo " Batch Image Resize => Square\r\n";
	echo "===============================\r\n";
	echo "\r\n";
	echo "Anda akan me resize images dengan konfigurasi seperti berikut:\r\n";
	echo "SOURCE: $SOURCE\r\n";
	echo "TARGET: $TARGET\r\n";
	echo "LIST: $LIST\r\n";
	echo "TARGETSIZE: $TARGETSIZE\r\n";
	echo "\r\n";
	echo "Apakah sudah benar y/N ? [N] ";
	
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
	if(trim($line) != 'y'){
		echo "ABORTING!\n";
		exit;
	}

	$batch = new BatchResize();
	$batch->setTempDir($TEMP);
	$batch->setSource(implode('/', [__DIR__, $SOURCE]));
	$batch->setTarget(implode('/', [__DIR__, $TARGET]));
	$batch->setTargetSize($TARGETSIZE);
	$batch->setList(implode('/', [__DIR__, $LIST]));

	$batch->run();	

} catch (\Exception $ex) {
	echo "\r\n\r\n";
	echo "\033[91mERROR\033[0m\r\n";
	echo $ex->getMessage();
	echo "\r\n\r\n";
}