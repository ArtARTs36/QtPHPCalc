<?php

require_once("qrc://scripts/mainwindow.php");

$app = new QApplication($argc, $argv);

$w = new MainWindow;
$w->show();

return $app->exec();
