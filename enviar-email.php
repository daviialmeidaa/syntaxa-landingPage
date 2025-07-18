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
    // Para a interação, queremos a mensagem original, sem o nl2br
    $message_raw = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : 'Não informado';
    $message = nl2br($message_raw); // Versão com quebra de linha para o e-mail

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
        $mail->Password   = 'Sh@t5565*!'; // Sua senha
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';

        // 1. Remetente e Destinatários
        $mail->setFrom('contato@syntaxa.com.br', 'Contato Site Syntaxa');
        $mail->addAddress('contato@syntaxa.com.br', 'Contato Syntaxa');
        $mail->addAddress('davi.almeida@syntaxa.com.br', 'Davi Almeida');
        $mail->addReplyTo($email, $name);

        // 2. Conteúdo do E-mail Formatado
        $mail->isHTML(true);
        $mail->Subject = "Novo Contato pelo Site: " . $name;
        $email_body = "
            <body style='font-family: Arial, sans-serif; color: #333;'>
                <div style='max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                    <h2 style='color: #0D4F99;'>Novo Contato Recebido do Site</h2>
                    <p>...</p>
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
        $mail->AltBody = "Novo Contato... Mensagem:\n{$message}";

        // Envia o e-mail
        $mail->send();

        // ========================================================================
        // ETAPA 1: CRIAR O LEAD NA API
        // ========================================================================
        $apiUrlLead = 'https://syntaxa.com.br/api/criar_lead.php';
        $dadosLead = [
            'nome_empresa' => $company, 'nome_contato' => $name, 'email' => $email,
            'telefone' => 'Não informado no form', 'status' => 'Novo',
            'categoria' => $service, 'origem' => 'Site'
        ];
        $payloadLead = json_encode($dadosLead);
        $chLead = curl_init($apiUrlLead);
        curl_setopt($chLead, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chLead, CURLOPT_POST, true);
        curl_setopt($chLead, CURLOPT_POSTFIELDS, $payloadLead);
        curl_setopt($chLead, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $responseLead = curl_exec($chLead);
        curl_close($chLead);

        // ========================================================================
        // ETAPA 2: CRIAR A INTERAÇÃO AUTOMÁTICA
        // ========================================================================
        $leadData = json_decode($responseLead, true);

        // Apenas continua se o lead foi criado com sucesso e temos um ID
        if (isset($leadData['status']) && $leadData['status'] === 'sucesso') {
            $newLeadId = $leadData['id'];

            $apiUrlInteracao = 'https://syntaxa.com.br/api/criar_interacao.php';
            $dadosInteracao = [
                'id_lead' => $newLeadId,
                'tipo_interacao' => 'Site',
                'notas' => $message_raw, // Usamos a mensagem original, sem formatação HTML
                'responsavel' => 'Site'
            ];
            $payloadInteracao = json_encode($dadosInteracao);
            $chInteracao = curl_init($apiUrlInteracao);
            curl_setopt($chInteracao, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chInteracao, CURLOPT_POST, true);
            curl_setopt($chInteracao, CURLOPT_POSTFIELDS, $payloadInteracao);
            curl_setopt($chInteracao, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            
            curl_exec($chInteracao);
            curl_close($chInteracao);
        }

        echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada com sucesso!']);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => "A mensagem não pôde ser enviada. Detalhe: {$mail->ErrorInfo}"]);
    }
} else {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Acesso não permitido.']);
}
?>