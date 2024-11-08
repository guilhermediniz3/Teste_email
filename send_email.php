<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer(true);

    try {
        // Verifica se o campo 'useDefault' foi marcado
        if (isset($_POST['useDefault']) && $_POST['useDefault'] === 'on') {
            // Configurações padrão
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Seu servidor SMTP padrão
            $mail->SMTPAuth = true;
            $mail->Username = 'informe aqui o email padrao'; // Seu e-mail padrão
            $mail->Password = 'informe aqui a senha de app'; // Sua senha padrão
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->setFrom('informar aqui o email padrão para receber, 'Configuração Padrão'); // Seu e-mail padrão
            
            // Exibe as informações padrão
            echo '<pre>';
            print_r([
                'to' => htmlspecialchars($_POST['to']),
                'subject' => 'Configuração Padrão', // Assunto padrão
                'message' => htmlspecialchars($_POST['message']),
                'configuration' => 'Padrão',
                'smtp' => 'smtp.gmail.com',
                'email' => 'seu email padrao',
                'password' => 'sua senha de app', // Senha padrão
                'port' => 465,
            ]);
            echo '</pre>';

            // Apenas utiliza os dados de destinatário e mensagem do formulário
            $mail->addAddress(htmlspecialchars($_POST['to'])); // Adiciona o destinatário
            $mail->Subject = 'Configuração Padrão'; // Definindo o assunto como padrão
            $mail->Body = htmlspecialchars($_POST['message']);

        } elseif (isset($_POST['useConfig']) && $_POST['useConfig'] === 'on') {
            // Configurações do modal
            if (!empty($_POST['smtp']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['port'])) {
                $mail->isSMTP();
                $mail->Host = htmlspecialchars($_POST['smtp']);
                $mail->SMTPAuth = true;
                $mail->Username = htmlspecialchars($_POST['email']);
                $mail->Password = htmlspecialchars($_POST['password']);
                
                // Verifica a porta e define o tipo de criptografia
                $port = (int) htmlspecialchars($_POST['port']);
                $mail->Port = $port;

                if ($port === 587) {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Para porta 587
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Para porta 465
                }

                $mail->setFrom(htmlspecialchars($_POST['email']), 'Configurações de E-mail');

                // Exibe as informações do modal
                echo '<pre>';
                print_r([
                    'to' => htmlspecialchars($_POST['to']),
                    'subject' => htmlspecialchars($_POST['subject']),
                    'message' => htmlspecialchars($_POST['message']),
                    'configuration' => 'Configurações de E-mail',
                    'smtp' => htmlspecialchars($_POST['smtp']),
                    'email' => htmlspecialchars($_POST['email']),
                    'password' => htmlspecialchars($_POST['password']),
                    'port' => $port,
                ]);
                echo '</pre>';

                // Apenas utiliza os dados de destinatário, assunto e mensagem do formulário
                $mail->addAddress(htmlspecialchars($_POST['to'])); // Adiciona o destinatário
                $mail->Subject = htmlspecialchars($_POST['subject']); // Usando o assunto do modal
                $mail->Body = htmlspecialchars($_POST['message']);
            } else {
                echo "Todos os campos de configuração devem ser preenchidos.";
                exit;
            }
        }

        // Envio do e-mail
        $mail->send();
        echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
?>
