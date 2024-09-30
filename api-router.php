<?php
//defino las URL de la raiz para poder utilizar URL semanticas correctamente
define('PATH', dirname(__FILE__));
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');
//relaciono al controlador
require_once(PATH . '/config.php');
require_once(PATH . '/libs/router.php');
require_once(PATH . '/app/controller/muebloideController.php');

//crea el router

$MuebloideController = new MuebloideController();
$router = new Router();

//defino la tabla de ruteo

//obtener articulos
$router->addRoute('articulos','GET','MuebloideController','getArticles');
//obtener articulos ordenados por precio (ascendente o descendente) - Consigna obligatoria 3 TPE
$router->addRoute('articulosOrdenados/:orden','GET','MuebloideController','getArticlesOrdenados');
//obtener detalles de un articulo
$router->addRoute('articulos/:id','GET','MuebloideController','getArticleDetails');
//añadir articulo (requiere autenticacion por ApiKey)
$router->addRoute('articulos','POST','MuebloideController','addArticle');
//editar articulo (requiere autenticacion por ApiKey)
$router->addRoute('articulos','PUT','MuebloideController','setArticle');
//obtener categorias
$router->addRoute('categorias','GET','MuebloideController','getCategories');
//obtener articulos de una categoria
$router->addRoute('categorias/:tipo','GET','MuebloideController','getArticlesByCategoryName');
//añadir categoria (requiere autenticacion por ApiKey)
$router->addRoute('categorias','POST','MuebloideController','addCategory');
//editar categoria (requiere autenticacion por ApiKey)
$router->addRoute('categorias','PUT','MuebloideController','setCategory');
//Obtener articulos en promoción vigente
$router->addRoute('articulosEnPromo','GET','MuebloideController','getArticlesEnPromo');
//Generar ApiKey para un email registrado en la DB (requiere autenticacion por ApiKey)
$router->addRoute('apikey','PUT','MuebloideController','generarApiKey');


// ejecuta la ruta (sea cual sea)
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
?>