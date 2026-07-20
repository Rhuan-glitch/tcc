//========================================================
// PERFIL DO EGRESSO - PARTE 1
//========================================================

// Seleção da Área de Interesse

const interesseCards = document.querySelectorAll(".interesse-card");

interesseCards.forEach(card => {
	card.addEventListener("click", () => {

		interesseCards.forEach(item => {
			item.classList.remove("active");
		});

		card.classList.add("active");

	});
});

//========================================================
// BOTÃO EDITAR PERFIL
//========================================================

const btnEditarPerfil = document.querySelector(".btn-editar-perfil");

if(btnEditarPerfil){

	btnEditarPerfil.addEventListener("click", () => {

		alert("Abrir modal de edição do perfil.");

	});

}

//========================================================
// BOTÃO ATUALIZAR INFORMAÇÕES
//========================================================

const btnAtualizar = document.querySelector(".btn-atualizar");

if(btnAtualizar){

	btnAtualizar.addEventListener("click", () => {

		alert("Informações atualizadas com sucesso!");

	});

}
//========================================================
// PERFIL DO EGRESSO - PARTE 2
//========================================================

// Barra de Progresso da Trilha

const cursos = document.querySelectorAll(".curso-card");
const barra = document.querySelector(".barra-preenchida");
const textoProgresso = document.querySelector(".progresso-texto");

atualizarProgresso();

cursos.forEach(curso => {

	curso.addEventListener("click", () => {

		curso.classList.toggle("concluido");

		const icone = curso.querySelector(".curso-icon i");

		if(curso.classList.contains("concluido")){
			icone.classList.remove("fa-circle-o");
			icone.classList.add("fa-check-circle");
		}else{
			icone.classList.remove("fa-check-circle");
			icone.classList.add("fa-circle-o");
		}

		atualizarProgresso();

	});

});

function atualizarProgresso(){

	const total = cursos.length;
	const concluidos = document.querySelectorAll(".curso-card.concluido").length;

	const porcentagem = Math.round((concluidos / total) * 100);

	if(barra){
		barra.style.width = porcentagem + "%";
	}

	if(textoProgresso){
		textoProgresso.innerHTML = porcentagem + "% Concluído";
	}

}

//========================================================
// CURRÍCULO
//========================================================

const botoesCurriculo = document.querySelectorAll(".btn-curriculo");

botoesCurriculo.forEach(botao => {

	botao.addEventListener("click", () => {

		alert("Função disponível quando o sistema estiver conectado ao banco de dados.");

	});

});

//========================================================
// PERFIL DO EGRESSO - PARTE 3
//========================================================

// Hover nos cards de candidatura

const candidaturas = document.querySelectorAll(".candidatura-item");

candidaturas.forEach(candidatura => {

	candidatura.addEventListener("mouseenter", () => {

		candidatura.style.transition = ".3s";
		candidatura.style.transform = "translateX(8px)";

	});

	candidatura.addEventListener("mouseleave", () => {

		candidatura.style.transform = "translateX(0px)";

	});

});

//========================================================
// Hover nos cards de desempenho

const desempenho = document.querySelectorAll(".desempenho-item");

desempenho.forEach(item => {

	item.addEventListener("mouseenter", () => {

		item.style.transition = ".3s";
		item.style.transform = "scale(1.02)";

	});

	item.addEventListener("mouseleave", () => {

		item.style.transform = "scale(1)";

	});

});