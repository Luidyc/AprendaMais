async function pesquisarDisciplina() {
    var disciplina_id = document.getElementById("iddisciplina").value;
    console.log(disciplina_id);

    var data = await fetch("pesquisardisciplina.php?iddisciplina="+disciplina_id);

    var response = await data.json();
    console.log(response);
}