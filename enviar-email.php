<?php
header('Content-Type: application/json'); // Garante que a resposta seja JSON

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Caminho para os arquivos do PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e limpa os dados do formulário
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : 'Não informado';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : 'Não informado';
    $company = isset($_POST['company']) ? htmlspecialchars(trim($_POST['company'])) : 'Não informado';
    $service = isset($_POST['service']) ? htmlspecialchars(trim($_POST['service'])) : 'Não informado';
    $message = isset($_POST['message']) ? nl2br(htmlspecialchars(trim($_POST['message']))) : 'Não informado'; // nl2br preserva as quebras de linha

    // Validação
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Por favor, preencha os campos obrigatórios corretamente.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor (HostGator)
        $mail->isSMTP();
        $mail->Host       = 'br94.hostgator.com.br';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contato@syntaxa.com.br';
        $mail->Password   = 'Sh@t5565*!'; // <<< COLOQUE SUA SENHA AQUI
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';

        // --- INÍCIO DAS MODIFICAÇÕES ---

        // 1. Remetente e Destinatários
        $mail->setFrom('contato@syntaxa.com.br', 'Contato Site Syntaxa');
        $mail->addAddress('contato@syntaxa.com.br', 'Contato Syntaxa'); // Primeiro destinatário
        $mail->addAddress('davi.almeida@syntaxa.com.br', 'Davi Almeida');   // Segundo destinatário
        $mail->addReplyTo($email, $name);

        // 2. Conteúdo do E-mail Formatado
        $mail->isHTML(true);
        $mail->Subject = "Novo Contato pelo Site: " . $name;
        
        // Template HTML para o corpo do e-mail
        $email_body = "
            <body style='font-family: Arial, sans-serif; color: #333;'>
                <div style='max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                    <h2 style='color: #0D4F99;'>Novo Contato Recebido do Site</h2>
                    <p>Olá, um novo contato foi enviado através do formulário do site Syntaxa.</p>
                    <hr>
                    <p><strong>Quem entrou em contato:</strong> {$name}</p>
                    <p><strong>Email:</strong> {$email}</p>
                    <p><strong>Empresa:</strong> {$company}</p>
                    <p><strong>Serviço de Interesse:</strong> {$service}</p>
                    <br>
                    <p><strong>Mensagem:</strong></p>
                    <div style='padding: 10px; background-color: #f8f9fa; border-radius: 5px;'>
                        <p>{$message}</p>
                    </div>
                </div>
            </body>
        ";

        $mail->Body = $email_body;

        // Versão em texto puro para clientes de e-mail que não suportam HTML
        $mail->AltBody = "Novo Contato Recebido do Site.\n\nQuem entrou em contato: {$name}\nEmail: {$email}\nEmpresa: {$company}\nServiço de Interesse: {$service}\n\nMensagem:\n{$message}";

        // --- FIM DAS MODIFICAÇÕES ---

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada com sucesso!']);
        
    } catch (Exception $e) {
        http_response_code(500);
        // Retorna a mensagem de erro do PHPMailer para ajudar na depuração
        echo json_encode(['status' => 'error', 'message' => "A mensagem não pôde ser enviada. Detalhe: {$mail->ErrorInfo}"]);
    }
} else {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Acesso não permitido.']);
}
?>