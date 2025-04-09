document.getElementById("formCriarContMateria").addEventListener("submit", async function (event) {
    event.preventDefault();
    
    const formData = new FormData();

    const idMateria_contMateria = document.getElementById("materia_ContMateria").value;
    const titulo_contMateria = document.getElementById("titulo_Cont_materia").value;
    const conteudo_contMateria = document.getElementById("txt_cont_materia").value;
    const imagem_contMateria = document.getElementById("ContMateria_img").files[0];

    if (!idMateria_contMateria || !titulo_contMateria || !conteudo_contMateria) {
        alert("Preencha todos os campos!");
        return;
    } 
    // console.log("O script de criação de notícia carregou corretamente!");

    formData.append("Conteudo_titulo", titulo_contMateria);
    formData.append("Conteudo_img", imagem_contMateria);
    formData.append("Conteudo_cont", conteudo_contMateria);
    formData.append("Conteudo_tipo", "2");
    formData.append("Usuarios_idUsuarios", "5");
    formData.append("Materia_idMateria", idMateria_contMateria);
    
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
