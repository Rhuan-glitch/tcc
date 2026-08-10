<?php

require_once __DIR__ . "/../config/config.php";


/* VERIFICA LOGIN */

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "administrador") {

    header("Location: ../../login.html");
    exit();

}


/* BUSCA CURSOS */

$sql = "SELECT * FROM curso ORDER BY id_curso ASC";

$resultado = $conn->query($sql);


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Gerenciar Cursos - 3R</title>

<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">

</head>


<body>


<div class="container mt-5">


<h2 class="mb-4">
Gerenciar Cursos
</h2>


<a href="../../formacao.php" class="btn btn-secondary mb-3">
Voltar para Formação
</a>


<table class="table table-bordered">


<thead>

<tr>

<th>ID</th>

<th>Imagem</th>

<th>Curso</th>

<th>Área</th>

<th>Carga Horária</th>

<th>Ações</th>

</tr>

</thead>


<tbody>


<?php while($curso = $resultado->fetch_assoc()): ?>


<tr>


<td>
<?= $curso["id_curso"] ?>
</td>


<td>

<img 
src="../../uploads/<?= $curso["img_curso"] ?>"
width="80">

</td>


<td>
<?= $curso["nome_curso"] ?>
</td>


<td>
<?= $curso["area"] ?>
</td>


<td>
<?= $curso["carga_horaria"] ?> horas
</td>


<td>


<a 
href="editar_curso.php?id=<?= $curso["id_curso"] ?>"
class="btn btn-warning btn-sm">

Editar

</a>



<a 
href="excluir_curso.php?id=<?= $curso["id_curso"] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Deseja excluir este curso?');">

Excluir

</a>


</td>


</tr>


<?php endwhile; ?>


</tbody>


</table>


</div>


</body>

</html>