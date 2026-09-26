/* ==========================================================================
   FUNÇÕES EXCLUSIVAS - PÁGINA TRABALHISTA (VAGAS)
   ========================================================================== */

let vagaSendoEditada = null; // Variável para controlar se estamos editando um card

document.addEventListener("DOMContentLoaded", function() {
    // 1. Oculta modais ao carregar
    document.getElementById('modalVaga').style.display = 'none';
    document.getElementById('modalPublicar').style.display = 'none';

    // 2. Lógica de Filtro
    const filtroCidade = document.getElementById('filtroCidade');
    const filtroSalario = document.getElementById('filtroSalario');
    const filtroFuncao = document.getElementById('filtroFuncao');

    function filtrarVagas() {
        const valCidade = filtroCidade.value;
        const valSalario = filtroSalario.value;
        const valFuncao = filtroFuncao.value;

        const vagas = document.querySelectorAll('.vaga-item');

        vagas.forEach(vaga => {
            const cidadeCard = vaga.getAttribute('data-cidade');
            const salarioCard = vaga.getAttribute('data-salario');
            const funcaoCard = vaga.getAttribute('data-funcao');

            const matchCidade = (valCidade === "Todas" || valCidade === cidadeCard);
            const matchSalario = (valSalario === "Todos" || valSalario === salarioCard);
            const matchFuncao = (valFuncao === "Todas" || valFuncao === funcaoCard);

            if (matchCidade && matchSalario && matchFuncao) {
                vaga.style.display = 'block';
            } else {
                vaga.style.display = 'none';
            }
        });
    }

    filtroCidade.addEventListener('change', filtrarVagas);
    filtroSalario.addEventListener('change', filtrarVagas);
    filtroFuncao.addEventListener('change', filtrarVagas);

    // // 3. Submissão do Formulário de Vaga
    // document.getElementById('formVaga').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     processarSalvamentoVaga();
    // });
});

/* --- MODAL DETALHES --- */
function abrirModalDetalhes(btn) {
    const card = btn.closest('.vaga-item');
    const idVaga = card.getAttribute('data-id');
    document.getElementById('modalIdVaga').value = idVaga;
    // Puxa os dados do HTML do card clicado
    const titulo = card.querySelector('.vaga-titulo').innerText;
    const empresa = card.querySelector('.empresa-nome').innerText;
    const cidade = card.querySelector('.vaga-cidade').innerText;
    const regime = card.querySelector('.vaga-regime').innerText;
    const salario = card.querySelector('.vaga-valor').innerText;
    const desc = card.querySelector('.vaga-desc').innerText;
    const srcLogo = card.querySelector('.logo-vaga').src;
    
    const reqStr = card.querySelector('.requisitos-hidden').innerText;
    const benStr = card.querySelector('.beneficios-hidden').innerText;

    // Injeta no modal
    document.getElementById('modalVagaTitulo').innerText = titulo;
    document.getElementById('modalVagaEmpresa').innerText = empresa;
    document.getElementById('modalVagaLocal').innerText = cidade;
    document.getElementById('modalVagaRegime').innerText = regime;
    document.getElementById('modalVagaSalario').innerText = salario;
    document.getElementById('modalVagaDescricao').innerText = desc;
    
    const logoModal = document.getElementById('modalVagaLogo');
    if (srcLogo) {
        logoModal.src = srcLogo;
        logoModal.style.display = 'inline-block';
    } else {
        logoModal.style.display = 'none';
    }

    // Converte textos separados por vírgula em listas (<li>)
    document.getElementById('modalVagaRequisitos').innerHTML = reqStr.split(',').map(item => `<li>${item.trim()}</li>`).join('');
    document.getElementById('modalVagaBeneficios').innerHTML = benStr.split(',').map(item => `<li>${item.trim()}</li>`).join('');

    document.getElementById('modalVaga').style.display = 'flex';
}

function fecharModalVaga() {
    document.getElementById('modalVaga').style.display = 'none';
}

/* --- MODAL PUBLICAR / EDITAR --- */
function abrirModalPublicar() {
    vagaSendoEditada = null; // Zera a referência
    document.getElementById('tituloModalForm').innerText = "Publicar Nova Vaga";
    document.getElementById('btnSalvarVaga').innerText = "Publicar Vaga";
    document.getElementById('formVaga').reset(); // Limpa form
    document.getElementById('formVaga').action = 'php/empresa/create_vaga.php';
    document.getElementById('formIdVaga').value = '';
    document.getElementById('modalPublicar').style.display = 'flex';
}

function fecharModalPublicar() {
    document.getElementById('modalPublicar').style.display = 'none';
}



/* --- EDITAR VAGA --- */
function editarVaga(btn) {
    const card = btn.closest('.vaga-item');

    // Pega o ID da vaga
    const idVaga = card.getAttribute('data-id');

    // Guarda o ID no formulário
    document.getElementById('formIdVaga').value = idVaga;

    // Muda o título e o botão do modal
    document.getElementById('tituloModalForm').innerText = "Editar Vaga";
    document.getElementById('btnSalvarVaga').innerText = "Salvar Alterações";

    // Preenche o formulário com os dados da vaga
    document.getElementById('formTitulo').value =
        card.querySelector('.vaga-titulo').innerText;

    document.getElementById('formEmpresa').value =
        card.querySelector('.empresa-nome').innerText;

    document.getElementById('formCategoria').value =
        card.getAttribute('data-funcao');

    document.getElementById('formCidade').value =
        card.getAttribute('data-cidade');

    document.getElementById('formRegime').value =
        card.querySelector('.vaga-regime').innerText;

    document.getElementById('formSalarioFiltro').value =
        card.getAttribute('data-salario');

    document.getElementById('formDescricao').value =
        card.querySelector('.vaga-desc').innerText;

    document.getElementById('formRequisitos').value =
        card.querySelector('.requisitos-hidden').innerText;

    document.getElementById('formBeneficios').value =
        card.querySelector('.beneficios-hidden').innerText;

    document.getElementById('formVaga').action = 'php/empresa/editar_vaga.php';
    // Abre o modal
    document.getElementById('modalPublicar').style.display = 'flex';
}
/* --- EXCLUIR VAGA --- */
function excluirVaga(btn) {

    const card = btn.closest('.vaga-item');

    // Pega o ID da vaga
    const idVaga = card.getAttribute('data-id');

    if (!idVaga) {
        alert("Não foi possível identificar a vaga.");
        return;
    }

    // Confirmação antes de excluir
    const confirmar = confirm(
        "Tem certeza que deseja excluir esta vaga?"
    );

    if (!confirmar) {
        return;
    }

    // Cria um formulário para enviar o ID via POST
    const form = document.createElement('form');

    form.method = 'POST';
    form.action = 'php/empresa/excluir_vaga.php';

    const input = document.createElement('input');

    input.type = 'hidden';
    input.name = 'id_vaga';
    input.value = idVaga;

    form.appendChild(input);

    document.body.appendChild(form);

    form.submit();
}
/* --- PROCESSA A IMAGEM ANTES DE SALVAR --- */


/* --- SALVA OS DADOS NA TELA --- */

        
        // Adiciona a nova vaga no início da lista


    fecharModalPublicar();
