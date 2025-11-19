<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carrega variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable("/var/www/html/");
$dotenv->safeLoad(); // Não dispara Exeption se .env não for encontrado

$app->get('/', function (Request $request, Response $response) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'home.html.twig');
});

$app->post('/contact', function (Request $request, Response $response) {
    $view = Twig::fromRequest($request);

    $data = (array)$request->getParsedBody();
    // "??" -> se o campo não existir, a variável será string vazia (evita undefined index)
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $subject = $data['subject'] ?? '';
    $message = $data['message'] ?? '';

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        return $view->render($response, 'home.html.twig', [
            'error' => 'Por favor, preencha todos os campos.'
        ]);
    }

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';       // servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom($email, $name);
        $mail->addAddress('viniode2015@gmail.com', 'Vinícius Nascimento');

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Novo contato do site';
        $mail->Body    = "<strong>Nome:</strong> $name <br>
                          <strong>E-mail:</strong> $email <br>
                          <strong>Mensagem:</strong><br>$message";

        $mail->send();

        return $view->render($response, 'home.html.twig', [
            'success' => 'Mensagem enviada com sucesso!'
        ]);
    } catch (Exception $e) {
        return $view->render($response, 'home.html.twig', [
            'error' => 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo
        ]);
    }
});
