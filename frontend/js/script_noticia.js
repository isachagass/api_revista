document.getElementById("formCriarNoticia").addEventListener("submit", async function (event) {
    event.preventDefault();

    const idMateria_noticia = document.getElementById("materia_noticia").value;
    const titulo_noticia = document.getElementById("titulo_noticia").value;
    const conteudo_noticia = document.getElementById("txt_noticia").value;

    if (!idMateria_noticia || !titulo_noticia || !conteudo_noticia) {
        alert("Preencha todos os campos!");
        return;
    }

    const dados = {
        Conteudo_titulo: titulo_noticia,
        Conteudo_img: null,
        Conteudo_cont: conteudo_noticia,
        Conteudo_tipo: "1",
        Usuarios_idUsuarios: 6,
        Materia_idMateria: idMateria_noticia
    };

    //console.log("Enviando dados:", JSON.stringify(dados)); // Verificar no console do navegador

    try {
        const resposta = await fetch("http://localhost/api_php/backend/endpoint/Post/conteudo_post.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(dados)
        });

        const respostaTexto = await resposta.text(); // Pega a resposta como texto para depuração
        //console.log("Resposta da API:", respostaTexto);

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
            alert("Notícia cadastrada com sucesso!");
            document.getElementById("formCriarNoticia").reset();
        } else {
            alert("Erro ao cadastrar a notícia! " + (result.message || ""));
        }

    } catch (erro) {
        console.error("Erro ao conectar a API:", erro);
        alert("Erro ao conectar à API!!");
    }
});
