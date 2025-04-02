document.getElementById("loginForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    const nome = document.getElementById("Login_nome").value;
    const senha = document.getElementById("Login_senha").value;
    const mensagem_p = document.getElementById("loginResponse");

    try {
        const response = await fetch("http://localhost/api_php/backend/endpoint/Post/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ Usuario_nome: nome, Usuario_senha: senha })
        });

        const result = await response.json(); // Convertendo a resposta para JSON

        if (result.status === "success") {

            alert("Login realizado com sucesso!");

            const nivel_user = result.nivel;

            switch(nivel_user){
                case '1':
                    window.location.href = "nivel1.html";
                    break;
                case '2':
                    window.location.href = "nivel2.html";
                    break;
                case '3':
                    window.location.href = "nivel3.html";
                    break;
            }

            
            //window.location.href = "teste.html"; // Redirecionamento
        } else {
            mensagem_p.innerText = result.message || "Usuário ou senha incorretos.";
        }
    } catch (error) {
        mensagem_p.innerText = "Erro ao conectar com o servidor.";
        console.error(error);
    }
});
