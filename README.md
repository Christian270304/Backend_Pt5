# README

Lo primero que hice fue hacer como una especie de redireccionamineto en el index.php. La primera vez que se entra te redirecciona a la pagina de Mostrar.php.
```php
if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar';

        switch ($opcion) {
            case 'Insertar':
                include 'Html/Insertar.php';
                break;
            case 'Borrar':
                include 'Html/Borrar.php';
                break;
            case 'Modificar':
                include 'Html/Modificar.php';
                break;
            case 'BorrarVerificar':
                verificarDelet($_GET['id']);
                break;
            case 'ModificarArticulo':
                modificarPagina($_GET['id']);
                break;
            default:
                include 'Html/Mostrar.php';
        }
```
Esto lo hice para poder gestionar las redirecciones desde cualquier pagina que yo quisera redireccionar mediante un script de Javascript.
```js
<script>
        function redireccion(id){
            window.location.href = "index.php?pagina=ModificarArticulo&id=" + id;
        }
    </script>
```
Esto lo que hace es hacer una peticion GET pasandole el parametro pagina como el nombre de la pagina a la que queremos redireccionar, para luego mediante el index recoger esa informacion y seleccionar la pagina indicada.

Para poder mostrar los articulos he creado una funcion dentro del controlador.

```php
function mostrarArticle($click=false,$cat){
        $article_data = '<div class="articulo-container">'; // Contenedor para los artículos.
        $articles = select();
        
        if (!$click && $cat == 'Mostrar') {
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    $article_data .= '<div class="articulo" id="' . $article['id'] . '">'; // Contenedor por cada articulo.
                    $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>'; // Titulo del articulo.
                    $article_data .= '<p class="texto">' . $article['cos'] . '</p>'; // Cuerpo del articulo.
                    $article_data .= '</div>';
                }
            } else {
                $article_data = 'No hi han articles a la base de dades.';
            }
        } else {
            if ($cat == 'Borrar') {
                if (!empty($articles)) {
                    foreach ($articles as $article) {
                        $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectB" id="' . $article['id'] . '">';
                        $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                        $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                        $article_data .= '</button>';
                    }
                } else {
                    $article_data = 'No hi han articles a la base de dades.';
                }
            } else {
                if (!empty($articles)) {
                    foreach ($articles as $article) {
                        $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectM" id="' . $article['id'] . '">';
                        $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                        $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                        $article_data .= '</button>';
                    }
                } else {
                    $article_data = 'No hi han articles a la base de dades.';
                }
            }
        }
    
        $article_data .= '</div>';
        return $article_data;
    }
```
Esta funcion tiene dos parametros ya que la reutilizo en las paginas de Borrar y Modificar ya que dependiendo de lo que le pongas por el parametro $cat puede retornar los articulos con diferentes estilos. El parametro $click es para decirle a la funcion si hace falta que los articulos lo retorne dentro de una boton para que luego el usuario pueda hacer click.

En la pagina de insertar el articulo he creado un formulario que se envia por el metodo POST junatemte con un action para que posteriormente se recogera dentro de index.php.

```php
else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar';
        switch ($opcion) {
            case 'Insertar':
                insertarDatos($_POST['titulo'],$_POST['cuerpo']);
                break;
            case 'Borrar':
                include 'Html/Borrar.php';
                break;
            case 'BorrarVerificar':
                if ($_POST['boton'] === 'Si') {
                    // Acción cuando se presiona el botón "Sí"
                    // Aquí pondrías tu lógica para borrar el artículo
                    borrar($_POST['titulo'],$_POST['cuerpo']);
                    // Por ejemplo: llamar a una función para borrar
                    // borrarArticle($id);
                } elseif ($_POST['boton'] === 'No') {
                    // Acción cuando se presiona el botón "No"
                    include 'Html/Borrar.php';
                    // Por ejemplo: redirigir a otra página o mostrar un mensaje
                    // header("Location: index.php?pagina=Listado");
                }
                
                break;
            case 'Modificar':
                modificar($_POST['boton'],$_POST['titulo'],$_POST['cuerpo']);
                break;
            default:
                include 'Html/Mostrar.php';
        }

```
Esto lo que hace es agarrar el action y selecciona la funcion de insertar y le pasa por parametro los datos del formulario.

```php
function insertarDatos($titulo,$cuerpo){
        $mensajes= array();
        $mostrar = '';


        $titulo = isset($titulo) ? trim(htmlspecialchars($titulo)) : '';
        $cuerpo = isset($cuerpo) ? trim(htmlspecialchars($cuerpo)) : '';

        if (empty($titulo)) {
            $mensajes[] = 'El campo del titulo no puede estar vacio';
        }
        if (empty($cuerpo)) {
            $mensajes[] = 'El campo del cuerpo no puede estar vacio';
        }
        // Generar mensajes de error
        if (!empty($mensajes)) {
            $mostrar .= '<div id="caja_mensaje" class="errors">';
            foreach ($mensajes as $mensaje) {
                $mostrar .= $mensaje . '<br/>';
            }
            $mostrar .= '</div>';
        } else {
            // Intentar insertar datos
            $resultado = insertar($titulo, $cuerpo);
            $mostrar .= '<div id="caja_mensaje" class="enviar">' . $resultado . '</div>';
        }

        include 'Html/Insertar.php';
    }

```
Esta funcion lo que haces es verificar que el usuario haya puesto un titulo y un cuerpo de lo contrario salta un mensaje diciendole que le campo X no puede estar vacio.


Para la pagina de borrar reutilizon la funcion de mostrar los articulos pero con botones para que pueda seleccionar el usuario.
Cuando el usuario selecciona un articulo para borrar se le redirecciona a BorrarVerificar por el metodo GET para verificar que el usuario quiere borrar el articulo.
Dentro de esta pagina hay un formulario con los datos (titulo y cuerpo) del articulo y dos botones de borrar o cancelar. Si el usuario selecciona cancelar se le redirecciona a la pagina de Borrar, si el usuario selecciona el boton de borrar se llama a una funcion de borrar.
```php
function borrar($titulo,$cuerpo)  {
        $titol = isset($titulo) ? trim($titulo) : '';
        $cos = isset($cuerpo) ? trim($cuerpo) : '';
        $id = selectId($titol,$cos);
        if ($id != 1){
        $mensaje = borrarArticle($id);
        include 'Html/Borrar.php';
        } else{
            echo "Fallo";
        }
        
    }
```

Luego para la pagina de Modificar es practicamente lo mismo que la anterios solo que llama a una funcion de modificar.
```php
function modificar($id,$titulo,$cuerpo)  {
       $titol = isset($titulo) ? trim($titulo) : '';
       $cos = isset($cuerpo) ? trim($cuerpo) : '';
       $verid = verificarId($id);
       if ($verid == true){
       $mensaje = update($id,$titol,$cos);
       include 'Html/ModificarArticulo.php';
       } else{
           echo "Fallo";
       }
       
    }
```
Luego para poder gestionar el error 404 he creado una pagina que se muestra por ejemplo cuando no se encuentra el id de algun articulo.
```php
function modificarPagina($id)  {
        $ids = isset($id) ? trim(htmlspecialchars($id)) : '';
        $verificar = verificarId($ids);
        $mensaje = '';
        $titol = '';
        $cos = '';
        if ($verificar == false){
            include 'Html/404.php';
        } else {
            $articles = selectTitolCos($id);
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    $titol = $article['titol'] ;
                    $cos = $article['cos'];
                    include 'Html/ModificarArticulo.php';
                }
            } else {
                $mensaje = "No s'ha trobat l'article.";
            }
            
        }
        
        
    }
```

# Paginacion

Para la parte de paginacion he modficado la funcion de mostrarArticulos y he agregado nuevas funciones.
Para poder mostrar por pantalla el numero de articulos por pagina he hecho unos calculos de inicio y fin.
```php
$totalArticles = count($articles);
        $startIndex = ($page - 1) * $articlesPerPage;
        $endIndex = min($startIndex + $articlesPerPage, $totalArticles);
    
        // Mostrar artículos según la página
        for ($i = $startIndex; $i < $endIndex; $i++) {
            $article = $articles[$i];
            if (!$click && $cat == 'Mostrar') {
                $article_data .= '<div class="articulo" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</div>';
            } elseif ($cat == 'Borrar') {
                $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectB" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</button>';
            } else { // Para la opción de Modificar
                $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectM" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</button>';
            }
        }
```
Luego un poco mas abajo llamo a la funcion de generar la paginacion.
```php
function generarPaginacion($pagina, $articlesPerPage,$cat) {
        $articles = select(); // Obtener todos los artículos
        $totalArticles = count($articles); // Calcular el número total de artículos
        $totalPagines = ceil($totalArticles / $articlesPerPage); // Número total de páginas
        
        // Generar la barra de paginación
        $pagination = '<div class="pagination">';
    
        // Flechas a las paginas anteriores
        if ($pagina > 1) {
            $pagination .= '<a href="?pagina=' . $cat . '&page=1&articulosPorPagina=' . $articlesPerPage . '" class="arrow first">« Primera</a>';
            $pagination .= '<a href="?pagina=' . $cat . '&page=' . ($pagina - 1) . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow next">« Anterior</a>';

        }
    
        // Calcular el rango de páginas a mostrar
        $maxVisiblePages = 4;
        $startPage = max(1, $pagina - floor($maxVisiblePages / 2));
        $endPage = min($totalPagines, $startPage + $maxVisiblePages - 1);
    
        // Ajustar el rango si hay menos de 4 páginas
        if ($endPage - $startPage + 1 < $maxVisiblePages) {
            $startPage = max(1, $endPage - $maxVisiblePages + 1);
        }
    
        // Mostrar enlaces de paginación
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $pagina) {
                $pagination .= '<span class="current-page">' . $i . '</span>'; // Página actual
            } else {
                // Incluir artículos por página en el enlace de paginación
                $pagination .= '<a href="?pagina=' . $cat . '&page=' . $i . '&articulosPorPagina=' . $articlesPerPage . '">' . $i . '</a>'; // Enlace a la página
            }
        }
    
        // Flechas a la siguiente página
        if ($pagina < $totalPagines) {
            $pagination .= '<a href="?pagina=' . $cat . '&page=' . ($pagina + 1) . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow next">Siguiente »</a>';
            $pagination .= '<a href="?pagina=' . $cat . '&page='. $totalPagines . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow first">Última »</a>';
        }

    
        $pagination .= '</div>'; 
        return $pagination;
    }
```
Para que el usuario pueda decidir cuantos articulos se muestran por pagina tuve que modificar un poco el html agregando un formulario.
```php
    <form method="get" action="">
        <label for="articulosPorPagina">Artículos por página:</label>
        <?php
        $totalArticulos = totArticles(); // Obtener el total de artículos
        ?>
        <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>">
        <input type="hidden" name="pagina" value="<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar'; ?>">
        <input type="number" name="articulosPorPagina" id="articulosPorPagina" 
            value="<?php echo isset($_GET['articulosPorPagina']) ? $_GET['articulosPorPagina'] : 5; ?>" 
            min="1" max="<?php echo $totalArticulos; ?>">
        <button type="submit">Actualizar</button>
    </form>
```
Aqui lo que hago primero es ver cuantos articulos hay en la base de datos para que el usuario no pueda poner un numero mayor a los articulos que hay, despues como el formulario hace petisiones get puedo agarrar los valores de pagina y nuemro de articulos desde la url para luego llamar a la funcion de mostrar los articulos. Para evitar que pueda poner cualquier cosa en la url he creado una funcion que valida los campos.
```php
        $paginaActual = validarEntero('page', 1, 1, ceil($totalArticulos / 1));
        $articulosPorPagina = validarEntero('articulosPorPagina', 5, 1, $totalArticulos);

        function validarEntero($parametro, $valorPorDefecto, $min = 1, $max = PHP_INT_MAX) {
        if (isset($_GET[$parametro]) && filter_var($_GET[$parametro], FILTER_VALIDATE_INT)) {
            $valor = (int)$_GET[$parametro];
            if ($valor >= $min && $valor <= $max) {
                return $valor;
            }
        }
        return $valorPorDefecto;
    }
```
La función primero verifica si el parámetro que se pasa a través de la URL ($_GET[$parametro]) está definido y si es un número entero válido usando filter_var con el filtro FILTER_VALIDATE_INT. Si el valor del parámetro existe y es un entero válido, el valor se convierte a entero explícitamente con (int). Luego, la función comprueba si el valor entero obtenido está dentro del rango definido por $min y $max. Si el valor está en este rango, se devuelve.
Si alguna de las verificaciones falla (por ejemplo, si el valor no es un entero válido, o no está en el rango adecuado, o el parámetro no existe), la función devuelve el valor por defecto ($valorPorDefecto).


Para la parte de usuarios dejo aqui unos ejemplos de los usuarios con todos sus datos:

username: 'admin' password: 'Adm1n100!' correo: 'admin@gmail.com'

username: 'eduardo_81' password: 'DL1jF4bB!' correo: 'n551bjajq@yahoo.es'

username: 'gorka_63' password: 'hRBO3kM1?' correo: 'zrt5pg2i@lycos.es'

username: 'franciscojesus_74' password: 'xG5rF3nB!' correo: '65swvtqw3@caramail.com'

username: 'merce_72' password: 'eI3iE1dE!' correo: 'u3xtm8fwy@lycos.es'