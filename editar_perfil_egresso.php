<?php

require_once __DIR__ . "/php/config/config.php";

exigirLogin();
exigirPerfil('egresso');

$cpf = $_SESSION["cpf"];

$stmt = $conn->prepare("
    SELECT cpf, nome, data_nascimento, email, telefone, cidade, area_interesse
    FROM egresso
    WHERE cpf = ?
");

$stmt->bind_param("s", $cpf);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    die("Egresso não encontrado.");
}

$egresso = $resultado->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Perfil - Plataforma 3R</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<section class="section-padding">
    <div class="container">

        <div class="section-title text-center">
            <h2>Editar Perfil</h2>
            <p>Atualize suas informações pessoais.</p>
        </div>

        <div class="perfil-card">

            <form action="php/egresso/atualizar_perfil.php" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Nome</label>
                    <input 
                        type="text" 
                        name="nome" 
                        class="form-control"
                        value="<?= htmlspecialchars($egresso['nome']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>CPF</label>
                    <input 
                        type="text" 
                        class="form-control"
                        value="<?= htmlspecialchars($egresso['cpf']) ?>"
                        disabled
                    >
                </div>
                <div class="form-group">
                    <label>Foto de Perfil</label>
                    <input 
                    type="file" 
                    name="foto_perfil" 
                    class="form-control"
                    accept=".jpg,.jpeg,.png">
                    <small class="form-text text-muted"> Formatos permitidos: JPG, JPEG e PNG.</small>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control"
                        value="<?= htmlspecialchars($egresso['email']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Telefone</label>
                    <input 
                        type="text" 
                        name="telefone" 
                        class="form-control"
                        value="<?= htmlspecialchars($egresso['telefone']) ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Data de Nascimento</label>
                    <input 
                        type="date" 
                        name="data_nascimento" 
                        class="form-control"
                        value="<?= htmlspecialchars($egresso['data_nascimento']) ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Cidade</label>
                    <input 
                        type="text" 
                        name="cidade" 
                        class="form-control"
                        value="<?= htmlspecialchars($egresso['cidade']) ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Área de Interesse</label>

                    <select name="area_interesse" class="form-control">

                        <option value="Tecnologia"
                            <?= $egresso['area_interesse'] === 'Tecnologia' ? 'selected' : '' ?>>
                            Tecnologia
                        </option>

                        <option value="Administrativo"
                            <?= $egresso['area_interesse'] === 'Administrativo' ? 'selected' : '' ?>>
                            Administrativo
                        </option>

                        <option value="Logística"
                            <?= $egresso['area_interesse'] === 'Logística' ? 'selected' : '' ?>>
                            Logística
                        </option>

                        <option value="Comercial"
                            <?= $egresso['area_interesse'] === 'Comercial' ? 'selected' : '' ?>>
                            Comercial
                        </option>

                        <option value="Atendimento"
                            <?= $egresso['area_interesse'] === 'Atendimento' ? 'selected' : '' ?>>
                            Atendimento
                        </option>

                        <option value="Operacional"
                            <?= $egresso['area_interesse'] === 'Operacional' ? 'selected' : '' ?>>
                            Operacional
                        </option>

                    </select>
                </div>

                <div class="mt-4">

                    <button type="submit" class="btn-atualizar">
                        Salvar Alterações
                    </button>

                    <a href="perfil_egresso.php" class="btn-editar-perfil">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>
</section>

</body>
</html>