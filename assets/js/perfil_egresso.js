document.addEventListener('DOMContentLoaded', function() {

    // 1. GARANTIA DE ABERTURA DOS MODAIS (Compatível com BS3, BS4 e BS5)
    const botoesAbrirModal = document.querySelectorAll('[data-toggle="modal"], [data-bs-toggle="modal"]');
    
    botoesAbrirModal.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target') || this.getAttribute('data-bs-target');
            const modal = document.querySelector(targetId);
            
            if (modal) {
                if (window.jQuery && typeof $(modal).modal === 'function') {
                    $(modal).modal('show');
                } else {
                    modal.classList.add('show');
                    modal.style.display = 'block';
                    document.body.classList.add('modal-open');
                    
                    if (!document.querySelector('.modal-backdrop')) {
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                }
            }
        });
    });

    // 2. GARANTIA DE FECHAMENTO DOS MODAIS
    const botoesFecharModal = document.querySelectorAll('[data-dismiss="modal"], [data-bs-dismiss="modal"]');
    
    botoesFecharModal.forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                if (window.jQuery && typeof $(modal).modal === 'function') {
                    $(modal).modal('hide');
                } else {
                    modal.classList.remove('show');
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            }
        });
    });

    // 3. CLIQUES NO TABULEIRO DE APRENDIZAGEM (Redirecionamento para formacao.html)
    const casasTabuleiro = document.querySelectorAll('.casa-node');
    const boxDetalhes = document.getElementById('casa-detalhe-card');
    const tituloDetalhe = document.getElementById('casa-detalhe-titulo');
    const descDetalhe = document.getElementById('casa-detalhe-desc');
    const btnAcaoCasa = document.getElementById('btn-acao-casa');

    casasTabuleiro.forEach(casa => {
        casa.addEventListener('click', function() {
            const titulo = this.getAttribute('data-titulo');
            const desc = this.getAttribute('data-desc');
            const status = this.getAttribute('data-status');

            if (boxDetalhes && tituloDetalhe && descDetalhe && btnAcaoCasa) {
                tituloDetalhe.textContent = titulo;
                descDetalhe.textContent = desc;
                boxDetalhes.classList.remove('d-none');

                if (status === 'bloqueado') {
                    btnAcaoCasa.textContent = 'Módulo Bloqueado';
                    btnAcaoCasa.classList.add('disabled');
                    btnAcaoCasa.removeAttribute('href');
                } else {
                    btnAcaoCasa.textContent = 'Acessar Curso';
                    btnAcaoCasa.classList.remove('disabled');
                    btnAcaoCasa.setAttribute('href', 'formacao.html');
                }
            }
        });
    });

    // 4. SELETOR DE AVATAR DO TABULEIRO
    const botoesAvatar = document.querySelectorAll('.btn-avatar');
    const pinoJogador = document.getElementById('pino-jogador-trilha');

    if (botoesAvatar.length > 0 && pinoJogador) {
        botoesAvatar.forEach(botao => {
            botao.addEventListener('click', function() {
                botoesAvatar.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const novoIcone = this.getAttribute('data-icone');
                pinoJogador.className = 'fa ' + novoIcone + ' pino-icon';
            });
        });
    }

    // 5. ATUALIZAR ÁREA NA TRILHA
    const selectArea = document.getElementById('select-area-interesse');
    const labelAreaTrilha = document.getElementById('trilha-area-nome');

    if (selectArea && labelAreaTrilha) {
        selectArea.addEventListener('change', function() {
            labelAreaTrilha.textContent = this.options[this.selectedIndex].text;
        });
    }
});