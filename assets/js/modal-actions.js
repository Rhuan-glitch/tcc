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





    document.getElementById("modalCadastro").style.display="none";



    alert("Curso publicado com sucesso!");



    document.getElementById("nomeCurso").value="";
    document.getElementById("cargaCurso").value="";
    document.getElementById("descricaoCurso").value="";


}


);