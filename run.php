<?php
require_once __DIR__ . '/vendor/autoload.php';
use Agungdhewe\Imagetosquare\BatchResize;


$SOURCE = 'data/source/SS23';
$TARGET = 'data/result/SS23';
$LIST = 'data/list.json';
$TARGETSIZE = 1000;

try {
	$batch = new BatchResize();
	$batch->setSource(implode('/', [__DIR__, $SOURCE]));
	$batch->setTarget(implode('/', [__DIR__, $TARGET]));
	$batch->setTargetSize($TARGETSIZE);
	$batch->setList(implode('/', [__DIR__, $LIST]));

	$batch->run();	
	//$r->resize($sourcePath, $resultPath, 500);

} catch (\Exception $ex) {
	echo "\r\n";
	echo "\033[91mERROR\033[0m\r\n";
	echo $ex->getMessage();
	echo "\r\n\r\n";
}