<!DOCTYPE html>
<html lang="cat">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link href="Estilos/estilos.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">

            </div>
            <nav>
                <ul>
                    <li><a href="index.php?pagina=Inicio">Inici</a></li>
                    <li><a href="index.php?pagina=Mostrar">Articles</a></li>
                    <li><a href="index.php?pagina=Insertar">Insertar Article</a></li>
                </ul>
            </nav>
            <div class="user-icon">
                <label for="dropdown">
                    <?php
                    // PHP: Comprobar si el usuario ya tiene una imagen guardada
                    $profileImage = (!empty(isset($_SESSION['profile_image']))) ? $_SESSION['profile_image'] : $defaultImage;
                    ?>
                    <img src="<?php echo $profileImage; ?>" alt="Foto de perfil" id="userIcon">
                </label>
                <input hidden class="dropdown" type="checkbox" id="dropdown" name="dropdown" />
                <div class="section-dropdown">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="index.php?pagina=Perfil">Perfil <i class="uil uil-arrow-right"></i></a>
                        <a href="index.php?pagina=MostrarInici&logout=1">Tancar Sessió <i class="uil uil-arrow-right"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="content-admin">
            <h1>Administrar Usuarios</h1>
            <input type="text" id="searchInput" placeholder="Buscar por Username o Email" onkeyup="searchUsers()">
            <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel">
                <div class="panel-body table-responsive">
                    <table class="table" id="usersTable">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Acció</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                    require_once 'Model/Usuarios.php'; // Incluir el modelo que maneja los usuarios

                    // Obtener la lista de usuarios
                    $usuarios = obtenerUsuarios(); // Asegúrate de tener esta función en tu modelo

                    foreach ($usuarios as $usuario) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($usuario['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                        echo "<td><a href='#' onclick='openDeleteModal(" . htmlspecialchars($usuario['id']) . ")'>Eliminar</a></td>";
                        echo "</tr>";
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
            <button><a href="index.php?pagina=Mostrar">Volver</a></button>

            <div id="deleteModal" class="modal">
                        <div class="modal-content">
                            <div class="header">
                                <span class="close" id="closeModal">&times;</span>
                                <h2>Confirmar Eliminación</h2>
                            </div>
                            <p>¿Desea eliminar este usuario? <input type="text" readonly value="<?php echo htmlspecialchars($usuario['username'])?>"></p>
                            <p>¿También desea eliminar todos los artículos asociados?</p>
                            <form id="deleteForm" method="POST" action="index.php?pagina=EliminarUsuario">
                                <input type="hidden" name="user_id" id="user_id" value="">
                                <button type="button" id="confirmDelete" class="btn">Eliminar Usuario y Artículos</button>
                                <button type="button" id="confirmDeleteUser " class="btn">Eliminar Solo Usuario</button>
                                <button type="button" id="cancelDelete" class="btn">Cancelar</button>
                            </form>
                        </div>
                    </div>







                    
        </div>
    </div>

    <!-- <?php
    // PHP: Comprobar si el usuario ya tiene una imagen guardada
    $defaultImage = "https://storage.googleapis.com/a1aa/image/JLwi3piUzQY3G92u0CH63SjxE3kuf8lWqsoTZH7fYWfAkqWnA.jpg"; // URL predeterminada
    $profileImage = (!empty(isset($_SESSION['profile_image']))) ? $_SESSION['profile_image'] : $defaultImage;
    ?>
    <div class="container">
        <div class="account">
            <div class="account-icon">
                <img src="<?php echo $profileImage; ?>" alt="Foto de perfil">
                <ul class="dropdown">
                    <li><a href="index.php?pagina=Perfil">Perfil</a></li>
                    <li><a href="index.php?pagina=MostrarInici">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-toggle" id="menu-toggle">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <div class="nav-grid">
            <nav class="nav-bar">
                <ul>
                    <li><a href="index.php?pagina=Inicio"><img class="icon" src="Imagenes/house.svg"><span>Inici</span></a></li>
                    <li><a href="index.php?pagina=Mostrar"><img class="icon" src="Imagenes/newspaper.svg"><span>Articles</span></a></li>
                    <li><a href="index.php?pagina=Insertar"><img class="icon" src="Imagenes/add-square.svg"><span>Insertar Article</span></a></li>
                    <li><a href="index.php?pagina=Borrar"><img class="icon" src="Imagenes/delete-button.svg"><span>Borrar Article</span></a></li>
                    <li><a href="index.php?pagina=Modificar"><img class="icon" src="Imagenes/edit.svg"><span>Modificar Article</span></a></li>
                </ul>
            </nav>
        </div>
        
    </div> -->
    <script>
    // Función para abrir el modal de eliminación
    function openDeleteModal(userId) {
        document.getElementById("user_id").value = userId; // Establecer el ID del usuario a eliminar
        document.getElementById("deleteModal").style.display = "block"; // Mostrar el modal
    }

    // Cerrar el modal cuando se hace clic en la X
    document.getElementById("closeModal").onclick = function() {
        document.getElementById("deleteModal").style.display = "none"; // Cerrar el modal
    }

    // Cerrar el modal cuando se hace clic en "Cancelar"
    document.getElementById("cancelDelete").onclick = function() {
        document.getElementById("deleteModal").style.display = "none"; // Cerrar el modal
    }

    // Confirmar eliminación de usuario y artículos
    document.getElementById("confirmDelete").onclick = function() {
        // Agregar un campo oculto para indicar que se deben eliminar los artículos
        const form = document.getElementById("deleteForm");
        const eliminarArticulos = document.createElement("input");
        eliminarArticulos.type = "hidden";
        eliminarArticulos.name = "eliminarArticulos";
        eliminarArticulos.value = "true";
        form.appendChild(eliminarArticulos);
        form.submit(); // Enviar el formulario
    }

    // Confirmar eliminación solo del usuario
    document.getElementById("confirmDeleteUser ").onclick = function() {
        const form = document.getElementById("deleteForm");
        form.submit(); // Enviar el formulario sin eliminar artículos
    }

    // Asegúrate de que el modal esté oculto al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("deleteModal").style.display = "none"; // Asegúrate de que el modal esté oculto
    });

    function searchUsers() {
        // Obtener el valor del campo de búsqueda
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase(); // Convertir a minúsculas para hacer la búsqueda insensible a mayúsculas
        const table = document.getElementById('usersTable');
        const tr = table.getElementsByTagName('tr'); // Obtener todas las filas de la tabla

        // Iterar a través de todas las filas de la tabla (excepto la primera que es el encabezado)
        for (let i = 1; i < tr.length; i++) {
            const tdUsername = tr[i].getElementsByTagName('td')[0]; // Obtener la celda de Username
            const tdEmail = tr[i].getElementsByTagName('td')[1]; // Obtener la celda de Email

            if (tdUsername || tdEmail) {
                const usernameValue = tdUsername.textContent || tdUsername.innerText; // Obtener el texto del Username
                const emailValue = tdEmail.textContent || tdEmail.innerText; // Obtener el texto del Email

                // Comprobar si el texto del Username o Email incluye el texto de búsqueda
                if (usernameValue.toLowerCase().indexOf(filter) > -1 || emailValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = ""; // Mostrar la fila si coincide
                } else {
                    tr[i].style.display = "none"; // Ocultar la fila si no coincide
                }
            }
        }
    }
</script>
</body>

</html>