# 

# Tabla de ruteo API:

Endpoint | Variable | Verbo | Controller | Function | Descripción
:-:|:-:|:-:|:-:|:-:|-
articulos |        | GET  | MuebloideController | getArticles    | Obtener todos los articulos
articulos | :id    | GET  | MuebloideController | getItemDetails | Obtener un articulo dado un :id
articulosOrdenados | :orden    | GET  | MuebloideController | getArticlesOrdenados | Obtener todos los articulos ordenados por precio. Orden puede ser "asc" o "desc"
articulos |        | POST | MuebloideController | addArticle     | Agregar un articulo
articulos |        | PUT  | MuebloideController | setArticle     | Editar un articulo dado su id
categorias|        | GET  | MuebloideController | getCategories  | Obtener todas las categorias
categorias| :tipo  | GET  | MuebloideController | getArticlesByCategoryName | Obtener todos los articulos para una categoria
categorias|        | POST | MuebloideController | getCategories  | Agregar una categoria
categorias|        | PUT  | MuebloideController | getCategories  | Edita el nombre de una categoria
articulosEnPromo |        | POST  | MuebloideController | getArticlesEnPromo     | Obtiene todos los articulos en promo (en nuestro negocio, cada promo corresponde a una categoria entera)
apikey       |        | PUT | MuebloideController | generarApiKey  | Genera una APIKey para un email existente.


Parámetros GET **opcionales**:

- ordenarPor: {columna}.
- orden: ASC/DESC.
- page: pagina a mostrar.
- limit: cantidad de datos a mostrar.
- buscar: palabra clave a buscar. Para articulos busca en la columna "Nombre", para categorias en la columna "Tipo".

Por ejemplo: 

1. `.../api/articulos?ordenarPor=precio&buscar=Mesa`
2. `.../api/articulos?page=1&limit=5&buscar=Silla`
3. `.../api/categorias?orden=DESC`

Los endpoint de tipo POST y PUT están protegidos y es necesario enviar una `APIKEY` en el encabezado, y un JSON en el body con la información respectiva.

## POSTMAN:

Esta API se puede probar en Postman, y para ahorrar tiempo podés importar [este archivo de configuración](https://github.com/demateopablo/TPE-Web2-API/blob/main/MuebloideAPI.postman_collection.json) con los endpoints precargados.

Para que funcione, los archivos deben estar en http://localhost/TPE-Web2-API

## Ejemplo de envío de APIKEY:

   - ![image](https://github.com/demateopablo/TPE-Web2-API/assets/63564990/81da141c-3d1e-4f81-bdd0-d0d130a863f7)

<details><summary><h3>ApiKey de ejemplo</h2></summary>

```
IQ78FizfW4b8CQcjPayzdVPGMC/LdtTVSXBawOUjObwnyBYhpiq7LGGaZ2T9Tb6sfnS1xMPqdccAvexkZpaHvw==
```

</details>
<details><summary><h2>Ejemplo de JSONs para los POST/PUT</h2></summary>

### Añadir artículo:

```json
{
   "nombre":"Prueba API",
   "alto":105,
   "ancho":55,
   "precio":99999,
   "profundidad":207,
   "id_categoria":1,
   "imagePath":""
}
```

### Añadir categoría:

```json
{
   "tipo":"Nombre categoria"
}
```

### Editar artículo:

```json
{
   "id_articulo":1,
   "nombre":"Prueba API",
   "alto":105,
   "ancho":55,
   "precio":99999,
   "profundidad":207,
   "id_categoria":1,
   "imagePath":"images/img.jpg"
}
```

### Editar categoría:

```json
{
   "id_categoria":1,
   "tipo":"Nuevo nombre categoria"
}
```

### Generar ApiKey:

```json
{
   "email":"webadmin"
}
```
</details> 

