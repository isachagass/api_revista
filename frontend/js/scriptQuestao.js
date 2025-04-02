document.getElementById("formCriarQuestao").addEventListener("submit", async function (event) {
    event.preventDefault();

    
    const idMateria_questao = document.getElementById("materia_questao").value;
    const titulo_questao = document.getElementById("tema_questao").value;
    const conteudo_questao = document.getElementById("txt_questao").value;
    const explicacao_questao = document.getElementById("explicacao_questao").value;

    if (!idMateria_questao || !titulo_questao || !conteudo_questao || !explicacao_questao) {
        alert("Preencha todos os campos!");
        return;
    }

    const dados = {
        Atividade_titulo: titulo_questao,
        Atividade_cont: conteudo_questao,
        Atividade_exp: explicacao_questao,
        Atividade_img: null,
        Matéria_idMatéria: idMateria_questao,
        Usuarios_idUsuarios: 6
    };

    console.log("Enviando dados:", JSON.stringify(dados));
    //console.log("Enviando dados:", JSON.stringify(dados)); // Verificar no console do navegador

    try {
        const resposta = await fetch("http://localhost/api_php/backend/endpoint/Post/atividade_post.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(dados)
        });

        const respostaTexto = await resposta.text(); // Pega a resposta como texto para depuração
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
