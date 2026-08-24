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
    document.getElementById('modalPublicar').style.display = 'flex';
}

function fecharModalPublicar() {
    document.getElementById('modalPublicar').style.display = 'none';
}



/* --- EDITAR VAGA --- */

/* --- PROCESSA A IMAGEM ANTES DE SALVAR --- */


/* --- SALVA OS DADOS NA TELA --- */

        
        // Adiciona a nova vaga no início da lista


    fecharModalPublicar();
