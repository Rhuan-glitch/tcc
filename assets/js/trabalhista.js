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

    // 3. Submissão do Formulário de Vaga
    document.getElementById('formVaga').addEventListener('submit', function(e) {
        e.preventDefault();
        processarSalvamentoVaga();
    });
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

/* --- EXCLUIR VAGA COM AVISO --- */
function excluirVaga(btn) {
    // Pergunta ao usuário antes de deletar
    const confirmacao = confirm("Você tem certeza que deseja excluir esta vaga? Esta ação não pode ser desfeita.");
    
    if (confirmacao) {
        const card = btn.closest('.vaga-item');
        card.remove(); // Remove o elemento do HTML se a pessoa clicar em "OK"
    }
}

/* --- EDITAR VAGA --- */
function editarVaga(btn) {
    const card = btn.closest('.vaga-item');
    vagaSendoEditada = card; // Guarda qual card estamos editando

    document.getElementById('tituloModalForm').innerText = "Editar Vaga";
    document.getElementById('btnSalvarVaga').innerText = "Salvar Alterações";
    document.getElementById('formVaga').reset();

    // Preenche o formulário com os dados do card
    document.getElementById('formTitulo').value = card.querySelector('.vaga-titulo').innerText;
    document.getElementById('formEmpresa').value = card.querySelector('.empresa-nome').innerText;
    document.getElementById('formCategoria').value = card.getAttribute('data-funcao');
    document.getElementById('formCidade').value = card.getAttribute('data-cidade');
    document.getElementById('formRegime').value = card.querySelector('.vaga-regime').innerText;
    document.getElementById('formSalarioValor').value = card.querySelector('.vaga-valor').innerText;
    document.getElementById('formSalarioFiltro').value = card.getAttribute('data-salario');
    document.getElementById('formDescricao').value = card.querySelector('.vaga-desc').innerText;
    document.getElementById('formRequisitos').value = card.querySelector('.requisitos-hidden').innerText;
    document.getElementById('formBeneficios').value = card.querySelector('.beneficios-hidden').innerText;
    
    // Obs: O input file de imagem não pode ser pré-preenchido por questões de segurança dos navegadores.
    // Se o usuário não colocar nova imagem, manteremos a antiga.

    document.getElementById('modalPublicar').style.display = 'flex';
}

/* --- PROCESSA A IMAGEM ANTES DE SALVAR --- */
function processarSalvamentoVaga() {
    const inputLogo = document.getElementById('formLogo');
    
    // Se o usuário anexou uma imagem nova
    if (inputLogo.files && inputLogo.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const logoBase64 = e.target.result;
            salvarVagaNaTela(logoBase64); // Salva enviando a imagem
        }
        reader.readAsDataURL(inputLogo.files[0]);
    } else {
        // Se não anexou imagem, pega uma padrão ou a antiga (se estiver editando)
        let logoPadrao = "https://via.placeholder.com/80?text=Logo";
        if (vagaSendoEditada) {
            logoPadrao = vagaSendoEditada.querySelector('.logo-vaga').src;
        }
        salvarVagaNaTela(logoPadrao);
    }
}

/* --- SALVA OS DADOS NA TELA --- */
function salvarVagaNaTela(srcDaLogo) {
    // Pega valores do form
    const titulo = document.getElementById('formTitulo').value;
    const empresa = document.getElementById('formEmpresa').value;
    const categoria = document.getElementById('formCategoria').value;
    const cidade = document.getElementById('formCidade').value;
    const regime = document.getElementById('formRegime').value;
    const salarioValor = document.getElementById('formSalarioValor').value;
    const salarioFiltro = document.getElementById('formSalarioFiltro').value;
    const descricao = document.getElementById('formDescricao').value;
    const requisitos = document.getElementById('formRequisitos').value;
    const beneficios = document.getElementById('formBeneficios').value;

    if (vagaSendoEditada) {
        // ATUALIZA O CARD EXISTENTE
        vagaSendoEditada.setAttribute('data-cidade', cidade);
        vagaSendoEditada.setAttribute('data-salario', salarioFiltro);
        vagaSendoEditada.setAttribute('data-funcao', categoria);

        vagaSendoEditada.querySelector('.vaga-titulo').innerText = titulo;
        vagaSendoEditada.querySelector('.empresa-nome').innerText = empresa;
        vagaSendoEditada.querySelector('.vaga-cidade').innerText = cidade;
        vagaSendoEditada.querySelector('.vaga-regime').innerText = regime;
        vagaSendoEditada.querySelector('.vaga-valor').innerText = salarioValor;
        vagaSendoEditada.querySelector('.vaga-desc').innerText = descricao;
        vagaSendoEditada.querySelector('.requisitos-hidden').innerText = requisitos;
        vagaSendoEditada.querySelector('.beneficios-hidden').innerText = beneficios;
        vagaSendoEditada.querySelector('.logo-vaga').src = srcDaLogo;

    } else {
        // CRIA UM NOVO CARD
        const lista = document.getElementById('listaOportunidades');
        
        const htmlNovoCard = `
        <div class="col-lg-6 col-md-12 vaga-item" data-cidade="${cidade}" data-salario="${salarioFiltro}" data-funcao="${categoria}">
            <div class="vaga-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="vaga-titulo">${titulo}</h3>
                        <p class="empresa-nome">${empresa}</p>
                    </div>
                    <img src="${srcDaLogo}" alt="Logo Empresa" class="logo-vaga">
                </div>
                
                <div class="vaga-info mt-3">
                    <p>Local: <span class="vaga-cidade">${cidade}</span></p>
                    <p>Regime: <span class="vaga-regime">${regime}</span></p>
                    <p>Salário: <strong class="vaga-valor">${salarioValor}</strong></p>
                </div>

                <p class="vaga-desc">${descricao}</p>
                
                <div class="d-none requisitos-hidden">${requisitos}</div>
                <div class="d-none beneficios-hidden">${beneficios}</div>
                
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button class="btn-detalhes" onclick="abrirModalDetalhes(this)">Ver Detalhes</button>
                    <div class="vaga-acoes">
                        <button class="text-edit btn-acao" onclick="editarVaga(this)">EDITAR</button>
                        <button class="text-delete btn-acao" onclick="excluirVaga(this)">EXCLUIR</button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Adiciona a nova vaga no início da lista
        lista.insertAdjacentHTML('afterbegin', htmlNovoCard);
    }

    fecharModalPublicar();
}