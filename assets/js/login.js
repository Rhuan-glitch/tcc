// Função para Mostrar/Ocultar a Senha (pode reaproveitar se já estiver em um JS global)
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