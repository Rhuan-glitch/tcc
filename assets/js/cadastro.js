// Perfil
function selectUserType(type){
    const cardEgresso=document.getElementById("cardEgresso");
    const cardEmpresa=document.getElementById("cardEmpresa");
    const labelNome=document.getElementById("labelNome");
    const inputNome=document.getElementById("inputNome");
    const labelDocumento=document.getElementById("labelDocumento");
    const inputDocumento=document.getElementById("inputDocumento");

    if(type==="egresso"){
        cardEgresso.classList.add("active");
        cardEmpresa.classList.remove("active");
        labelNome.innerText="Nome Completo";
        inputNome.placeholder="Digite seu nome completo";
        labelDocumento.innerText="CPF";
        inputDocumento.placeholder="000.000.000-00";
        inputDocumento.value="";
    }else{
        cardEmpresa.classList.add("active");
        cardEgresso.classList.remove("active");
        labelNome.innerText="Razão Social";
        inputNome.placeholder="Digite a razão social";
        labelDocumento.innerText="CNPJ";
        inputDocumento.placeholder="00.000.000/0000-00";
        inputDocumento.value="";
    }
}

// Instanciando Campos
const campoDocumento = document.getElementById("inputDocumento");
const campoTelefone = document.getElementById("inputTelefone");
const campoEmail = document.getElementById("inputEmail");
const campoSenha = document.getElementById("inputSenha");
const campoConfirmarSenha = document.getElementById("inputConfirmarSenha");
const barraSenha = document.getElementById("passwordBar");
const textoSenha = document.getElementById("passwordText");
const formCadastro = document.getElementById("cadastroForm");
const modalMensagem = document.getElementById("modalMensagem");
const textoMensagem = document.getElementById("textoMensagem");
const btnFecharModal = document.getElementById("btnFecharModal");
const modalProgressBar = document.getElementById("modalProgressBar");

// Máscaras
function mascaraCPF(valor){
    valor=valor.replace(/\D/g,"");
    valor=valor.replace(/(\d{3})(\d)/,"$1.$2");
    valor=valor.replace(/(\d{3})(\d)/,"$1.$2");
    valor=valor.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
    return valor;
}

function mascaraCNPJ(valor){
    valor=valor.replace(/\D/g,"");
    valor=valor.replace(/^(\d{2})(\d)/,"$1.$2");
    valor=valor.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3");
    valor=valor.replace(/\.(\d{3})(\d)/,".$1/$2");
    valor=valor.replace(/(\d{4})(\d)/,"$1-$2");
    return valor;
}

function mascaraTelefone(valor){
    valor=valor.replace(/\D/g,"");
    valor=valor.replace(/^(\d{2})(\d)/,"($1) $2");
    valor=valor.replace(/(\d)(\d{4})$/,"$1-$2");
    return valor;
}

// Eventos de Máscara
campoDocumento.addEventListener("input",function(){
    const tipo=document.querySelector('input[name="tipoUsuario"]:checked').value;
    this.value=tipo==="egresso" ? mascaraCPF(this.value) : mascaraCNPJ(this.value);
});

campoTelefone.addEventListener("input",function(){
    this.value=mascaraTelefone(this.value);
});

campoDocumento.addEventListener("keypress",function(e){
    if(!/[0-9]/.test(e.key)) e.preventDefault();
});

campoTelefone.addEventListener("keypress",function(e){
    if(!/[0-9]/.test(e.key)) e.preventDefault();
});

// Validar E-mail
function validarEmail(email){
    const regex=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

campoEmail.addEventListener("blur",function(){
    if(validarEmail(this.value)){
        this.style.borderColor="#28a745";
    }else{
        this.style.borderColor="#dc3545";
    }
});

// Força da senha (A BARRINHA VOLTA A FUNCIONAR AQUI)
campoSenha.addEventListener("input",function(){
    const senha=this.value;
    let nivel=0;

    if(senha.length>=8) nivel++;
    if(/[A-Z]/.test(senha)) nivel++;
    if(/[a-z]/.test(senha)) nivel++;
    if(/[0-9]/.test(senha)) nivel++;
    if(/[!@#$%^&*(),.?":{}|<>]/.test(senha)) nivel++;

    if(senha.length===0){
        barraSenha.style.width="0%";
        textoSenha.innerHTML="";
        return;
    }

    if(nivel<=2){
        barraSenha.style.width="33%";
        barraSenha.style.background="#dc3545";
        textoSenha.innerHTML="Senha fraca";
        textoSenha.style.color="#dc3545";
    }else if(nivel<=4){
        barraSenha.style.width="66%";
        barraSenha.style.background="#ffc107";
        textoSenha.innerHTML="Senha média";
        textoSenha.style.color="#ffc107";
    }else{
        barraSenha.style.width="100%";
        barraSenha.style.background="#28a745";
        textoSenha.innerHTML="Senha forte";
        textoSenha.style.color="#28a745";
    }
});

// Confirmar senha
campoConfirmarSenha.addEventListener("input",function(){
    if(this.value===""){
        this.style.borderColor="";
        return;
    }
    if(this.value===campoSenha.value){
        this.style.borderColor="#28a745";
    }else{
        this.style.borderColor="#dc3545";
    }
});

// Mostrar e ocultar senha
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

// Envio do formulário (UNIFICADO COM VALIDAÇÕES E MODAL)
formCadastro.addEventListener("submit",function(e){
    e.preventDefault();

    const tipo=document.querySelector('input[name="tipoUsuario"]:checked').value;
    const documento=campoDocumento.value.replace(/\D/g,"");
    const telefone=campoTelefone.value.replace(/\D/g,"");
    const email=campoEmail.value.trim();
    const senha=campoSenha.value;
    const confirmar=campoConfirmarSenha.value;

    // Validações
    if(tipo==="egresso" && documento.length!==11){
        alert("Digite um CPF válido.");
        campoDocumento.focus();
        return;
    }
    if(tipo==="empresa" && documento.length!==14){
        alert("Digite um CNPJ válido.");
        campoDocumento.focus();
        return;
    }
    if(!validarEmail(email)){
        alert("Digite um e-mail válido.");
        campoEmail.focus();
        return;
    }
    if(telefone.length<10 || telefone.length>11){
        alert("Digite um telefone válido.");
        campoTelefone.focus();
        return;
    }
    
    const senhaValida = senha.length >= 8 && /[A-Z]/.test(senha) && /[0-9]/.test(senha) && /[!@#$%^&*(),.?":{}|<>]/.test(senha);
    if(!senhaValida){
        alert("A senha deve possuir no mínimo 8 caracteres, uma letra maiúscula, um número e um caractere especial.");
        campoSenha.focus();
        return;
    }

    if(senha!==confirmar){
        alert("As senhas não coincidem.");
        campoConfirmarSenha.focus();
        return;
    }

    // Passou por tudo, prepara a mensagem e exibe o modal
    if(tipo==="egresso"){
        textoMensagem.innerText = "Seja bem-vindo ao Projeto 3R! Estamos felizes em ter você aqui para recomeçar e conquistar novas oportunidades.";
    }else{
        textoMensagem.innerText = "Bem-vinda, Empresa Parceira! Juntos vamos promover a reinserção social através de oportunidades reais de trabalho.";
    }

    // Mostra Modal
    modalMensagem.style.display="flex";

    // Dispara a animação da barra de progresso no modal
    setTimeout(() => {
        if(modalProgressBar) modalProgressBar.style.width = "100%";
    }, 100);
});

// Lógica do botão "Fechar" para ir para a próxima página
if (btnFecharModal) {
    btnFecharModal.addEventListener("click", function() {
        modalMensagem.style.display = "none";
        // Altere o link abaixo para o nome real do seu próximo arquivo HTML
        window.location.href = "proxima_pagina.html"; 
    });
}

