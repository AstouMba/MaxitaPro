<?php

require_once __DIR__ . '/../vendor/autoload.php';

function prompt(string $message): string
{
    echo $message;
    return trim(fgets(STDIN));
}

function writeEnvIfNotExists(array $config): void
{
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        $env = <<<ENV
DB_USERNAME={$config['username']}
DB_PASSWORD={$config['password']}
DSN={$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']};

ENV;
        file_put_contents($envPath, $env);
        echo ".env généré avec succès à la racine du projet.\n";
    } else {
        echo "Le fichier .env existe déjà, aucune modification.\n";
    }
}

$driver = strtolower(prompt("Quel SGBD utiliser ? (mysql / pgsql) : "));
$host = prompt("Hôte (default: 127.0.0.1) : ") ?: "127.0.0.1";
$port = prompt("Port (default: 3306 ou 5432) : ") ?: ($driver === 'pgsql' ? "5432" : "3306");
$username = prompt("Utilisateur (default: root) : ") ?: "root";
$password = prompt("Mot de passe : ");
$dbName = prompt("Nom de la base à créer : ");

try {
    $DSN = "$driver:host=$host;port=$port";
    $pdo = new PDO($DSN, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($driver === 'mysql') {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base MySQL `$dbName` créée avec succès.\n";
        $pdo->exec("USE `$dbName`");
    } elseif ($driver === 'pgsql') {
        $check = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'")->fetch();
        if (!$check) {
            $pdo->exec("CREATE DATABASE \"$dbName\"");
            echo "Base PostgreSQL `$dbName` créée.\nRelancez la migration pour créer les tables.\n";
            writeEnvIfNotExists([
                'driver' => $driver,
                'host' => $host,
                'port' => $port,
                'username' => $username,
                'password' => $password,
                'dbname' => $dbName
            ]);
            exit;
        } else {
            echo "ℹ Base PostgreSQL `$dbName` déjà existante.\n";
        }
    }

    $DSN = "$driver:host=$host;port=$port;dbname=$dbName";
    $pdo = new PDO($DSN, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($driver === 'mysql') {
        $tables = [
"CREATE TABLE IF NOT EXISTS Utilisateurs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    numerocarteidentite VARCHAR(50) UNIQUE,
    photorecto TEXT,
    photoverso TEXT,
    adresse VARCHAR(255),
    typeuser VARCHAR(20) NOT NULL,
    CHECK (typeuser IN ('client', 'service_commercial'))
);",

"CREATE TABLE IF NOT EXISTS Compte (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    datecreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    solde DECIMAL(15, 2) DEFAULT 0.00,
    numerotel VARCHAR(20) NOT NULL,
    typecompte VARCHAR(20) NOT NULL,
    userid INT UNSIGNED NOT NULL,
    FOREIGN KEY (userid) REFERENCES Utilisateurs(id),
    CHECK (typecompte IN ('principal', 'secondaire'))
);",

"CREATE TABLE IF NOT EXISTS Transaction (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    typetransaction VARCHAR(20) NOT NULL,
    montant DECIMAL(15, 2) NOT NULL,
    compteid INT UNSIGNED NOT NULL,
    FOREIGN KEY (compteid) REFERENCES Compte(id),
    CHECK (typetransaction IN ('depot', 'retrait', 'paiement'))
);"
        ];
    } else {
        $pdo->exec("DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'transaction_type') THEN
                CREATE TYPE transaction_type AS ENUM ('depot', 'retrait', 'transfert');
            END IF;
        END$$;");

        $tables = [
"CREATE TABLE IF NOT EXISTS Utilisateurs (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    numerocarteidentite VARCHAR(50) UNIQUE,
    photorecto TEXT,
    photoverso TEXT,
    adresse VARCHAR(255),
    typeuser VARCHAR(20) NOT NULL CHECK (typeuser IN ('client', 'service_commercial'))
);",

"CREATE TABLE IF NOT EXISTS Compte (
    id SERIAL PRIMARY KEY,
    datecreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    solde NUMERIC(15, 2) DEFAULT 0.00,
    numerotel VARCHAR(20) NOT NULL,
    typecompte VARCHAR(20) NOT NULL CHECK (typecompte IN ('principal', 'secondaire')),
    userid INTEGER NOT NULL,
    FOREIGN KEY (userid) REFERENCES Utilisateurs(id)
);",

"CREATE TABLE IF NOT EXISTS Transaction (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    typetransaction VARCHAR(20) NOT NULL CHECK (typetransaction IN ('depot', 'retrait', 'paiement')),
    montant NUMERIC(15, 2) NOT NULL,
    compteid INTEGER NOT NULL,
    FOREIGN KEY (compteid) REFERENCES Compte(id)
);",
        ];
    }

    foreach ($tables as $sql) {
        $pdo->exec($sql);
    }

    echo "Toutes les tables ont été créées avec succès dans `$dbName`.\n";
    writeEnvIfNotExists([
        'driver' => $driver,
        'host' => $host,
        'port' => $port,
        'username' => $username,
        'password' => $password,
        'dbname' => $dbName
    ]);

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}