<?php
require_once(PATH . '/app/model/model.php');
class MuebloideAPIModel extends Model
{

    //----------------------------------------Obtener articulos-----------------------------------------------------
    function getArticles($campo, $orden, $inicio, $cantidad, $buscar)
    {
        $sentence = "SELECT id_articulo,nombre,imagePath FROM articulo";
        if ($buscar != null) {
            $sentence .= " WHERE nombre LIKE '%$buscar%'";
        }
        $sentence .= " ORDER BY $campo $orden LIMIT $cantidad OFFSET $inicio";
        $query = $this->db->prepare($sentence);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    //----------------------------------------Obtener articulo dada su categoria-------------------------------------------
    function getArticlesByCategoryId($catId)
    {
        $sentence = "SELECT * FROM articulo WHERE id_categoria = ?";
        $query = $this->db->prepare($sentence);
        $query->execute([$catId]);
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    //----------------------------------------Obtener articulo dado su ID-------------------------------------------
    function getItemDetails($item_id)
    {
        $sentence = "SELECT a.*, c.tipo FROM articulo AS a INNER JOIN categoria AS c ON a.id_categoria=c.id_categoria WHERE a.id_articulo = ?";
        $query = $this->db->prepare($sentence);
        $query->execute([$item_id]);
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    //----------------------------------------Obtener categorias----------------------------------------------------
    function getCategories($campo, $orden, $inicio, $cantidad, $buscar)
    {
        $sentence = "SELECT * FROM categoria";
        if ($buscar != null) {
            $sentence .= " WHERE tipo LIKE '%$buscar%'";
        }
        $sentence .= " ORDER BY $campo $orden LIMIT $cantidad OFFSET $inicio";
        $query = $this->db->prepare($sentence);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    function getCategoriesPaginado($inicio, $cantidad)
    {
        $sentence = "SELECT * FROM categoria ";
        $query = $this->db->prepare($sentence);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    //----------------------------------------Obtener ID de categoria dado su tipo----------------------------------------------------

    function getCategoryIdByType($cat)
    {
        $sentence = "SELECT id_categoria FROM categoria WHERE tipo = ?";
        $query = $this->db->prepare($sentence);
        $query->execute([$cat]);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    //----------------------------------------Editar articulo----------------------------------------------------
    function setArticle($id, $nombre, $precio, $alto, $ancho, $profundidad, $id_categoria, $imagePath)
    {
        $sentence = "UPDATE articulo SET nombre=?,precio=?,alto=?,ancho=?,profundidad=?,id_categoria=?,imagePath=? WHERE id_articulo=?";
        $query = $this->db->prepare($sentence);
        $query->execute([$nombre, $precio, $alto, $ancho, $profundidad, $id_categoria, $imagePath, $id]);
    }
    //----------------------------------------Editar categoria----------------------------------------------------
    function setCategory($id, $tipo)
    {
        $sentence = "UPDATE categoria SET tipo=? WHERE id_categoria=?";
        $query = $this->db->prepare($sentence);
        $query->execute([$tipo, $id]);
    }
    //----------------------------------------Remover articulo----------------------------------------------------
    function removeArticle($id)
    {
        $sentence = "DELETE FROM articulo WHERE id_articulo=?";
        $query = $this->db->prepare($sentence);
        $query->execute([$id]);
    }
    //----------------------------------------Remover categoria----------------------------------------------------
    function removeCategory($id)
    {
        $sentence = "DELETE FROM categoria WHERE id_categoria=?";
        $query = $this->db->prepare($sentence);
        $query->execute([$id]);
    }
    //----------------------------------------Añadir articulo----------------------------------------------------
    function AddArticle($nombre, $precio, $alto, $ancho, $profundidad, $id_categoria, $imagePath)
    {
        $sentence = "INSERT INTO articulo (nombre,precio,alto,ancho,profundidad,id_categoria,imagePath) VALUES (?,?,?,?,?,?,?) ";
        $query = $this->db->prepare($sentence);
        $query->execute([$nombre, $precio, $alto, $ancho, $profundidad, $id_categoria, $imagePath]);
    }
    //----------------------------------------Añadir categoria----------------------------------------------------
    function addCategory($tipo)
    {
        $sentence = "INSERT INTO categoria (tipo) VALUES (?)";
        $query = $this->db->prepare($sentence);
        $query->execute([$tipo]);
    }

    //----------------------------------------Obtener articulos en promoción--------------------------------------
    function getArticlesEnPromo($campo, $orden, $inicio, $cantidad, $buscar, $categoriaEnPromo)
    {
        $sentence = "SELECT a.id_articulo,a.nombre,a.precio,a.imagePath,c.tipo FROM articulo AS a INNER JOIN categoria AS c ON a.id_categoria = c.id_categoria  WHERE c.tipo='$categoriaEnPromo'";
        if ($buscar != null) {
            $sentence .= " AND nombre LIKE '%$buscar%'";
        }
        $sentence .= " ORDER BY $campo $orden LIMIT $cantidad OFFSET $inicio";
        $query = $this->db->prepare($sentence);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    //----------------------------------------Busca la APIKEY en el listado de usuarios--------------------------------------
    function isValidApiKey($apikey)
    {
        $sentence = "SELECT * from usuario WHERE apikey = ?";
        $query = $this->db->prepare($sentence);
        $query->execute([$apikey]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }
    //----------------------------------------Registra la APIKEY para un usuario--------------------------------------
    function registrarKey($email,$apikey)
    {
        $sentence = "UPDATE usuario SET apikey=? WHERE email=?";
        $query = $this->db->prepare($sentence);
        $query->execute([$apikey,$email]);
    }
    //----------------------------------------Buscar un usuario por su email--------------------------------------
    function getUser($email)
    {
        $sentence = "SELECT email,nombre from usuario WHERE email = ?";
        $query = $this->db->prepare($sentence);
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }



    //--------------------Funciones del modelo anterior (no utilizadas en TPE3)-------------------------------------------------------------

    /* 
   

        function getCategoryById($id)
        {
            $sentence = "SELECT * FROM categoria WHERE id_categoria = ?";
            $query = $this->db->prepare($sentence);
            $query->execute([$id]);
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        }




        
        function registerUser($email, $nombre, $password)
        {
            $pass = password_hash($password, PASSWORD_BCRYPT);
            $sentence = "INSERT INTO usuario (email,nombre,password) VALUES (?,?,?)";
            $query = $this->db->prepare($sentence);
            $query->execute([$email, $nombre, $pass]);
        }
        
     */

}


?>