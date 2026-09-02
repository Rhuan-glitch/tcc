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

                event.preventDefault();


                const inputRazaoSocial =
                    document.getElementById(
                        'input-razao-social'
                    );


                const displayRazaoSocial =
                    document.getElementById(
                        'display-razao-social'
                    );


                if (
                    inputRazaoSocial &&
                    displayRazaoSocial &&
                    inputRazaoSocial.value.trim() !== ''
                ) {

                    displayRazaoSocial.textContent =
                        inputRazaoSocial.value.trim();

                }


                /*
                    FUTURO BACK-END

                    O formulário poderá enviar os campos
                    diretamente para o PHP responsável por
                    atualizar a tabela "empresa".

                    Nenhum banco é alterado pelo JavaScript
                    nesta versão.
                */


                fecharModal(
                    '#modalEditarEmpresa'
                );

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


    botoesEditarVaga.forEach(function (botao) {

        botao.addEventListener(
            'click',
            function () {

                modoEdicaoVaga = true;


                const nomeVaga =
                    this.getAttribute(
                        'data-vaga'
                    );


                if (
                    tituloModalVaga &&
                    nomeVaga
                ) {

                    tituloModalVaga.innerHTML =
                        '<i class="fa fa-briefcase"></i> Editar Vaga';

                }


                if (
                    inputTituloVaga &&
                    nomeVaga
                ) {

                    inputTituloVaga.value =
                        nomeVaga;

                }


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
        document.querySelectorAll(
            '.btn-candidatos'
        );


    const modalVagaNome =
        document.getElementById(
            'modal-vaga-nome'
        );


    botoesCandidatos.forEach(function (botao) {

        botao.addEventListener(
            'click',
            function () {

                const nomeVaga =
                    this.getAttribute(
                        'data-vaga'
                    );


                if (
                    modalVagaNome &&
                    nomeVaga
                ) {

                    modalVagaNome.textContent =
                        nomeVaga;

                }


                const modal =
                    document.getElementById(
                        'modalCandidaturas'
                    );


                if (!modal) {
                    return;
                }


                if (
                    window.jQuery &&
                    typeof window.jQuery(modal).modal === 'function'
                ) {

                    window.jQuery(modal).modal(
                        'show'
                    );

                }

                else {

                    modal.classList.add('show');

                    modal.style.display =
                        'block';

                    document.body.classList.add(
                        'modal-open'
                    );

                }

            }
        );

    });



    /* =====================================================================
       10. BOTÕES "VER CURRÍCULO"
       ===================================================================== */

    const botoesCurriculo =
        document.querySelectorAll(
            '.btn-curriculo'
        );


    botoesCurriculo.forEach(function (botao) {

        botao.addEventListener(
            'click',
            function () {

                alert(
                    'Aqui será aberto o currículo do egresso. ' +
                    'A integração com os dados do currículo será feita pelo Back-End.'
                );

            }
        );

    });



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

                const modal =
                    document.getElementById(
                        'modalCandidaturas'
                    );


                if (!modal) {
                    return;
                }


                if (
                    window.jQuery &&
                    typeof window.jQuery(modal).modal === 'function'
                ) {

                    window.jQuery(modal).modal(
                        'show'
                    );

                }

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


    if (formNovaVaga) {

        formNovaVaga.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                /*
                    FUTURO BACK-END

                    O formulário deverá enviar para o PHP:

                    titulo_vaga
                    area
                    cidade
                    descricao
                    requisitos
                    beneficios
                    carga_horaria
                    faixa_salarial
                    tipo_contrato
                    img_vaga
                    status

                    Esses campos correspondem aos atributos
                    existentes na tabela "vaga".
                */


                const mensagem =
                    modoEdicaoVaga
                        ? 'A interface de edição da vaga está funcionando. O salvamento real será conectado ao Back-End.'
                        : 'A interface de publicação da vaga está funcionando. O cadastro real será conectado ao Back-End.';


                alert(mensagem);


                fecharModal(
                    '#modalNovaVaga'
                );

            }
        );

    }



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