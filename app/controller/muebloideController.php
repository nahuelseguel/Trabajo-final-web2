<?php
require_once(PATH . '/app/model/muebloideModel.php');
require_once(PATH . '/app/view/muebloideView.php');
class MuebloideController
{
    private $model;
    private $view;
    private $ordenarPor;
    private $orden;
    private $buscar;
    private $page;
    private $limit;
    private $inicio;

    public function __construct()
    {
        $this->model = new MuebloideAPIModel;
        $this->view = new MuebloideAPIView;
    }

    private function getParams()
    {
        $this->ordenarPor = isset($_GET["ordenarPor"]) ? $_GET["ordenarPor"] : null;
        $this->orden = isset($_GET["orden"]) ? $_GET["orden"] : "asc";
        $this->buscar = isset($_GET["buscar"]) ? $_GET["buscar"] : null;
        //pagina a mostrar
        $this->page = isset($_GET["page"]) ? $_GET["page"] : 1;
        //cantidad a mostrar, por defecto 100
        $this->limit = isset($_GET["limit"]) ? $_GET["limit"] : 100;
        //calculo del offset(desplazamiento)
        $this->inicio = $this->limit * $this->page - $this->limit;
    }

    private function getData()
    {
        $params = file_get_contents("php://input");
        return json_decode($params);
    }

    function getArticles()
    {
        $this->getParams();
        $this->ordenarPor == null ? $this->ordenarPor = "id_articulo" : $this->ordenarPor;
        //Busco todos los articulos.
        $articles = $this->model->getArticles($this->ordenarPor, $this->orden, $this->inicio, $this->limit, $this->buscar);
        //si existen articulos:
        if ($articles) {
            //los muestro
            $this->view->response($articles, 200);
        } else {
            //si no existen: muestra el mensaje.
            $this->view->response("No se encontraron articulos!", 404);
        }
    }

    //esta funcion cumple con el requerimiento obligatorio del TPE pero no sería necesaria usando directamente getArticles() e indicando el campo y criterio de ordenamiento.

    /* El servicio que lista una colección entera debe poder ordenarse opcionalmente por al
    menos un campo de la tabla, de manera ascendente o descendente */

    function getArticlesOrdenados($params)
    {
        $this->getParams();
        $orden = $params[":orden"];
        if ($orden != "asc" && $orden != "desc") {
            $orden = "asc";
        }
        //Busco todos los articulos.
        $articles = $this->model->getArticles("precio", $orden, $this->inicio, $this->limit, $this->buscar);
        //si existen articulos:
        if ($articles) {
            //los muestro
            $this->view->response($articles, 200);
        } else {
            //si no existen: muestra el mensaje.
            $this->view->response("No se encontraron articulos!", 404);
        }
    }
    function getCategories()
    {
        $this->getParams();
        $this->ordenarPor == null ? $this->ordenarPor = "id_categoria" : $this->ordenarPor;
        //busco las categorías
        $categories = $this->model->getCategories($this->ordenarPor, $this->orden, $this->inicio, $this->limit, $this->buscar);
        //si existen categorias
        if ($categories) {
            //las muestro
            $this->view->response($categories, 200);
        } else {
            //si no existen: muestra el mensaje.
            $this->view->response("No se encontraron categorias", 404);
        }
    }
    function getArticlesByCategoryName($params)
    {
        $tipo = $params[":tipo"];
        $category = $this->model->getCategoryIdByType($tipo);
        //si la categoría existe, busco sus articulos en base al id de categoria:
        if ($category) {
            $articles = $this->model->getArticlesByCategoryId($category->id_categoria);
            //si tiene articulos: Los muestro
            if ($articles) {
                $this->view->response($articles, 200);
            } else {
                //si existe la categoría pero no hay articulos:
                $this->view->response("No se encontraron artículos para la categoría", 404);
            }
        } else {
            //si no existe la categoría:
            $this->view->response("Categoría no encontrada.", 404);
        }
    }
    function getArticleDetails($params)
    {
        $id = $params[":id"];
        //busco detalles para un item ID
        $details = $this->model->getItemDetails($id);
        if ($details) {
            //si los encontró, muestra:
            $this->view->response($details, 200);
        } else {
            //si no encontró articulo con el ID dado:
            $this->view->response("No se encontró el articulo.", 404);
            ;
        }
    }
    function setArticle($id)
    {   if ($this->validar()) {
            $params = $this->getData();
            //verificamos si el post no está vacío y si trae todos los datos requeridos
            if (!empty($params) && isset($params->nombre) && isset($params->precio) && isset($params->alto) && isset($params->ancho) && isset($params->profundidad) && isset($params->id_categoria) && isset($params->imagePath)) {
                $nombre = $params->nombre;
                $precio = $params->precio;
                $alto = $params->alto;
                $ancho = $params->ancho;
                $profundidad = $params->profundidad;
                $id_categoria = $params->id_categoria;
                $imagePath = $params->imagePath;

                //añado el articulo.
                $this->model->setArticle($id, $nombre, $precio, $alto, $ancho, $profundidad, $id_categoria, $imagePath);
                $this->view->response("El articulo $id fue editado con éxito", 201);
            } else {
                //si faltó algun dato, doy error.
                $this->view->response("Ha ocurrido un error", 400);} 
        }else //no tiene permisos
        $this->view->response("No tiene permisos para realizar esta acción", 401);
    }
    function setCategory($id)
    {   
        if ($this->validar()) {
            $params = $this->getData();
            //verificamos si el post no está vacío y si trae todos los datos requeridos
            if (!empty($params) && isset($params->tipo) && isset($params->id_categoria)) {
                $tipo = $params->tipo;
                $id = $params->id_categoria;
                $this->model->setCategory($id, $tipo);
                $this->view->response("La categoria $id fue modificada con éxito, ahora se llama $tipo.", 201);
            } else {
                //si faltó algun dato, doy error.
                $this->view->response("Ha ocurrido un error", 400);
            }
        } else //no tiene permisos
        $this->view->response("No tiene permisos para realizar esta acción", 401);
    }

    function addArticle()
    {
        if ($this->validar()) {
            $params = $this->getData();
            //verificamos si el post no está vacío y si trae todos los datos requeridos
            if (!empty($params) && isset($params->nombre) && isset($params->precio) && isset($params->alto) && isset($params->ancho) && isset($params->profundidad) && isset($params->id_categoria) && isset($params->imagePath)) {
                $nombre = $params->nombre;
                $precio = $params->precio;
                $alto = $params->alto;
                $ancho = $params->ancho;
                $profundidad = $params->profundidad;
                $id_categoria = $params->id_categoria;
                $imagePath = $params->imagePath;
                //añado el articulo.
                $this->model->addArticle($nombre, $precio, $alto, $ancho, $profundidad, $id_categoria, $imagePath);
                $articulo = $nombre;
                $this->view->response($articulo . " añadido con éxito.", 201);
            } else {
                //si faltó algun dato, doy error.
                $this->view->response("Ha ocurrido un error", 400);
            }
        } else //no tiene permisos
            $this->view->response("No tiene permisos para realizar esta acción", 401);
    }
    function addCategory()
    {   if ($this->validar()) {
            $params = $this->getData();
            //verificamos si el post no está vacío y si trae todos los datos requeridos
            if (!empty($params) && isset($params->tipo)) {
                $tipo = $params->tipo;
                //añado la categoria.
                $cat = $this->model->getCategoryIdByType($tipo);
                if (!$cat) {
                    $this->model->addCategory($tipo);
                    $this->view->response($tipo . " añadido con éxito.", 201);
                } else {
                    $this->view->response("La categoría ya existe", 500);
                }
            } else {
                //si faltó algun dato, doy error.
                $this->view->response("Ha ocurrido un error", 400);}
        } else //no tiene permisos
        $this->view->response("No tiene permisos para realizar esta acción", 401);
    }

    function getArticlesEnPromo()
    {
        //Las promos de nuestro negocio son siempre por categoria completa. La categoria en promo cambia cada dos meses.
        /*     
           Enero-Febrero | "Mesa"
           Marzo-Abril | "Silla"
           Mayo-Junio | "Sillon"
           Julio-Agosto | "Cama"
           Septiembre-Octubre | "Escritorio"
           Noviembre-Diciembre | "Muebles de exterior"
        */
        $categoriaEnPromo = "Muebles de Exterior";
        $this->getParams();
        $this->ordenarPor == null ? $this->ordenarPor = "id_articulo" : $this->ordenarPor;
        //Busco todos los articulos.
        $articles = $this->model->getArticlesEnPromo($this->ordenarPor, $this->orden, $this->inicio, $this->limit, $this->buscar, $categoriaEnPromo);
        //si existen articulos:
        if ($articles) {
            //los muestro
            $this->view->response($articles, 200);
        } else {
            //si no existen: muestra el mensaje.
            $this->view->response("No se encontraron articulos en promoción!", 404);
        }
    }

    function validar()
    {
       
        $existe = false;
        if (isset($_SERVER['HTTP_APIKEY'])) {
            $clave = $_SERVER['HTTP_APIKEY'];
            $existe = $this->model->isValidApiKey($clave);
        }
        return $existe;
    }

    function generarApiKey()
    {
        if ($this->validar()) {
            $params = $this->getData();

            $email = $params->email;
            $key = base64_encode(random_bytes(64));
            $usuario = $this->model->getUser($email);

            if ($usuario) {
                $this->model->registrarKey($email, $key);
                $this->view->response("Clave generada exitosamente => " . $key, 201);
            } else
                $this->view->response("No se encontró al usuario " . $email, 404);
        }
        else //no tiene permisos
        $this->view->response("No tiene permisos para realizar esta acción", 401);
    }



}


?>