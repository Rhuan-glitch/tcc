document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================================
       PERFIL EMPRESA - PLATAFORMA 3R
       JavaScript inicial do Front-End
       ===================================================================== */


    /* =====================================================================
       1. ABERTURA DOS MODAIS
       Compatível com o Bootstrap utilizado no projeto
       ===================================================================== */

    const botoesAbrirModal = document.querySelectorAll(
        '[data-toggle="modal"], [data-bs-toggle="modal"]'
    );


    botoesAbrirModal.forEach(function (botao) {

        botao.addEventListener('click', function (event) {

            event.preventDefault();


            const target =
                this.getAttribute('data-target') ||
                this.getAttribute('data-bs-target');


            if (!target) {
                return;
            }


            const modal =
                document.querySelector(target);


            if (!modal) {
                return;
            }


            if (
                window.jQuery &&
                typeof window.jQuery(modal).modal === 'function'
            ) {

                window.jQuery(modal).modal('show');

            }

            else {

                modal.classList.add('show');

                modal.style.display = 'block';

                document.body.classList.add('modal-open');


                if (!document.querySelector('.modal-backdrop')) {

                    const backdrop =
                        document.createElement('div');

                    backdrop.className =
                        'modal-backdrop fade show';

                    document.body.appendChild(backdrop);

                }

            }

        });

    });



    /* =====================================================================
       2. FECHAMENTO DOS MODAIS
       ===================================================================== */

    const botoesFecharModal =
        document.querySelectorAll(
            '[data-dismiss="modal"], [data-bs-dismiss="modal"]'
        );


    botoesFecharModal.forEach(function (botao) {

        botao.addEventListener('click', function () {

            const modal =
                this.closest('.modal');


            if (!modal) {
                return;
            }


            fecharModal(
                '#' + modal.id
            );

        });

    });



    /* =====================================================================
       3. FUNÇÃO DE FECHAMENTO
       ===================================================================== */

    function fecharModal(seletor) {

        const modal =
            document.querySelector(seletor);


        if (!modal) {
            return;
        }


        if (
            window.jQuery &&
            typeof window.jQuery(modal).modal === 'function'
        ) {

            window.jQuery(modal).modal('hide');

        }

        else {

            modal.classList.remove('show');

            modal.style.display = 'none';

            document.body.classList.remove(
                'modal-open'
            );


            const backdrop =
                document.querySelector(
                    '.modal-backdrop'
                );


            if (backdrop) {

                backdrop.remove();

            }

        }

    }



    /* =====================================================================
       4. PREVIEW DA LOGO
       ===================================================================== */

    const inputLogo =
        document.getElementById(
            'input-logo-arquivo'
        );


    const btnEscolherLogo =
        document.getElementById(
            'btn-escolher-logo'
        );


    const modalLogoPreview =
        document.getElementById(
            'modal-logo-preview'
        );


    const empresaLogoPreview =
        document.getElementById(
            'empresa-logo-preview'
        );


    if (
        btnEscolherLogo &&
        inputLogo
    ) {

        btnEscolherLogo.addEventListener(
            'click',
            function () {

                inputLogo.click();

            }
        );

    }


    if (inputLogo) {

        inputLogo.addEventListener(
            'change',
            function () {

                const arquivo =
                    this.files[0];


                if (!arquivo) {
                    return;
                }


                const url =
                    URL.createObjectURL(
                        arquivo
                    );


                if (modalLogoPreview) {

                    modalLogoPreview.src =
                        url;

                }


                if (empresaLogoPreview) {

                    empresaLogoPreview.src =
                        url;

                }

            }
        );

    }



    /* =====================================================================
       5. EDITAR PERFIL DA EMPRESA
       ===================================================================== */

    const formEditarEmpresa =
        document.getElementById(
            'formEditarEmpresa'
        );


    if (formEditarEmpresa) {

        formEditarEmpresa.addEventListener(
            'submit',
            function (event) {

                
            }
        );

    }



    /* =====================================================================
       6. FILTRO DE VAGAS
       ===================================================================== */

    const botoesFiltro =
        document.querySelectorAll(
            '.filtro-vaga'
        );


    const vagas =
        document.querySelectorAll(
            '.vaga-empresa-card'
        );


    botoesFiltro.forEach(function (botao) {

        botao.addEventListener(
            'click',
            function () {


                botoesFiltro.forEach(
                    function (item) {

                        item.classList.remove(
                            'active'
                        );

                    }
                );


                this.classList.add(
                    'active'
                );


                const filtro =
                    this.getAttribute(
                        'data-filtro'
                    );


                vagas.forEach(
                    function (vaga) {

                        const status =
                            vaga.getAttribute(
                                'data-status'
                            );


                        if (
                            filtro === 'todas' ||
                            filtro === status
                        ) {

                            vaga.style.display =
                                '';

                        }

                        else {

                            vaga.style.display =
                                'none';

                        }

                    }
                );

            }
        );

    });



    /* =====================================================================
       7. ABRIR MODAL DE EDITAR VAGA
       ===================================================================== */

    /* ============================================================
   PREENCHER OS CAMPOS DA VAGA
   ============================================================ */



const botoesEditarVaga =
    document.querySelectorAll(
        '.btn-editar-vaga'
    );


const tituloModalVaga =
    document.getElementById(
        'titulo-modal-vaga'
    );
const inputTituloVaga =
    document.getElementById(
        'input-titulo-vaga'
    );

const selectStatusVaga =
    document.getElementById(
        'select-status-vaga'
    );


const btnSalvarVaga =
    document.getElementById(
        'btn-salvar-vaga'
    );


let modoEdicaoVaga = false;
let idVagaEdicao = null;


botoesEditarVaga.forEach(function (botao) {

    botao.addEventListener(
        'click',
        function () {

            modoEdicaoVaga = true;


            /* =========================================================
               PEGA OS DADOS DA VAGA
               ========================================================= */

            idVagaEdicao =
                this.getAttribute(
                    'data-id'
                );
            const inputIdVaga =
                document.getElementById(
                'input-id-vaga'
            );
            if (inputIdVaga) {
                inputIdVaga.value =
                idVagaEdicao;
            }

            const nomeVaga =
                this.getAttribute(
                    'data-vaga'
                );
            const imagemVaga =
                this.getAttribute(
                    'data-img'
                );
            const imagemAtual =
                document.getElementById(
                    'imagem-atual-vaga'
                );

            const previewImagem =
                document.getElementById(
                    'preview-imagem-vaga'
                );

            if (imagemVaga) {

            previewImagem.src = '/tcc-1/' + imagemVaga;
            imagemAtual.style.display ='block';

            } else {
            previewImagem.src = '';
            imagemAtual.style.display ='none';
            }
            const area =
                this.getAttribute(
                    'data-area'
                );


            const cidade =
                this.getAttribute(
                    'data-cidade'
                );


            const tipoContrato =
                this.getAttribute(
                    'data-tipo-contrato'
                );


            const cargaHoraria =
                this.getAttribute(
                    'data-carga-horaria'
                );


            const faixaSalarial =
                this.getAttribute(
                    'data-faixa-salarial'
                );


            const status =
                this.getAttribute(
                    'data-status'
                );


            const descricao =
                this.getAttribute(
                    'data-descricao'
                );


            const requisitos =
                this.getAttribute(
                    'data-requisitos'
                );


            const beneficios =
                this.getAttribute(
                    'data-beneficios'
                );


            /* =========================================================
               ALTERA O TÍTULO DO MODAL
               ========================================================= */

            if (tituloModalVaga) {

                tituloModalVaga.innerHTML =
                    '<i class="fa fa-briefcase"></i> Editar Vaga';

            }


            /* =========================================================
               PREENCHER OS CAMPOS DA VAGA
               ========================================================= */

            const formVaga =
                document.getElementById(
                    'formNovaVaga'
                );
            if (formVaga) {
                formVaga.action = 'php/empresa/editar_vaga.php';
            }

            if (formVaga) {

                formVaga.elements['titulo_vaga'].value =
                    nomeVaga || '';


                formVaga.elements['area'].value =
                    area || '';


                formVaga.elements['cidade'].value =
                    cidade || '';


                formVaga.elements['tipo_contrato'].value =
                    tipoContrato || '';


                formVaga.elements['carga_horaria'].value =
                    cargaHoraria || '';


                formVaga.elements['faixa_salarial'].value =
                    faixaSalarial || '';


                formVaga.elements['descricao'].value =
                    descricao || '';


                formVaga.elements['requisitos'].value =
                    requisitos || '';


                formVaga.elements['beneficios'].value =
                    beneficios || '';

            }


            /* =========================================================
               CONVERTE O STATUS DO BANCO PARA O SELECT
               ========================================================= */

            if (selectStatusVaga) {

                if (status === 'Publicada') {

                    selectStatusVaga.value =
                        'ativa';

                } else if (
                    status === 'Aguardando Aprovação'
                ) {

                    selectStatusVaga.value =
                        'selecao';

                } else if (
                    status === 'Arquivada'
                ) {

                    selectStatusVaga.value =
                        'encerrada';

                }

            }


            /* =========================================================
               ALTERA O BOTÃO
               ========================================================= */

            if (btnSalvarVaga) {

                btnSalvarVaga.innerHTML =
                    '<i class="fa fa-save"></i> Salvar Alterações';

            }

        }
    );

});

 
    /* =====================================================================
       8. MODAL DE NOVA VAGA
       Quando aberto pelo botão "Nova Vaga", limpa o modo de edição.
       ===================================================================== */

    const btnNovaVaga =
        document.getElementById(
            'btn-nova-vaga'
        );


    const btnNovaVagaImpacto =
        document.querySelector(
            '.btn-impacto'
        );


    function prepararNovaVaga() {

        modoEdicaoVaga = false;


        if (tituloModalVaga) {

            tituloModalVaga.innerHTML =
                '<i class="fa fa-briefcase"></i> Nova Vaga';

        }


        if (inputTituloVaga) {

            inputTituloVaga.value =
                '';

        }


        if (selectStatusVaga) {

            selectStatusVaga.value =
                'ativa';

        }


        if (btnSalvarVaga) {

            btnSalvarVaga.innerHTML =
                '<i class="fa fa-plus"></i> Publicar Vaga';

        }

    }


    if (btnNovaVaga) {

        btnNovaVaga.addEventListener(
            'click',
            prepararNovaVaga
        );

    }


    if (btnNovaVagaImpacto) {

        btnNovaVagaImpacto.addEventListener(
            'click',
            prepararNovaVaga
        );

    }



    /* =====================================================================
   9. ABRIR CANDIDATURAS DA VAGA
   ===================================================================== */

const botoesCandidatos =
    document.querySelectorAll('.btn-candidatos');

const modalVagaNome =
    document.getElementById('modal-vaga-nome');

const listaCandidatos =
    document.getElementById('modal-lista-candidatos');


botoesCandidatos.forEach(function (botao) {

    botao.addEventListener('click', function () {

        const idVaga =
            this.getAttribute('data-id');

        const nomeVaga =
            this.getAttribute('data-vaga');


        /* NOME DA VAGA */

        if (modalVagaNome && nomeVaga) {
            modalVagaNome.textContent = nomeVaga;
        }


        /* ABRE O MODAL */

        const modal =
            document.getElementById('modalCandidaturas');

        if (!modal) {
            return;
        }


        if (
            window.jQuery &&
            typeof window.jQuery(modal).modal === 'function'
        ) {

            window.jQuery(modal).modal('show');

        } else {

            modal.classList.add('show');

            modal.style.display = 'block';

            document.body.classList.add('modal-open');

        }


        /* BUSCA AS CANDIDATURAS */

        if (!idVaga || !listaCandidatos) {
            return;
        }


        listaCandidatos.innerHTML = `
            <p style="text-align: center;">
                Carregando candidaturas...
            </p>
        `;


        fetch(
            'php/empresa/buscar_candidaturas.php?id_vaga='
            + encodeURIComponent(idVaga)
        )
            .then(function (resposta) {

                if (!resposta.ok) {
                    throw new Error(
                        'Erro ao buscar candidaturas.'
                    );
                }

                return resposta.json();

            })
            .then(function (candidaturas) {

                /* NENHUMA CANDIDATURA */

                if (candidaturas.length === 0) {

                    listaCandidatos.innerHTML = `
                        <p style="text-align: center;">
                            Ainda não há candidaturas para esta vaga.
                        </p>
                    `;

                    return;
                }


                /* CANDIDATURAS ENCONTRADAS */

                listaCandidatos.innerHTML = '';


                candidaturas.forEach(function (candidatura) {
                    let fotoCandidato = `
        <i class="fa fa-user"></i>
    `;

    if (candidatura.foto_perfil) {
        fotoCandidato = `
            <img
                src="/tcc-1/${candidatura.foto_perfil}"
                alt="Foto de ${candidatura.nome}"
                style="
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 50%;
                "
            >
        `;
    } 
                    const card =
                        document.createElement('article');

                    card.className =
                        'candidato-modal-card';


                    card.innerHTML = `
                        <div class="candidato-avatar candidato-avatar-large">
                            ${fotoCandidato}
                        </div>

                        <div class="candidato-modal-info">

                            <h3>
                                ${candidatura.nome}
                            </h3>

                            <p>
                                ${candidatura.area_interesse || 'Área não informada'}
                            </p>

                            <span class="status-candidatura recebido">
                                ${candidatura.status_candidatura}
                            </span>

                        </div>

                        <button
                            type="button"
                            class="btn-curriculo"
                            data-id-candidatura="${candidatura.id_candidatura}"
                        >
                            Ver currículo
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    `;


                    listaCandidatos.appendChild(card);

                });

            })
            .catch(function (erro) {

                console.error(erro);

                listaCandidatos.innerHTML = `
                    <p style="text-align: center;">
                        Não foi possível carregar as candidaturas.
                    </p>
                `;

            });

    });

});

    /* =====================================================================
       10. BOTÕES "VER CURRÍCULO"
       ===================================================================== */

    

const listaCandidatosCurriculo =
    document.getElementById(
        'modal-lista-candidatos'
    );


if (listaCandidatosCurriculo) {

    listaCandidatosCurriculo.addEventListener(
        'click',
        function (event) {

            const botao =
                event.target.closest(
                    '.btn-curriculo'
                );


            if (!botao) {
                return;
            }


            const idCandidatura =
                botao.getAttribute(
                    'data-id-candidatura'
                );


            if (!idCandidatura) {
                return;
            }


            window.location.href =
                'visualizar_curriculo.php?id_candidatura='
                + encodeURIComponent(idCandidatura);

        }
    );

}
/* =====================================================================
   11. BOTÕES DE CANDIDATO NA LISTA PRINCIPAL
   ===================================================================== */

const botoesVerCandidato =
    document.querySelectorAll(
        '.btn-ver-candidato'
    );


botoesVerCandidato.forEach(function (botao) {

    botao.addEventListener(
        'click',
        function () {

            const idVaga =
                this.getAttribute(
                    'data-id-vaga'
                );


            const modal =
                document.getElementById(
                    'modalCandidaturas'
                );


            if (!modal) {
                return;
            }


            /* =========================================================
               ABRE O MODAL
               ========================================================= */

            if (
                window.jQuery &&
                typeof window.jQuery(modal).modal === 'function'
            ) {

                window.jQuery(modal).modal(
                    'show'
                );

            } else {

                modal.classList.add('show');

                modal.style.display = 'block';

                document.body.classList.add(
                    'modal-open'
                );

            }


            /* =========================================================
               VERIFICA SE A VAGA FOI INFORMADA
               ========================================================= */

            if (!idVaga) {

                console.error(
                    'ID da vaga não encontrado.'
                );

                return;

            }


            /* =========================================================
               ELEMENTOS DO MODAL
               ========================================================= */

            const lista =
                document.getElementById(
                    'modal-lista-candidatos'
                );


            const nomeVaga =
                document.getElementById(
                    'modal-vaga-nome'
                );


            if (!lista) {
                return;
            }


            /* =========================================================
               MOSTRA CARREGANDO
               ========================================================= */

            lista.innerHTML = `
                <p style="text-align: center;">
                    Carregando candidaturas...
                </p>
            `;


            /* =========================================================
               BUSCA AS CANDIDATURAS DA VAGA
               ========================================================= */

            fetch(
                'php/empresa/buscar_candidaturas.php?id_vaga='
                + encodeURIComponent(idVaga)
            )
                .then(function (resposta) {

                    if (!resposta.ok) {

                        throw new Error(
                            'Erro ao buscar candidaturas.'
                        );

                    }

                    return resposta.json();

                })

                .then(function (candidaturas) {


                    /* =================================================
                       NOME DA VAGA
                       ================================================= */

                    if (
                        candidaturas.length > 0 &&
                        nomeVaga
                    ) {

                        nomeVaga.textContent =
                            candidaturas[0].titulo_vaga;

                    }


                    /* =================================================
                       NENHUMA CANDIDATURA
                       ================================================= */

                    if (
                        candidaturas.length === 0
                    ) {

                        lista.innerHTML = `
                            <p style="text-align: center;">
                                Ainda não há candidaturas para esta vaga.
                            </p>
                        `;

                        return;

                    }


                    /* =================================================
                       LIMPA A LISTA
                       ================================================= */

                    lista.innerHTML = '';


                    /* =================================================
                       MONTA OS CANDIDATOS
                       ================================================= */

                    candidaturas.forEach(
                        function (candidatura) {


                            /* =========================================
                               FOTO DO CANDIDATO
                               ========================================= */

                            let fotoCandidato = `
                                <i class="fa fa-user"></i>
                            `;


                            if (
                                candidatura.foto_perfil
                            ) {

                                fotoCandidato = `
                                    <img
                                        src="/tcc-1/${candidatura.foto_perfil}"
                                        alt="Foto de ${candidatura.nome}"
                                        style="
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                            border-radius: 50%;
                                        "
                                    >
                                `;

                            }


                            /* =========================================
                               CRIA O CARD
                               ========================================= */

                            const card =
                                document.createElement(
                                    'article'
                                );


                            card.className =
                                'candidato-modal-card';


                            card.innerHTML = `

                                <div class="candidato-avatar candidato-avatar-large">

                                    ${fotoCandidato}

                                </div>


                                <div class="candidato-modal-info">

                                    <h3>
                                        ${candidatura.nome}
                                    </h3>


                                    <p>
                                        ${candidatura.area_interesse || 'Área não informada'}
                                    </p>


                                    <span class="status-candidatura recebido">

                                        ${candidatura.status_candidatura}

                                    </span>

                                </div>


                                <button
                                    type="button"
                                    class="btn-curriculo"
                                    data-id-candidatura="${candidatura.id_candidatura}"
                                >

                                    Ver currículo

                                    <i class="fa fa-arrow-right"></i>

                                </button>

                            `;


                            lista.appendChild(
                                card
                            );

                        }
                    );

                })

                .catch(function (erro) {

                    console.error(
                        erro
                    );


                    lista.innerHTML = `
                        <p style="text-align: center;">
                            Não foi possível carregar as candidaturas.
                        </p>
                    `;

                });

        }
    );

});


    
    /* =====================================================================
   12. FORMULÁRIO DA VAGA
   ===================================================================== */

    const formNovaVaga =
        document.getElementById(
            'formNovaVaga'
        );
    /* =====================================================================
       13. ESC PARA FECHAR MODAL
       ===================================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key !== 'Escape'
            ) {
                return;
            }


            const modalAberto =
                document.querySelector(
                    '.modal.show'
                );


            if (
                modalAberto &&
                modalAberto.id
            ) {

                fecharModal(
                    '#' + modalAberto.id
                );

            }

        }
    );

});