<?php
$host = "localhost"; // Ou o hostname do seu banco de dados
$username = "root";
$password = "";
$dbname = "lojaderoupas";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilita erros para debugging
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    die();
}
?>
?>