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
        $sql = "SELECT alumno.idAlumno, alumno.nombreAlumno, alumno.apellidoAlumno, alumno.estatus_alumno, grupo.grado_grupo FROM alumno INNER JOIN grupo ON alumno.idGrupo = grupo.idGrupo AND alumno.estatus_alumno = 'Activo' AND grupo.idTutor = $_SESSION[id]";
        $resultado = $conn->query($sql);
        if ($resultado->num_rows > 0){
            while ($row = $resultado->fetch_assoc()) {
                ?>
            <tr>
                <th><?php echo $row['idAlumno']?></th>
                <td><?php echo $row['nombreAlumno']?></td>
                <td><?php echo $row['apellidoAlumno']?></td>
                <td><?php echo $row['grado_grupo']?></td>
                <td><?php echo $row['estatus_alumno']?></td>
                <td>
                    <a class="link-dark" style="text-decoration: none; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalinfo<?php echo $row['idAlumno'] ?>">
                        <i title="Información" class="fa-solid fa-circle-info fs-5 me-3"></i>
                    </a>
                    <a style="text-decoration: none;" href="editar_alum.php?idAlumno=<?php echo $row['idAlumno']?>" class="link-dark">
                        <i title="Editar" class="fa-solid fa-pen-to-square fs-5 me-3"></i>
                    </a>
                    <a style="text-decoration: none; cursor:pointer;" class="link-dark" onclick="alerta_eliminar(<?php echo $row['idAlumno']; ?>)">
                        <fs-5 title="Desactivar" class="fa-solid fa-circle-xmark fs-5"></i>
                    </a>
                </td>
            </tr>
            <?php
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No hay alumnos inactivos</td></tr>";
        }