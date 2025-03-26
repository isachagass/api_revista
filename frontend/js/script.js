// cadastrar -> conexao com api
document.getElementById("cadastroForm").addEventListener("submit", async function(event) {
    event.preventDefault();

    const nome = document.getElementById("Usuario_nome").value;
    const email = document.getElementById("Usuario_email").value;
    const senha = document.getElementById("Usuario_senha").value;

    const dados = {
        Usuario_nome: nome,
        Usuario_email: email,
        Usuario_senha: senha

    };

    try{
        const resposta = await fetch("http://localhost/api_php/backend/endpoint/Post/user_post.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }, 
            body: JSON.stringify(dados)
        });
    
        const resultado = await resposta.json();
    
        if (resultado.status === 'success'){
            alert("Usuário cadastrado com sucesso!");
            document.getElementById("cadastroForm").reset();
        } else{
            alert("Erro ao cadastrar usuário! Tente novamente");
        }

    }
    catch (erro){
        console.error("Erro ao conectar a API:", erro);
        alert("Erro ao conectar a API!!");
    }
    

});

//login ->conexão com api
document.getElementById("loginForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    const email = document.getElementById("Login_email").value;
    const senha = document.getElementById("Login_senha").value;

    try {
        const response = await fetch("http://localhost/api_php/backend/endpoint/Post/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ Usuario_email: email, Usuario_senha: senha })
        });

        if (!response.ok) {
            throw new Error("Erro na resposta da API");
        }

        const result = await response.json();

        // Verifique o campo 'status' da resposta
        if (result.status === 'success') {
            alert(`✅ Bem-vindo, ${result.usuario.nome}!`);
            // Aqui você pode redirecionar para outra página ou salvar o usuário na sessão/localStorage
            window.location.href = "dashboard.html"; // Exemplo de redirecionamento
        } else {
            alert(`❌ Erro: ${result.mensagem || result.message}`);
        }
    } catch (error) {
        console.error(error);
        alert("Erro ao conectar com o servidor");
    }
});




//livro -> conexão com api
// document.getElementById("formCriarLivro").addEventListener("submit", async function(event) {
//     event.preventDefault();

//     const titulo = document.getElementById("titulo_livro").value;
//     const sinopse = document.getElementById("sinopse_livro").value;
    

//     const dados = {
//         Catalogo_titulo: titulo,
//         Catalogo_sinopse: sinopse,
        

//     };

//     try{
//         const resposta = await fetch("http://localhost/api_php/backend/endpoint/Post/catalogo_post.php", {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/json"
//             }, 
//             body: JSON.stringify(dados)
//         });
    
//         const resultado = await resposta.json();
    
//         if (resultado.status === 'success'){
//             alert("Livro cadastrado com sucesso!");
//             document.getElementById("formCriarLivro").reset();
//         } else{
//             alert("Erro ao cadastrar Livro! Tente novamente");
//         }

//     }
//     catch (erro){
//         console.error("Erro ao conectar a API:", erro);
//         alert("Erro ao conectar a API!!");
//     }
    

// });