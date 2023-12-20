<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["password"];

    // Aqui você deve substituir pelos detalhes da sua conexão com o banco de dados
    $conexao = new mysqli("seu_host", "seu_usuario", "sua_senha", "seu_banco_de_dados");

    // Verifica se a conexão foi bem-sucedida
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Consulta SQL para verificar o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário foi encontrado
    if ($result->num_rows > 0) {
        // Inicia uma sessão
        session_start();

        // Armazena o email na sessão
        $_SESSION["email"] = $email;

        // Redireciona para a página de boas-vindas
        header("Location: bem-vindo.php");
        exit();
    } else {
        // Se o login falhar, exibe uma mensagem de erro
        echo "Email ou senha incorretos. Tente novamente.";
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
}
?>
