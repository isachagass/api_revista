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

