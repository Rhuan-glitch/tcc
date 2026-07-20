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

// Lógica de envio do Login
const formLogin = document.getElementById("loginForm");

if (formLogin) {
    formLogin.addEventListener("submit", function(e) {
        e.preventDefault(); // Impede a página de recarregar
        
        const email = document.getElementById("inputEmailLogin").value.trim();
        const senha = document.getElementById("inputSenhaLogin").value;

        // Aqui vai entrar a lógica futura de enviar para o Back-end
        // Por enquanto, vamos simular que deu certo e redirecionar:
        if(email !== "" && senha !== "") {
            console.log("Login feito com sucesso!");
            // window.location.href = "painel_usuario.html"; // Redireciona o usuário
        }
    });
}