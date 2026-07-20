document.addEventListener("DOMContentLoaded", function(){


/* ===========================
   FILTRO DE CURSOS
=========================== */

const botoesFiltro = document.querySelectorAll(".filtro-btn");
const cursos = document.querySelectorAll(".curso-item");


botoesFiltro.forEach(function(botao){

    botao.addEventListener("click", function(){

        let categoria = this.getAttribute("data-filtro");


        botoesFiltro.forEach(function(btn){
            btn.classList.remove("ativo");
        });


        this.classList.add("ativo");


        cursos.forEach(function(curso){

            let categoriaCurso = curso.getAttribute("data-categoria");


            if(categoria === "todos" || categoria === categoriaCurso){

                curso.style.display = "block";

            }else{

                curso.style.display = "none";

            }

        });

    });

});



/* ===========================
   MODAL CURSO
=========================== */

window.abrirModalCurso = function(nome, horas, descricao, link){


    document.getElementById("cursoTitulo").innerHTML = nome;

    document.getElementById("cursoHoras").innerHTML =
    '<i class="fa fa-clock-o"></i> ' + horas;


    document.getElementById("cursoDescricao").innerHTML =
    descricao;


    document.getElementById("cursoLink").href =
    link;


    document.getElementById("modalCurso").style.display = "flex";


}



window.fecharModalCurso = function(){


    document.getElementById("modalCurso").style.display = "none";


}



/* FECHAR CLICANDO FORA */

window.onclick = function(event){

    let modalCurso =
    document.getElementById("modalCurso");


    let modalCadastro =
    document.getElementById("modalCadastro");


    if(event.target == modalCurso){

        modalCurso.style.display="none";

    }


    if(event.target == modalCadastro){

        modalCadastro.style.display="none";

    }


}



/* ===========================
   MODAL ADMINISTRADOR
=========================== */


window.abrirModalCadastro = function(){

    document.getElementById("modalCadastro").style.display="flex";

}



window.fecharModalCadastro = function(){

    document.getElementById("modalCadastro").style.display="none";

}




/* ===========================
   PUBLICAR CURSO
=========================== */


window.publicarCurso = function(){


    let nome =
    document.getElementById("nomeCurso").value;


    let categoria =
    document.getElementById("categoriaCurso").value;


    let carga =
    document.getElementById("cargaCurso").value;


    let descricao =
    document.getElementById("descricaoCurso").value;



    if(nome === "" || carga === "" || descricao === ""){

        alert("Preencha todos os campos obrigatórios.");

        return;

    }



    let colunaCategoria =
    document.querySelector(
    '[data-categoria="' + categoria + '"]'
    );



    let novoCurso = document.createElement("div");

    novoCurso.className =
    "col-lg-4 col-md-6 curso-item";


    novoCurso.setAttribute(
    "data-categoria",
    categoria
    );



    novoCurso.innerHTML = `

    <div class="formacao-card">

        <img src="assets/img/blog/1.jpg" class="img-fluid">

        <div class="formacao-content">

            <span class="categoria">
                ${categoria}
            </span>

            <h2>
                ${nome}
            </h2>

            <p>
                ${descricao}
            </p>

            <div class="formacao-info">
                <i class="fa fa-clock-o"></i>
                ${carga}
            </div>


            <button class="formacao-btn"
            onclick="abrirModalCurso(
            '${nome}',
            '${carga}',
            '${descricao}',
            '#'
            )">

            Acessar Formação

            </button>


        </div>

    </div>

    `;



    document
    .getElementById("listaCursos")
    .appendChild(novoCurso);



    document.getElementById("modalCadastro").style.display="none";



    alert("Curso publicado com sucesso!");



    document.getElementById("nomeCurso").value="";
    document.getElementById("cargaCurso").value="";
    document.getElementById("descricaoCurso").value="";


}


});