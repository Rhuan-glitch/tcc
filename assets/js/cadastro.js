// =========================================================
// 1. TROCA DE PERFIL (Egresso x Empresa)
// =========================================================
function selectUserType(type){
    const cardEgresso = document.getElementById("cardEgresso");
    const cardEmpresa = document.getElementById("cardEmpresa");
    const labelNome = document.getElementById("labelNome");
    const inputNome = document.getElementById("inputNome");
    const labelDocumento = document.getElementById("labelDocumento");
    const inputDocumento = document.getElementById("inputDocumento");

    // Seções exclusivas
    const grupoDataNascimento = document.getElementById("grupoDataNascimento");
    const grupoCidadeEgresso = document.getElementById("grupoCidadeEgresso");
    const grupoEnderecoEmpresa = document.getElementById("grupoEnderecoEmpresa");

    if(type === "egresso"){
        cardEgresso.classList.add("active");
        cardEmpresa.classList.remove("active");
        
        labelNome.innerText = "Nome Completo *";
        inputNome.placeholder = "Digite seu nome completo";
        
        labelDocumento.innerText = "CPF *";
        inputDocumento.placeholder = "000.000.000-00";
        inputDocumento.value = "";

        // MOSTRA elementos do Egresso e ESCONDE endereço da Empresa
        if(grupoDataNascimento) grupoDataNascimento.style.display = "block";
        if(grupoCidadeEgresso) grupoCidadeEgresso.style.display = "block";
        if(grupoEnderecoEmpresa) grupoEnderecoEmpresa.style.display = "none";

    } else {
        cardEmpresa.classList.add("active");
        cardEgresso.classList.remove("active");
        
        labelNome.innerText = "Razão Social *";
        inputNome.placeholder = "Digite a razão social";
        
        labelDocumento.innerText = "CNPJ *";
        inputDocumento.placeholder = "00.000.000/0000-00";
        inputDocumento.value = "";

        // ESCONDE elementos do Egresso e MOSTRA endereço da Empresa
        if(grupoDataNascimento) grupoDataNascimento.style.display = "none";
        if(grupoCidadeEgresso) grupoCidadeEgresso.style.display = "none";
        if(grupoEnderecoEmpresa) grupoEnderecoEmpresa.style.display = "block";
    }
}

// =========================================================
// 2. ELEMENTOS DO FORMULÁRIO
// =========================================================
const campoNome = document.getElementById("inputNome");
const campoDocumento = document.getElementById("inputDocumento");
const campoDataNascimento = document.getElementById("inputDataNascimento");
const campoEmail = document.getElementById("inputEmail");
const campoTelefone = document.getElementById("inputTelefone");
const campoCidadeEgresso = document.getElementById("inputCidadeEgresso");

// Campos Empresa
const campoCep = document.getElementById("inputCep");
const campoRua = document.getElementById("inputRua");
const campoBairro = document.getElementById("inputBairro");
const campoCidadeEmpresa = document.getElementById("inputCidade");
const campoNumero = document.getElementById("inputNumero");
const campoComplemento = document.getElementById("inputComplemento");

// Campos Senha
const campoSenha = document.getElementById("inputSenha");
const campoConfirmarSenha = document.getElementById("inputConfirmarSenha");
const barraSenha = document.getElementById("passwordBar");
const textoSenha = document.getElementById("passwordText");

// Form e Modal
const formCadastro = document.getElementById("cadastroForm");
const modalMensagem = document.getElementById("modalMensagem");
const textoMensagem = document.getElementById("textoMensagem");
const btnFecharModal = document.getElementById("btnFecharModal");
const modalProgressBar = document.getElementById("modalProgressBar");

// =========================================================
// 3. MÁSCARAS
// =========================================================
function mascaraCPF(valor){
    valor = valor.replace(/\D/g, "");
    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return valor;
}

function mascaraCNPJ(valor){
    valor = valor.replace(/\D/g, "");
    valor = valor.replace(/^(\d{2})(\d)/, "$1.$2");
    valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    valor = valor.replace(/\.(\d{3})(\d)/, ".$1/$2");
    valor = valor.replace(/(\d{4})(\d)/, "$1-$2");
    return valor;
}

function mascaraTelefone(valor){
    valor = valor.replace(/\D/g, "");
    valor = valor.replace(/^(\d{2})(\d)/, "($1) $2");
    valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
    return valor;
}

function mascaraCEP(valor){
    valor = valor.replace(/\D/g, "");
    valor = valor.replace(/^(\d{5})(\d)/, "$1-$2");
    return valor;
}

// =========================================================
// 4. API DE CEP
// =========================================================
function buscarCEP(){
    if(!campoCep) return;
    const cep = campoCep.value.replace(/\D/g, "");

    if(cep.length === 8){
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if(!data.erro){
                    if(campoRua) campoRua.value = data.logradouro;
                    if(campoBairro) campoBairro.value = data.bairro;
                    if(campoCidadeEmpresa) campoCidadeEmpresa.value = `${data.localidade} - ${data.uf}`;
                    if(campoNumero) campoNumero.focus();
                } else {
                    alert("CEP não encontrado. Por favor, digite o endereço manualmente.");
                }
            })
            .catch(error => {
                console.error("Erro ao consultar CEP:", error);
            });
    }
}

// =========================================================
// 5. EVENTOS DE DIGITAÇÃO E MÁSCARAS
// =========================================================
if(campoDocumento){
    campoDocumento.addEventListener("input", function(){
        const tipo = document.querySelector('input[name="tipoUsuario"]:checked').value;
        this.value = tipo === "egresso" ? mascaraCPF(this.value) : mascaraCNPJ(this.value);
    });

    campoDocumento.addEventListener("keypress", function(e){
        if(!/[0-9]/.test(e.key)) e.preventDefault();
    });
}

if(campoTelefone){
    campoTelefone.addEventListener("input", function(){
        this.value = mascaraTelefone(this.value);
    });

    campoTelefone.addEventListener("keypress", function(e){
        if(!/[0-9]/.test(e.key)) e.preventDefault();
    });
}

if(campoCep){
    campoCep.addEventListener("input", function(){
        this.value = mascaraCEP(this.value);
    });

    campoCep.addEventListener("blur", function(){
        buscarCEP();
    });
}

// =========================================================
// 6. VALIDAÇÕES E FORÇA DA SENHA
// =========================================================
function validarEmail(email){
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

if(campoEmail){
    campoEmail.addEventListener("blur", function(){
        this.style.borderColor = validarEmail(this.value) ? "#28a745" : "#dc3545";
    });
}

if(campoSenha){
    campoSenha.addEventListener("input", function(){
        const senha = this.value;
        let nivel = 0;

        if(senha.length >= 8) nivel++;
        if(/[A-Z]/.test(senha)) nivel++;
        if(/[a-z]/.test(senha)) nivel++;
        if(/[0-9]/.test(senha)) nivel++;
        if(/[!@#$%^&*(),.?":{}|<>]/.test(senha)) nivel++;

        if(senha.length === 0){
            barraSenha.style.width = "0%";
            textoSenha.innerHTML = "";
            return;
        }

        if(nivel <= 2){
            barraSenha.style.width = "33%";
            barraSenha.style.background = "#dc3545";
            textoSenha.innerHTML = "Senha fraca";
            textoSenha.style.color = "#dc3545";
        } else if(nivel <= 4){
            barraSenha.style.width = "66%";
            barraSenha.style.background = "#ffc107";
            textoSenha.innerHTML = "Senha média";
            textoSenha.style.color = "#ffc107";
        } else {
            barraSenha.style.width = "100%";
            barraSenha.style.background = "#28a745";
            textoSenha.innerHTML = "Senha forte";
            textoSenha.style.color = "#28a745";
        }
    });
}

if(campoConfirmarSenha){
    campoConfirmarSenha.addEventListener("input", function(){
        if(this.value === ""){
            this.style.borderColor = "";
            return;
        }
        this.style.borderColor = (this.value === campoSenha.value) ? "#28a745" : "#dc3545";
    });
}

function mostrarSenha(inputId, spanElement) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        spanElement.innerText = "Ocultar";
    } else {
        input.type = "password";
        spanElement.innerText = "Mostrar";
    }
}

// =========================================================
// 7. VALIDAÇÃO RIGOROSA E ENVIO
// =========================================================
if(formCadastro){
    formCadastro.addEventListener("submit", function(e){
        

        const tipo = document.querySelector('input[name="tipoUsuario"]:checked').value;
        const nome = campoNome ? campoNome.value.trim() : "";
        const documento = campoDocumento ? campoDocumento.value.replace(/\D/g, "") : "";
        const email = campoEmail ? campoEmail.value.trim() : "";
        const telefone = campoTelefone ? campoTelefone.value.replace(/\D/g, "") : "";
        const senha = campoSenha ? campoSenha.value : "";
        const confirmar = campoConfirmarSenha ? campoConfirmarSenha.value : "";

        // 1. Validação de Nome / Razão Social
        if(nome === ""){
            alert(tipo === "egresso" ? "Por favor, digite seu Nome Completo." : "Por favor, digite a Razão Social da empresa.");
            campoNome.focus();
            return;
        }

        // 2. Validações do Egresso
        if(tipo === "egresso"){
            if(documento.length !== 11){
                alert("Por favor, digite um CPF válido.");
                campoDocumento.focus();
                return;
            }
            if(campoDataNascimento && campoDataNascimento.value === ""){
                alert("Por favor, informe sua Data de Nascimento.");
                campoDataNascimento.focus();
                return;
            }
            if(campoCidadeEgresso && campoCidadeEgresso.value.trim() === ""){
                alert("Por favor, digite sua Cidade / Estado.");
                campoCidadeEgresso.focus();
                return;
            }
        }

        // 3. Validações da Empresa
        if(tipo === "empresa"){
            if(documento.length !== 14){
                alert("Por favor, digite um CNPJ válido.");
                campoDocumento.focus();
                return;
            }
            const cepLimpo = campoCep ? campoCep.value.replace(/\D/g, "") : "";
            if(cepLimpo.length !== 8){
                alert("Por favor, digite um CEP válido com 8 números.");
                campoCep.focus();
                return;
            }
            if(campoRua && campoRua.value.trim() === ""){
                alert("Por favor, informe a Rua / Logradouro da empresa.");
                campoRua.focus();
                return;
            }
            if(campoBairro && campoBairro.value.trim() === ""){
                alert("Por favor, informe o Bairro da empresa.");
                campoBairro.focus();
                return;
            }
            if(campoCidadeEmpresa && campoCidadeEmpresa.value.trim() === ""){
                alert("Por favor, informe a Cidade / Estado da empresa.");
                campoCidadeEmpresa.focus();
                return;
            }
            if(campoNumero && campoNumero.value.trim() === ""){
                alert("Por favor, informe o Número do endereço da empresa.");
                campoNumero.focus();
                return;
            }
            if(campoComplemento && campoComplemento.value.trim() === ""){
                alert("Por favor, informe o Complemento (Apto, Sala, Galpão, Bloco).");
                campoComplemento.focus();
                return;
            }
        }

        // 4. Validações Comuns (Email e Telefone)
        if(!validarEmail(email)){
            alert("Por favor, digite um e-mail válido.");
            campoEmail.focus();
            return;
        }

        if(telefone.length < 10 || telefone.length > 11){
            alert("Por favor, digite um telefone válido com DDD.");
            campoTelefone.focus();
            return;
        }
        
        // 5. Validação da Senha
        const senhaValida = senha.length >= 8 && /[A-Z]/.test(senha) && /[0-9]/.test(senha) && /[!@#$%^&*(),.?":{}|<>]/.test(senha);
        if(!senhaValida){
            alert("A senha deve ter no mínimo 8 caracteres, uma letra maiúscula, um número e um caractere especial.");
            campoSenha.focus();
            return;
        }

        if(senha !== confirmar){
            alert("As senhas não coincidem. Digite novamente.");
            campoConfirmarSenha.focus();
            return;
        }

       // // Tudo OK -> Exibe o Modal
        if(tipo === "egresso"){
            textoMensagem.innerText = "Seja bem-vindo ao Projeto 3R! Estamos felizes em ter você aqui para recomeçar e conquistar novas oportunidades.";
        } else {
            textoMensagem.innerText = "Bem-vinda, Empresa Parceira! Juntos vamos promover a reinserção social através de oportunidades reais de trabalho.";
        }

        modalMensagem.style.display = "flex";

        setTimeout(() => {
            if(modalProgressBar) modalProgressBar.style.width = "100%";
        }, 100);
    });
}

// Fechar Modal
if(btnFecharModal){
    btnFecharModal.addEventListener("click", function(){
        modalMensagem.style.display = "none";
        formCadastro.submit(); 
    });
}

// Inicia com Egresso selecionado
document.addEventListener("DOMContentLoaded", function(){
    selectUserType("egresso");
});