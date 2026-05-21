<?php
function estabelecerConexaoComBanco(): PDO
{
    $dsn = "mysql:host=127.0.0.1;dbname=inscricoes";
    $user = "root";
    $pass = "0000";

    return new PDO($dsn, $user, $pass);
}

const EMOJIS = [
    "computador" => "🖥️",
    "configuracoes" => "⚙️",
    "gabinete" => "🗄️",
    "paleta" => "🎨",
    "rede" => "🌐",
    "seguranca" => "🔐"
];
