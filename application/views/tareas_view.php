<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
   
    body {
        font-family: 'Arial', sans-serif;
        background-color: #eef2f5; 
        color: #333; 
        margin: 0;
        padding: 0;
    }

    
    header {
        background-color: #2c3e50; 
        color: #ecf0f1; 
        padding: 20px 0;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); 
    }

    h1 {
        font-size: 2.5rem;
        margin: 0;
        font-weight: 300; 
    }

  
    nav {
        background-color: #34495e; 
        padding: 10px 0;
    }

    nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
    }

    nav ul li {
        margin: 0 15px;
    }

    nav ul li a {
        text-decoration: none;
        color: #ecf0f1; 
        font-weight: 500;
    }

    nav ul li a:hover {
        text-decoration: underline; 
    }

    
    form {
        background-color: #fff; 
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        max-width: 600px; 
    }

    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #34495e; 
    }

    form input, form select, form textarea {
        width: 100%;
        padding: 10px;
        border: 2px solid #bdc3c7; 
        border-radius: 5px;
        margin-bottom: 15px; 
        transition: border-color 0.3s ease; 
    }

    form input:focus, form select:focus, form textarea:focus {
        border-color: #3498db;
    }

    
    button {
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease; 
        font-weight: bold; 
    }

    .btn-activate {
        background-color: #28a745; 
        color: #fff;
    }

    .btn-activate:hover {
        background-color: #218838; 
    }

    .btn-deactivate {
        background-color: #dc3545; 
        color: #fff;
    }

    .btn-deactivate:hover {
        background-color: #c82333; 
    }

  
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
    }

    table th, table td {
        padding: 12px;
        border: 1px solid #ddd; 
        text-align: left;
    }

    table th {
        background-color: #2c3e50; 
        color: #fff; 
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9; 
    }

    table tr:hover {
        background-color: #e1f0f4; 
    }

    .alert {
        padding: 10px;
        margin: 20px;
        border-radius: 5px;
    }

    .alert.success {
        background-color: #d4edda; 
        color: #155724; 
    }

    .alert.error {
        background-color: #f8d7da;
        color: #721c24; 
    }

  
    .modal-button {
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold; 
        transition: background-color 0.3s ease; 
        display: inline-block;
        width: 100%; 
        margin-top: 10px; 
    }

    .modal-button.activate {
        background-color: #28a745; 
        color: #fff;
    }

    .modal-button.activate:hover {
        background-color: #218838; 
    }

    .modal-button.deactivate {
        background-color: #dc3545; 
        color: #fff;
    }

    .modal-button.deactivate:hover {
        background-color: #c82333; 
    }

   
    .modal-content {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background-color: #fff; 
    }

    
    @media (max-width: 768px) {
        nav ul {
            flex-direction: column; 
        }
        
        form {
            margin: 10px; 
        }
        
        table {
            font-size: 0.9rem; 
        }
    }
</style>
<header>
    <h1>Sistema de Biblioteca</h1>
    
</header>

<body>
    <!--Botoones para los modales-->
    <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usuarioModal">Nuevo Usuario</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#libroModal">Nuevo Libro</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#prestamoModal">Nuevo Préstamo</button>
        <a href="<?= site_url('Biblioteca/login_view'); ?>" class="btn btn-danger">Logout</a>
        <div class="container">
    <!-- Modal Crear Usuario -->
    <div class="modal" id="usuarioModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formUsuario">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <!-- Tabla U -->
   
      <h2>Usuarios</h2>
        <table id="usuariosTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario->id; ?></td>
                <td><?php echo $usuario->nombre; ?></td>
                <td><?php echo $usuario->correo; ?></td>
                <td><?php echo $usuario->estado == 1 ? 'Activo' : 'Inactivo'; ?></td>
                <td>
                <button class="btn btn-warning cambiar-estado" data-id="<?php echo $usuario->id; ?>" data-estado="<?php echo $usuario->estado; ?>">
                        <?php echo $usuario->estado == 1 ? 'Inactivar' : 'Activar'; ?>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <!-- Modal Crear Libro -->
    <div class="modal fade" id="libroModal" tabindex="-1" role="dialog" aria-labelledby="libroModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="libroModalLabel">Nuevo Libro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formLibro">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="autor">Autor</label>
                            <input type="text" class="form-control" id="autor" name="autor" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Libros -->
    <h2>Libros</h2>
    <table id="librosTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
               
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?php echo $libro->id; ?></td>
                    <td><?php echo $libro->titulo; ?></td>
                    <td><?php echo $libro->autor; ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal Crear Préstamo -->
    <div class="modal fade" id="prestamoModal" tabindex="-1" role="dialog" aria-labelledby="prestamoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prestamoModalLabel">Nuevo Préstamo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formPrestamo">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <select class="form-control" id="usuario" name="usuario" required>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario->id ?>"><?= $usuario->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="libro">Libro</label>
                            <select class="form-control" id="libro" name="libro" required>
                                <?php foreach ($libros as $libro): ?>
                                    <option value="<?= $libro->id ?>"><?= $libro->titulo ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Préstamos -->
    <h2>Préstamos</h2>
    <table id="prestamosTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha de Préstamo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamos as $prestamo): ?>
                <tr>
                    <td><?php echo $prestamo->id; ?></td>
                    <td><?php echo $prestamo->nombre_usuario; ?></td>
                    <td><?php echo $prestamo->titulo_libro; ?></td>
                    <td><?php echo $prestamo->fecha_prestamo; ?></td>
                    <td>
                        <button class="btn btn-danger finalizar-prestamo" data-id="<?php echo $prestamo->id; ?>">Finalizar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('#usuariosTable').DataTable();
    $('#librosTable').DataTable();
    $('#prestamosTable').DataTable();

    // AJAX para crear usuario
    $('#formUsuario').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'Biblioteca/crear_usuario',
            data: $(this).serialize(),
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // AJAX para crear libro
    $('#formLibro').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'Biblioteca/crear_libro',
            data: $(this).serialize(),
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // AJAX para crear préstamo
    $('#formPrestamo').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'Biblioteca/crear_prestamo',
            data: $(this).serialize(),
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

      /**Estado */
      $(document).on('click', '.cambiar-estado', function() {
    let id = $(this).data('id');
    let estado = $(this).data('estado');
    let url = estado == 1 ? '<?= site_url('biblioteca/inactivar_usuario') ?>' : '<?= site_url('biblioteca/activar_usuario') ?>';

    console.log("Enviando ID: " + id + " Estado: " + estado); 

    $.ajax({
        url: url,
        method: 'POST',
        data: { id: id },
        success: function(response) {
            console.log("Respuesta del servidor: ", response); 
            let resp = JSON.parse(response);
            if (resp.status === 'success') {
               
                let nuevoEstado = estado == 1 ? 0 : 1; 
                let nuevoTexto = nuevoEstado == 1 ? 'Inactivar' : 'Activar';
                $(this).data('estado', nuevoEstado).text(nuevoTexto);
                $(this).closest('tr').find('td:eq(3)').text(nuevoEstado == 1 ? 'Activo' : 'Inactivo'); /
            } else {
                alert('Error al cambiar el estado: ' + resp.message);
            }
        }.bind(this), 
        error: function(xhr, status, error) {
            alert('Ha ocurrido un error en la solicitud: ' + error);
        }
    });
});


    // AJAX para finalizar préstamo
    $('.finalizar-prestamo').on('click', function() {
        var prestamoId = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'Biblioteca/finalizar_prestamo',
            data: { id: prestamoId },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });
});
</script>
</script>
</html>