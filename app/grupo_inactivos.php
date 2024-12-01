<?php
    session_start();
    include "../conexion.php";

    if (empty($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit();
    } else if ($_SESSION["rol"] != "Tutor") {
        header("Location: ../admin/inicio.php");
        exit();
    }

    $sql = "SELECT alumno.idAlumno, alumno.nombreAlumno, alumno.apellidoAlumno, alumno.estatus_alumno, grupo.grado_grupo 
        FROM alumno 
        INNER JOIN grupo ON alumno.idGrupo = grupo.idGrupo 
        WHERE alumno.estatus_alumno = 'Inactivo' 
        AND grupo.idTutor = $_SESSION[id]";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            ?>
            <tr>
                <th><?php echo $row['idAlumno']?></th>
                <td><?php echo $row['nombreAlumno']?></td>
                <td><?php echo $row['apellidoAlumno']?></td>
                <td><?php echo $row['grado_grupo']?></td>
                <td><?php echo $row['estatus_alumno']?></td>
                <td>
                    <a style="text-decoration: none; cursor:pointer;" class="link-dark" onclick="alerta_activar(<?php echo $row['idAlumno']; ?>)">
                        <i title="Activar" class="fa-solid fa-circle-check fs-5 me-3"></i>
                    </a>
                </td>
            </tr>
            <?php
        }
    }else{
        echo "<tr><td colspan='6' class='text-center'>No hay alumnos inactivos</td></tr>";
    }
