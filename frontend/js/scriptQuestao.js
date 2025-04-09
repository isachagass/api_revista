document.getElementById("formCriarQuestao").addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData();
    const idMateria_questao = document.getElementById("materia_questao").value;

    const tema_questao = document.getElementById("tema_questao");
    const titulo_questao = tema_questao.options[tema_questao.selectedIndex].text;
    
    const conteudo_questao = document.getElementById("txt_questao").value;
    const explicacao_questao = document.getElementById("explicacao_questao").value;
    const img_questao = document.getElementById("img_questao").files[0];

    if (!idMateria_questao || !titulo_questao || !conteudo_questao || !explicacao_questao) {
        alert("Preencha todos os campos!");
        return;
    }

    formData.append("Atividade_titulo", titulo_questao);
    formData.append("Atividade_cont", conteudo_questao);
    formData.append("Atividade_exp", explicacao_questao);
    formData.append("Atividade_img", img_questao);
    formData.append("Matéria_idMatéria", idMateria_questao);
    formData.append("Usuarios_idUsuarios", '5');
    

    console.log("Enviando dados:", [...formData.entries()]);
    
    try {
        const resposta = await fetch("http://localhost/api_php/backend/endpoint/Post/atividade_post.php", {
            method: "POST",
            body: formData
        });

        const respostaTexto = await resposta.text(); 
        console.log("Resposta da API:", respostaTexto);

        // Verifica se a resposta pode ser convertida para JSON
        let result;
        try {
            result = JSON.parse(respostaTexto);
        } catch (erroJson) {
            console.error("Erro ao converter resposta JSON:", respostaTexto);
            alert("Erro na resposta da API!");
            return;
        }

        if (result.status === 'success') {
            alert("Questão cadastrada com sucesso!");
            document.getElementById("formCriarQuestao").reset();
        } else {
            alert("Erro ao cadastrar a questão! " + (result.message || ""));
        }

    } catch (erro) {
        console.error("Erro ao conectar a API:", erro);
        alert("Erro ao conectar à API!!");
    }
});
