document.getElementById("formCriarNoticia").addEventListener("submit", async function (event) {
    event.preventDefault();
    // console.log("Script carregado!");

    const formData = new FormData();
    const idMateria_noticia = document.getElementById("materia_noticia").value;
    const titulo_noticia = document.getElementById("titulo_noticia").value;
    const conteudo_noticia = document.getElementById("txt_noticia").value;
    const img_noticia = document.getElementById("img_noticia").files[0];

    if (!idMateria_noticia || !titulo_noticia || !conteudo_noticia || !img_noticia) {
        alert("Preencha todos os campos!");
        return;
    } 
    // console.log("O script de criação de notícia carregou corretamente!");

    formData.append("Conteudo_titulo", titulo_noticia);
    formData.append("Conteudo_img", img_noticia);
    formData.append("Conteudo_cont", conteudo_noticia);
    formData.append("Conteudo_tipo", "2");
    formData.append("Usuarios_idUsuarios", "5");
    formData.append("Materia_idMateria", idMateria_noticia);

    console.log("Enviando:", [...formData.entries()]);

    try {
        const resposta = await fetch("http://localhost/api_php/backend/endpoint/Post/conteudo_post.php", {
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
