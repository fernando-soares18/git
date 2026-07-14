<?php

declare(strict_types=1);

$config = require __DIR__ . '/config.php';
$db = $config['db'];

$dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
    $db['host'],
    $db['port'],
    $db['name'],
    $db['charset']
);

try {
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $exception) {
    // Se não conseguir conectar, deixa a variável $pdo undefined
    // Isso permite que páginas que não usam banco (como painel.php) funcionem normalmente
    // Páginas que precisam de $pdo devem verificar se ela existe
    error_log('Erro ao conectar no banco de dados: ' . $exception->getMessage());
}
