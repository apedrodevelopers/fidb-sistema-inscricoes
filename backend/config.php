<?php

if (!function_exists("estabelecerConexaoComBanco")) {
    function estabelecerConexaoComBanco(): PDO
    {
        $dsn = "mysql:host=127.0.0.1;dbname=inscricoes";
        $user = "root";
        $pass = "0000";

        return new PDO($dsn, $user, $pass);
    }
}

if (!defined("EMOJIS")) {
    define("EMOJIS", [
        "computador" => "🖥️",
        "configuracoes" => "⚙️",
        "gabinete" => "🗄️",
        "paleta" => "🎨",
        "rede" => "🌐",
        "seguranca" => "🔐"
    ]);
}
