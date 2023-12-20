<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $email = $_POST["email"];
    $cep = $_POST["cep"];
    $senha = $_POST["senha"];
    $confirmar_senha = $_POST["confirmar_senha"];

    // Validações simples (adapte conforme suas necessidades)
    if ($senha != $confirmar_senha) {
        echo "As senhas não coincidem. Por favor, tente novamente.";
        exit;
    }

    // Aqui você deve substituir pelos detalhes da sua conexão com o banco de dados
    $conexao = new mysqli("seu_host", "seu_usuario", "sua_senha", "seu_banco_de_dados");

    // Verifica se a conexão foi bem-sucedida
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Inserção dos dados na tabela de usuários (substitua pelo nome da sua tabela)
    $sql = "INSERT INTO usuarios (nome, sobrenome, email, cep, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssss", $nome, $sobrenome, $email, $cep, $senha);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";

        // Inicia uma sessão
        session_start();

        // Armazena o email na sessão
        $_SESSION["email"] = $email;
    } else {
        echo "Erro ao cadastrar o usuário: " . $stmt->error;
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
} else {
    echo "Acesso inválido.";
}
?>
