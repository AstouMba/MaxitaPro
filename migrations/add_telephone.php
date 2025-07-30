<?php

require_once __DIR__ . '/../app/config/env.php';

try {
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo " Ajout de la colonne telephone...\n";
    
    // Ajouter la colonne telephone si elle n'existe pas
    $pdo->exec("ALTER TABLE utilisateurs ADD COLUMN IF NOT EXISTS telephone VARCHAR(20);");
    
    echo " Colonne telephone ajoutée avec succès !\n";
    
} catch (Exception $e) {
    echo " Erreur : " . $e->getMessage() . "\n";
    exit(1);
}
