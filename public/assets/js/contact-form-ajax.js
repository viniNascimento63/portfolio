document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("contact-form").addEventListener("submit", async function (e) {
        e.preventDefault(); // impede o reload da página
        const form = e.target;
        const dados = new FormData(form); // pega os campos do form
        const saidaContainer = document.getElementById("resContainer");
        const saida = document.getElementById("resultado");
        try {
            const resposta = await fetch("/contact", {method: "POST", body: dados});
            const json = await resposta.text();
            saidaContainer.target.classList.add('alert-success');
            saida.innerText = json.msg;
        } catch (erro) {
            saidaContainer.target.classList.add('alert-danger');
            saida.innerText = "Falha de comunicação com o servidor.";
        }
    });
});