<?php

require_once __DIR__ . '/../vendor/autoload.php';

function loadEnv(): array
{
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        throw new Exception("Le fichier .env n'existe pas. Veuillez d'abord exécuter migrate.php");
    }

    $env = [];
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && !str_starts_with(trim($line), '#')) {
            list($key, $value) = explode('=', $line, 2);
            $env[trim($key)] = trim($value);
        }
    }
    return $env;
}

function prompt(string $message): string
{
    echo $message;
    return trim(fgets(STDIN));
}

try {
    $config = loadEnv();

    // Connexion PDO
    $pdo = new PDO($config['DSN'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Détection du driver
    $driver = explode(':', $config['DSN'])[0];

    // Définition noms tables adaptés
    if ($driver === 'pgsql') {
        // Postgres : noms en minuscules, pluriel, évite mots réservés
        $tableUtilisateur = 'utilisateurs';
        $tableCompte = 'compte';
        $tableTransaction = 'transactions';
    } else {
        // MySQL : noms avec majuscules comme initialement (adapter si tu veux)
        $tableUtilisateur = 'Utilisateurs';
        $tableCompte = 'Compte';
        $tableTransaction = 'Transaction';
    }

    

    // Démarre transaction
    $pdo->beginTransaction();

    // 1. Insertion utilisateurs
    echo "👥 Insertion des utilisateurs...\n";

    $Utilisateurs = [
        [
            'nom' => 'Diop',
            'prenom' => 'Amadou',
            'login' => 'AD',
            'password' => 'password123',
            'numerocarteidentite' => '1234567890123',
            'photorecto' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD...',
            'photoverso' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD...',
            'adresse' => 'Dakar, Sénégal',
            'typeuser' => 'client'
        ],
        [
            'nom' => 'Fall',
            'prenom' => 'Fatou',
            'login' => 'FF',
            'password' => 'password456',
            'numerocarteidentite' => '2345678901234',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Thiès, Sénégal',
            'typeuser' => 'client'
        ],
        [
            'nom' => 'Ndiaye',
            'prenom' => 'Moussa',
            'login' => 'MN',
            'password' => 'password789' ,
            'numerocarteidentite' => '3456789012345',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Saint-Louis, Sénégal',
            'typeuser' => 'client'
        ],
        [
            'nom' => 'Ba',
            'prenom' => 'Aissatou',
            'login' => 'AB',
            'password' => 'admin123',
            'numerocarteidentite' => '4567890123456',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Dakar, Sénégal',
            'typeuser' => 'service_commercial'
        ],
        [
            'nom' => 'Sow',
            'prenom' => 'Ibrahim',
            'login' => 'IS',
            'password' => 'admin456',
            'numerocarteidentite' => '5678901234567',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Kaolack, Sénégal',
            'typeuser' => 'service_commercial'
        ]
    ];

    $stmtUser = $pdo->prepare("
        INSERT INTO $Utilisateur 
        (nom, prenom, login, password, numerocarteidentite, photorecto, photoverso, adresse, typeuser) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($Utilisateurs as $user) {
        $stmtUser->execute([
            $user['nom'], $user['prenom'], $user['login'], $user['password'],
            $user['numerocarteidentite'], $user['photorecto'], $user['photoverso'],
            $user['adresse'], $user['typeuser']
        ]);
    }

    // 2. Insertion comptes
    echo "💳 Insertion des comptes...\n";

    $comptes = [
        [
            'solde' => 150000.50,
            'numerotel' => '+221701234567',
            'typecompte' => 'principal',
            'userid' => 1
        ],
        [
            'solde' => 25000.00,
            'numerotel' => '+221701234568',
            'typecompte' => 'secondaire',
            'userid' => 1
        ],
        [
            'solde' => 75000.75,
            'numerotel' => '+221707654321',
            'typecompte' => 'principal',
            'userid' => 2
        ],
        [
            'solde' => 200000.00,
            'numerotel' => '+221709876543',
            'typecompte' => 'principal',
            'userid' => 3
        ],
        [
            'solde' => 50000.25,
            'numerotel' => '+221709876544',
            'typecompte' => 'secondaire',
            'userid' => 3
        ],
        [
            'solde' => 10000.00,
            'numerotel' => '+221705555555',
            'typecompte' => 'principal',
            'userid' => 4
        ]
    ];

    $stmtCompte = $pdo->prepare("
        INSERT INTO $tableCompte (solde, numerotel, typecompte, userid) 
        VALUES (?, ?, ?, ?)
    ");

    foreach ($comptes as $compte) {
        $stmtCompte->execute([
            $compte['solde'], $compte['numerotel'], 
            $compte['typecompte'], $compte['userid']
        ]);
    }

    // 3. Insertion transactions
    echo "💰 Insertion des transactions...\n";

    $transactions = [
        // idem que ton tableau d'origine, inchangé
        [
            'typetransaction' => 'depot',
            'montant' => 100000.00,
            'compteid' => 1,
            'date' => date('Y-m-d H:i:s', strtotime('-30 days'))
        ],
        // ... autres transactions
        [
            'typetransaction' => 'retrait',
            'montant' => 2000.00,
            'compteid' => 3,
            'date' => date('Y-m-d H:i:s')
        ]
    ];

    if ($driver === 'mysql') {
        $stmtTransaction = $pdo->prepare("
            INSERT INTO $tableTransaction (typetransaction, montant, compteid, date) 
            VALUES (?, ?, ?, ?)
        ");
    } else {
        // Pour Postgres, casting explicite de typetransaction en VARCHAR
        $stmtTransaction = $pdo->prepare("
            INSERT INTO $tableTransaction (typetransaction, montant, compteid, date) 
            VALUES (?::VARCHAR, ?, ?, ?)
        ");
    }

    foreach ($transactions as $transaction) {
        $stmtTransaction->execute([
            $transaction['typetransaction'], $transaction['montant'],
            $transaction['compteid'], $transaction['date']
        ]);
    }

    // Commit transaction
    $pdo->commit();

    echo "\n✅ Seeding terminé avec succès !\n\n";
    echo "📊 Résumé des données insérées :\n";
    echo "   • " . count($utilisateurs) . " utilisateurs\n";
    echo "   • " . count($comptes) . " comptes\n";
    echo "   • " . count($transactions) . " transactions\n\n";

    echo "🔐 Comptes de test créés :\n";
    echo "   👤 Client 1 : AM/ password123\n";
    echo "   👤 Client 2 : FF/ password456\n";
    echo "   👤 Client 3 : MN/ password789\n";
    echo "   🏢 Commercial 1 : AB / admin123\n";
    echo "   🏢 Commercial 2 : IS / admin456\n\n";

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "❌ Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}
