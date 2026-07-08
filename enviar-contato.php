<?php
// =============================
// CONFIGURAÇÕES BÁSICAS
// =============================

// ESTE EMAIL TEM QUE SER VÁLIDO DO DOMÍNIO
$email_remetente   = "naoresponda@regtechauthority.com.br"; // remetente (do seu domínio)
$email_destinatario = "ewelyn@regtechauthority.com.br";      // para onde vai o formulário
$email_assunto      = "Contato recebido pelo site RegTech Authority"; // assunto do e-mail

// =============================
// CAPTURA DOS CAMPOS DO FORM
// =============================

// Use os "name" do formulário HTML
$nome     = isset($_POST['nome'])     ? trim($_POST['nome'])     : '';
$email    = isset($_POST['email'])    ? trim($_POST['email'])    : '';
$empresa  = isset($_POST['empresa'])  ? trim($_POST['empresa'])  : '';
$cargo    = isset($_POST['cargo'])    ? trim($_POST['cargo'])    : '';
$assunto  = isset($_POST['assunto'])  ? trim($_POST['assunto'])  : '';
$mensagem = isset($_POST['mensagem']) ? trim($_POST['mensagem']) : '';

// Validação simples – opcionalmente pode reforçar
if ($nome === '' || $email === '' || $mensagem === '') {
    // Redireciona de volta com erro simples
    header("Location: contato.html?status=erro");
    exit;
}

// =============================
// MONTA O CORPO DO EMAIL
// =============================

$conteudo  = "<strong>Nova mensagem recebida pelo site RegTech Authority</strong><br><br>";
$conteudo .= "<strong>Nome:</strong> {$nome}<br>";
$conteudo .= "<strong>E-mail:</strong> {$email}<br>";
$conteudo .= "<strong>Empresa:</strong> {$empresa}<br>";
$conteudo .= "<strong>Cargo:</strong> {$cargo}<br>";
$conteudo .= "<strong>Assunto selecionado:</strong> {$assunto}<br><br>";
$conteudo .= "<strong>Mensagem:</strong><br>";
$conteudo .= nl2br(htmlspecialchars($mensagem));

// Reply-To será o e-mail de quem preencheu o formulário
$email_reply = $email;

// Cabeçalhos do e-mail
$email_headers = implode("\n", array(
    "From: {$email_remetente}",
    "Reply-To: {$email_reply}",
    "Return-Path: {$email_remetente}",
    "MIME-Version: 1.0",
    "X-Priority: 3",
    "Content-Type: text/html; charset=UTF-8"
));

// =============================
// ENVIO
// =============================

$enviado = mail($email_destinatario, $email_assunto, $conteudo, $email_headers);

// =============================
// REDIRECIONAMENTO
// =============================

if ($enviado) {
    // Você pode criar uma página obrigado.html e mandar para lá
    header("Location: contato.html?status=ok");
} else {
    header("Location: contato.html?status=erro");
}
exit;
?>