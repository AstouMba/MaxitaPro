<?php

// Charger les variables d'environnement directement
$env = [];
$lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos($line, '=') !== false && !str_starts_with(trim($line), '#')) {
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
}

try {
    $pdo = new PDO($env['DSN'], $env['DB_USERNAME'], $env['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔧 Ajout de la colonne telephone...\n";
    
    // Ajouter la colonne telephone si elle n'existe pas
    $pdo->exec("ALTER TABLE utilisateurs ADD COLUMN IF NOT EXISTS telephone VARCHAR(20);");
    
    echo "✅ Colonne telephone ajoutée avec succès !\n";
    
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
    exit(1);
}
