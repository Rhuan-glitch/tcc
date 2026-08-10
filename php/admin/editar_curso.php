<?php

require_once __DIR__ . "/../config/config.php";


/* ==========================================================
   VERIFICA LOGIN
========================================================== */

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "administrador") {

    header("Location: ../../login.html");
    exit();

}


/* ==========================================================
   BUSCA CURSO
========================================================== */

$id = (int)($_GET["id"] ?? 0);


$stmt = $conn->prepare(
    "SELECT * FROM curso WHERE id_curso = ?"
);

$stmt->bind_param(
    "i",
    $id
);


$stmt->execute();


$resultado = $stmt->get_result();


$curso = $resultado->fetch_assoc();



if (!$curso) {

    exit("Curso não encontrado.");

}



/* ==========================================================
   VARIÁVEIS
========================================================== */

$erros = [];



/* ==========================================================
   ATUALIZA CURSO
========================================================== */

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $nome_curso = trim($_POST["nome_curso"] ?? "");

    $area = trim($_POST["area"] ?? "");

    $carga_horaria = (int)($_POST["carga_horaria"] ?? 0);

    $descricao = trim($_POST["descricao"] ?? "");

    $conteudo_programatico = trim($_POST["conteudo_programatico"] ?? "");

    $certificado = $_POST["certificado"] ?? "";

    $url_curso = trim($_POST["url_curso"] ?? "");




    /* ======================================================
       VALIDAÇÕES
    ====================================================== */


    if ($nome_curso == "") {

        $erros[] = "Informe o nome do curso.";

    }



    if ($area == "") {

        $erros[] = "Informe a área.";

    }



    if ($carga_horaria <= 0) {

        $erros[] = "Carga horária inválida.";

    }



    if ($descricao == "") {

        $erros[] = "Informe a descrição.";

    }



    if ($url_curso == "") {

        $erros[] = "Informe o link do curso.";

    }




    /* ======================================================
       IMAGEM
    ====================================================== */


    $imagem = $curso["img_curso"];



    if (!empty($_FILES["img_curso"]["name"])) {


        $arquivo = $_FILES["img_curso"];



        if ($arquivo["error"] === 0) {


            $permitidos = [

                "image/jpeg",

                "image/png",

                "image/webp"

            ];



            if (!in_array($arquivo["type"], $permitidos)) {

                $erros[] = "Formato de imagem inválido.";

            }



            if ($arquivo["size"] > 3 * 1024 * 1024) {

                $erros[] = "Imagem maior que 3MB.";

            }




            if (empty($erros)) {


                $extensao = pathinfo(

                    $arquivo["name"],

                    PATHINFO_EXTENSION

                );



                $imagem = uniqid("curso_") . "." . $extensao;



                $destino = __DIR__ . "/../uploads/" . $imagem;



                if (!move_uploaded_file(

                    $arquivo["tmp_name"],

                    $destino

                )) {


                    $erros[] = "Erro ao salvar imagem.";


                } else {



                    if (

                        !empty($curso["img_curso"]) &&

                        file_exists(

                            __DIR__ .

                            "/../../uploads/" .

                            $curso["img_curso"]

                        )

                    ) {


                        unlink(

                            __DIR__ .

                            "/../../uploads/" .

                            $curso["img_curso"]

                        );


                    }



                }


            }



        } else {


            $erros[] = "Erro no upload da imagem.";


        }



    }





    /* ======================================================
       UPDATE NO BANCO
    ====================================================== */


    if (empty($erros)) {


        $stmt = $conn->prepare("

            UPDATE curso SET

                nome_curso = ?,

                area = ?,

                carga_horaria = ?,

                descricao = ?,

                conteudo_programatico = ?,

                certificado = ?,

                img_curso = ?,

                url_curso = ?


            WHERE id_curso = ?

        ");



        $stmt->bind_param(

            "ssisssssi",

            $nome_curso,

            $area,

            $carga_horaria,

            $descricao,

            $conteudo_programatico,

            $certificado,

            $imagem,

            $url_curso,

            $id

        );




        if ($stmt->execute()) {


            header(
                "Location: ../../formacao.php"
            );

            exit();



        } else {


            $erros[] = "Erro ao atualizar curso.";


        }



    }


}


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Editar Curso - 3R</title>


<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">


</head>


<body>


<div class="container mt-4" style="max-width:900px;">


<h2 class="mb-4">
Editar Curso
</h2>



<?php foreach($erros as $erro): ?>

<div class="alert alert-danger">

<?= htmlspecialchars($erro) ?>

</div>

<?php endforeach; ?>




<form method="POST" enctype="multipart/form-data">



<div class="mb-3">

<label class="form-label">
Nome do Curso
</label>


<input

type="text"

name="nome_curso"

class="form-control"

value="<?= htmlspecialchars($curso["nome_curso"]) ?>"

required>

</div>





<div class="mb-3">

<label class="form-label">
Área
</label>


<select name="area" class="form-control">


<option value="tecnologia"
<?= $curso["area"] == "tecnologia" ? "selected" : "" ?>>
Tecnologia
</option>


<option value="comercial"
<?= $curso["area"] == "comercial" ? "selected" : "" ?>>
Comercial
</option>


<option value="administrativo"
<?= $curso["area"] == "administrativo" ? "selected" : "" ?>>
Administrativo
</option>


<option value="idiomas"
<?= $curso["area"] == "idiomas" ? "selected" : "" ?>>
Idiomas
</option>


<option value="negocios"
<?= $curso["area"] == "negocios" ? "selected" : "" ?>>
Negócios
</option>


<option value="desenvolvimento"
<?= $curso["area"] == "desenvolvimento" ? "selected" : "" ?>>
Desenvolvimento Pessoal
</option>


<option value="operacional"
<?= $curso["area"] == "operacional" ? "selected" : "" ?>>
Operacional
</option>


</select>

</div>





<div class="mb-3">

<label class="form-label">
Carga Horária
</label>


<input

type="number"

name="carga_horaria"

class="form-control"

value="<?= htmlspecialchars($curso["carga_horaria"]) ?>"

required>

</div>





<div class="mb-3">

<label class="form-label">
Possui Certificado?
</label>


<select name="certificado" class="form-control">


<option value="Sim"
<?= $curso["certificado"] == "Sim" ? "selected" : "" ?>>
Sim
</option>


<option value="Não"
<?= $curso["certificado"] == "Não" ? "selected" : "" ?>>
Não
</option>


</select>


</div>





<div class="mb-3">

<label class="form-label">
Descrição
</label>


<textarea

name="descricao"

class="form-control"

rows="5"

required><?= htmlspecialchars($curso["descricao"]) ?></textarea>


</div>





<div class="mb-3">

<label class="form-label">
Conteúdo Programático
</label>


<textarea

name="conteudo_programatico"

class="form-control"

rows="5"><?= htmlspecialchars($curso["conteudo_programatico"]) ?></textarea>


</div>





<div class="mb-3">

<label class="form-label">
Link do Curso
</label>


<input

type="url"

name="url_curso"

class="form-control"

value="<?= htmlspecialchars($curso["url_curso"]) ?>"

required>


</div>





<p>

<strong>
Imagem Atual:
</strong>

</p>




<?php if(

    !empty($curso["img_curso"]) &&

    file_exists(

        __DIR__ .

        "/../../uploads/" .

        $curso["img_curso"]

    )

): ?>


<img

src="../../uploads/<?= htmlspecialchars($curso["img_curso"]) ?>"

width="180"

class="mb-3"

alt="Imagem do curso">



<?php else: ?>


<p>
Nenhuma imagem cadastrada.
</p>



<?php endif; ?>







<div class="mb-3">


<label class="form-label">

Trocar imagem

</label>



<input

type="file"

name="img_curso"

accept="image/png,image/jpeg,image/webp"

class="form-control">


</div>






<button

type="submit"

class="btn btn-success">

Salvar Alterações

</button>




<a

href="../../formacao.php"

class="btn btn-secondary">

Cancelar

</a>




</form>



</div>



</body>

</html>