<?php  

require "config/debug.php";
require "core/Router.php";

/* 
* Запуск роутера
* @param контроллер/действие
* @param get параметры
*/ 
Router::dispatch(trim($_SERVER['PATH_INFO'],'/'),$_SERVER['QUERY_STRING'] );


