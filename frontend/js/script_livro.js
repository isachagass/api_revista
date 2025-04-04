document.getElementById("formCriarLivro").addEventListener("submit", async function(event) {
        event.preventDefault();
    
        const formData = new FormData();
        const titulo = document.getElementById("Catalogo_titulo").value;
        const sinopse = document.getElementById("Catalogo_sinopse").value;
        const imagem = document.getElementById("Catalogo_img").files[0];
       
        // const userId = 2;

    
        if(!titulo || !sinopse || !imagem){
            alert("Preencha todos os campos!");
            return;
        }
        
  
        formData.append("Catalogo_titulo", titulo);
        formData.append("Catalogo_sinopse", sinopse);
        formData.append("Catalogo_img", imagem);
        formData.append("usuarios_idUsuarios", "5");

        console.log("Enviando:", [...formData.entries()]);
        

        try{
            const resposta = await fetch("http://localhost/api_php/backend/endpoint/Post/catalogo_post.php", {
                method: "POST",
                body: formData
            });

            const respostaTexto = await resposta.text();
            console.log("Resposta da API:", respostaTexto);


            let result;

            try {
                result = JSON.parse(respostaTexto);

            }catch (erroJson){
                console.log("Erro ao converter resposta Json", respostaTexto)
                alert("Erro na resposta da API!");
                return;

            }

            if (result.status === "success") {
                alert("Livro cadastrado com sucesso!");
                document.getElementById("formCriarLivro").reset();
            } else{
                alert("Erro ao cadastrar livro!" , result.message || "");
            }

        }
        catch(erro){
            console.log("Erro ao conectar API", erro);
            alert("Erro ao conecar API!");
        }

    });