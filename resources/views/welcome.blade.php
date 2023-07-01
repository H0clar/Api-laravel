<!DOCTYPE html>
<html>
<head>
    <title>Página web de pacientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        /* Estilos para las ventanas emergentes */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

        /* Estilos para el fondo oscuro detrás de las ventanas emergentes */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        form {
            margin-top: 10px;
        }

        label {
            display: inline-block;
            width: 100px;
        }

        input[type="text"], input[type="date"] {
            width: 200px;
            padding: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"], input[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Listado de Pacientes</h1>
    <table id="pacientes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <button class="crear-paciente">Crear Paciente</button>

    <!-- Formulario para la creación de paciente -->
    <div id="crear-paciente-form" class="popup">
        <h2>Crear Paciente</h2>
        <form id="formulario-crear-paciente">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>

            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required><br>

            <button type="submit">Guardar</button>
            <button type="button" class="cancelar-creacion">Cancelar</button>
        </form>
    </div>

    <!-- Formulario para la edición de paciente -->
    <div id="editar-paciente-form" class="popup">
        <h2>Editar Paciente</h2>
        <form id="formulario-editar-paciente">
            <input type="hidden" id="paciente-id-editar" name="paciente-id-editar">

            <label for="nombre-editar">Nombre:</label>
            <input type="text" id="nombre-editar" name="nombre" required><br>

            <label for="fecha_nacimiento-editar">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento-editar" name="fecha_nacimiento" required><br>

            <label for="direccion-editar">Dirección:</label>
            <input type="text" id="direccion-editar" name="direccion" required><br>

            <button type="submit">Guardar</button>
            <button type="button" class="cancelar-edicion">Cancelar</button>
        </form>
    </div>

    <!-- Formulario para la eliminación de paciente -->
    <div id="eliminar-paciente-form" class="popup">
        <h2>Eliminar Paciente</h2>
        <form id="formulario-eliminar-paciente">
            <input type="hidden" id="paciente-id-eliminar" name="paciente-id-eliminar">

            <p>¿Estás seguro de que quieres eliminar este paciente?</p>

            <button type="submit">Eliminar</button>
            <button type="button" class="cancelar-eliminacion">Cancelar</button>
        </form>
    </div>

    <!-- Fondo oscuro detrás de las ventanas emergentes -->
    <div class="popup-overlay"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Realizar una petición GET a la API para obtener los pacientes
            $.get("/api/pacientes", function(data) {
                // Verificar si la respuesta es exitosa
                if (data.status) {
                    // Iterar sobre los pacientes y agregarlos a la tabla
                    $.each(data.data, function(index, paciente) {
                        var row = "<tr>" +
                            "<td>" + paciente.id + "</td>" +
                            "<td>" + paciente.nombre + "</td>" +
                            "<td>" + paciente.fecha_nacimiento + "</td>" +
                            "<td>" + paciente.direccion + "</td>" +
                            "<td>" +
                            "<button class='editar-paciente' data-id='" + paciente.id + "'>Editar</button> " +
                            "<button class='eliminar-paciente' data-id='" + paciente.id + "'>Eliminar</button>" +
                            "</td>" +
                            "</tr>";
                        $("#pacientes-table tbody").append(row);
                    });
                } else {
                    alert("Error al obtener los pacientes");
                }
            });

            // Mostrar formulario de creación de paciente al hacer clic en "Crear Paciente"
            $(".crear-paciente").click(function() {
                $("#crear-paciente-form").show();
                $(".popup-overlay").show();
            });

            // Cancelar creación de paciente
            $(".cancelar-creacion").click(function() {
                $("#crear-paciente-form").hide();
                $(".popup-overlay").hide();
            });

            // Mostrar formulario de edición de paciente al hacer clic en "Editar"
            $(document).on("click", ".editar-paciente", function() {
                var pacienteId = $(this).data("id");
                var nombre = $(this).closest("tr").find("td:nth-child(2)").text();
                var fechaNacimiento = $(this).closest("tr").find("td:nth-child(3)").text();
                var direccion = $(this).closest("tr").find("td:nth-child(4)").text();

                $("#paciente-id-editar").val(pacienteId);
                $("#nombre-editar").val(nombre);
                $("#fecha_nacimiento-editar").val(fechaNacimiento);
                $("#direccion-editar").val(direccion);

                $("#editar-paciente-form").show();
                $(".popup-overlay").show();
            });

            // Cancelar edición de paciente
            $(".cancelar-edicion").click(function() {
                $("#editar-paciente-form").hide();
                $(".popup-overlay").hide();
            });

            // Mostrar formulario de eliminación de paciente al hacer clic en "Eliminar"
            $(document).on("click", ".eliminar-paciente", function() {
                var pacienteId = $(this).data("id");

                $("#paciente-id-eliminar").val(pacienteId);

                $("#eliminar-paciente-form").show();
                $(".popup-overlay").show();
            });

            // Cancelar eliminación de paciente
            $(".cancelar-eliminacion").click(function() {
                $("#eliminar-paciente-form").hide();
                $(".popup-overlay").hide();
            });

            // Enviar el formulario de creación de paciente al hacer clic en "Guardar"
            $("#formulario-crear-paciente").submit(function(event) {
                event.preventDefault();

                var nombre = $("#nombre").val();
                var fechaNacimiento = $("#fecha_nacimiento").val();
                var direccion = $("#direccion").val();

                // Realizar una petición POST a la API para crear un paciente
                $.post("/api/pacientes", {
                    nombre: nombre,
                    fecha_nacimiento: fechaNacimiento,
                    direccion: direccion
                }, function(data) {
                    // Verificar si la respuesta es exitosa
                    if (data.status) {
                        // Agregar el nuevo paciente a la tabla
                        var paciente = data.data;
                        var row = "<tr>" +
                            "<td>" + paciente.id + "</td>" +
                            "<td>" + paciente.nombre + "</td>" +
                            "<td>" + paciente.fecha_nacimiento + "</td>" +
                            "<td>" + paciente.direccion + "</td>" +
                            "<td>" +
                            "<button class='editar-paciente' data-id='" + paciente.id + "'>Editar</button> " +
                            "<button class='eliminar-paciente' data-id='" + paciente.id + "'>Eliminar</button>" +
                            "</td>" +
                            "</tr>";
                        $("#pacientes-table tbody").append(row);

                        // Limpiar el formulario y ocultar la ventana emergente
                        $("#nombre").val("");
                        $("#fecha_nacimiento").val("");
                        $("#direccion").val("");
                        $("#crear-paciente-form").hide();
                        $(".popup-overlay").hide();
                    } else {
                        alert("Error al crear el paciente");
                    }
                });
            });

            // Enviar el formulario de edición de paciente al hacer clic en "Guardar"
            $("#formulario-editar-paciente").submit(function(event) {
                event.preventDefault();

                var pacienteId = $("#paciente-id-editar").val();
                var nombre = $("#nombre-editar").val();
                var fechaNacimiento = $("#fecha_nacimiento-editar").val();
                var direccion = $("#direccion-editar").val();

                // Realizar una petición PUT a la API para editar el paciente
                $.ajax({
                    url: "/api/pacientes/" + pacienteId,
                    type: "PUT",
                    data: {
                        nombre: nombre,
                        fecha_nacimiento: fechaNacimiento,
                        direccion: direccion
                    },
                    success: function(data) {
                        // Verificar si la respuesta es exitosa
                        if (data.status) {
                            // Actualizar los datos del paciente en la tabla
                            var row = $("#pacientes-table").find("tr:has(td:nth-child(1):contains('" + pacienteId + "'))");
                            row.find("td:nth-child(2)").text(nombre);
                            row.find("td:nth-child(3)").text(fechaNacimiento);
                            row.find("td:nth-child(4)").text(direccion);

                            // Ocultar la ventana emergente
                            $("#editar-paciente-form").hide();
                            $(".popup-overlay").hide();
                        } else {
                            alert("Error al editar el paciente");
                        }
                    }
                });
            });

            // Enviar el formulario de eliminación de paciente al hacer clic en "Eliminar"
            $("#formulario-eliminar-paciente").submit(function(event) {
                event.preventDefault();

                var pacienteId = $("#paciente-id-eliminar").val();

                // Realizar una petición DELETE a la API para eliminar el paciente
                $.ajax({
                    url: "/api/pacientes/" + pacienteId,
                    type: "DELETE",
                    success: function(data) {
                        // Verificar si la respuesta es exitosa
                        if (data.status) {
                            // Eliminar el paciente de la tabla
                            var row = $("#pacientes-table").find("tr:has(td:nth-child(1):contains('" + pacienteId + "'))");
                            row.remove();

                            // Ocultar la ventana emergente
                            $("#eliminar-paciente-form").hide();
                            $(".popup-overlay").hide();
                        } else {
                            alert("Error al eliminar el paciente");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
