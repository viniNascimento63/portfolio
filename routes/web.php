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
        $payload = [
            "status" => "error",
            "msg" => "Por favor, preencha todos os campos.",
            "data" => $data
        ];

        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
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

        $payload = [
            "status" => "success",
            "data" => [
                "name" => $name,
                "email" => $email,
                "subject" => $subject,
                "message" => $message
            ]
        ];

        $response->getBody()->write(json_encode($payload));

        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    } catch (Exception $e) {
        $payload = [
            "status" => "error",
            "msg" => "Erro no servidor.",
            "error_detail" => $e->getMessage()
        ];

        $response->getBody()->write(json_encode($payload));
        
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(500);
    }
});
