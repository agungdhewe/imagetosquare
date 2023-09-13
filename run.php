<?php namespace agungdhewe\imagetosquare;

require_once 'vendor/autoload.php';


$sourcePath = implode('/', [__DIR__, 'data/source/SS23/D15NUA06K22C1Q8X_00.jpg']);
$resultPath = implode('/', [__DIR__, 'data/result/SS23/hasil image D15NUA06K22C1Q8X_00.jpg']);

$r = new resizer();
$r->resize();