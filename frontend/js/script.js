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
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").addEventListener("submit", async function(event){
        event.preventDefault();

        const email = document.getElementById("Usuario_email").value.trim();
        const senha = document.getElementById("Usuario_senha").value.trim();
        const mensagem = document.getElementById("mensagem");

        if (!email || !senha) {
            mensagem.textContent = "Preencha todos os campos!";
            mensagem.style.color = "red";
            return;
        }

        const dados_login = {
            Usuario_email: email,
            Usuario_senha: senha
        };

        console.log("Enviando para API:", dados_login); // VERIFICA SE OS DADOS ESTÃO SENDO ENVIADOS

        try {
            const resposta = await fetch("http://localhost/api_php/backend/login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(dados_login)
            });

            const resultado = await resposta.json();
            console.log("Resposta da API:", resultado); // Debug da resposta

            if (resultado.status === "success") {
                alert("Login realizado com sucesso!");
                localStorage.setItem("usuario", JSON.stringify(resultado.usuario));
                window.location.href = "teste.html";
            } else {
                mensagem.textContent = resultado.mensagem;
                mensagem.style.color = "red";
            }
        }
        catch (erro) {
            console.error("Erro ao conectar à API:", erro);
            mensagem.textContent = "Erro ao conectar à API";
            mensagem.style.color = "red";
        }
    });
});
