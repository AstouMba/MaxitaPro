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

try {
    $config = loadEnv();

    // Connexion PDO
    $pdo = new PDO($config['DSN'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Détection du driver
    $driver = explode(':', $config['DSN'])[0];

    // Définition noms tables adaptés
    if ($driver === 'pgsql') {
        $tableUtilisateur = 'utilisateurs';
        $tableCompte = 'compte';
        $tableTransaction = 'transaction';
    } else {
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
            'id' => '1',
            'nom' => 'Diop',
            'prenom' => 'Amadou',
            'login' => 'AD',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'telephone' => null,
            'numerocarteidentite' => '1234567890123',
            'photorecto' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD...',
            'photoverso' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD...',
            'adresse' => 'Dakar, Sénégal',
            'typeuser' => 'client'
        ],
        [
            'id' => '2',
            'nom' => 'Fall',
            'prenom' => 'Fatou',
            'login' => 'FF',
            'password' => password_hash('password456', PASSWORD_DEFAULT),
            'telephone' => null,
            'numerocarteidentite' => '2345678901234',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Thiès, Sénégal',
            'typeuser' => 'client'
        ],
        [
            'id' => '3',
            'nom' => 'Ndiaye',
            'prenom' => 'Moussa',
            'login' => 'MN',
            'password' => password_hash('password789', PASSWORD_DEFAULT),
            'telephone' => null,
            'numerocarteidentite' => '3456789012345',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Saint-Louis, Sénégal',
            'typeuser' => 'client'
        ],
        [
            'id' => '4',
            'nom' => 'Ba',
            'prenom' => 'Aissatou',
            'login' => 'AB',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'telephone' => null,
            'numerocarteidentite' => '4567890123456',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Dakar, Sénégal',
            'typeuser' => 'service_commercial'
        ],
        [
             'id' => '5',
            'nom' => 'Sow',
            'prenom' => 'Ibrahim',
            'login' => 'IS',
            'password' => password_hash('admin456', PASSWORD_DEFAULT),
            'telephone' => null,
            'numerocarteidentite' => '5678901234567',
            'photorecto' => null,
            'photoverso' => null,
            'adresse' => 'Kaolack, Sénégal',
            'typeuser' => 'service_commercial'
        ]
    ];

    if ($driver === 'pgsql') {
        $stmtUser = $pdo->prepare("
            INSERT INTO $tableUtilisateur 
            (nom, prenom, login, password, telephone, numerocarteidentite, photorecto, photoverso, adresse, typeuser) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            RETURNING id
        ");
    } else {
        $stmtUser = $pdo->prepare("
            INSERT INTO $tableUtilisateur 
            (nom, prenom, login, password, telephone, numerocarteidentite, photorecto, photoverso, adresse, typeuser) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
    }

    $userIds = [];

    foreach ($Utilisateurs as $user) {
        $stmtUser->execute([
            $user['nom'], $user['prenom'], $user['login'], $user['password'],
            $user['telephone'], $user['numerocarteidentite'], $user['photorecto'], $user['photoverso'],
            $user['adresse'], $user['typeuser']
        ]);
        if ($driver === 'pgsql') {
            $id = $stmtUser->fetchColumn();
        } else {
            $id = $pdo->lastInsertId();
        }
        $userIds[] = $id;
    }

    // 2. Insertion comptes
    echo "💳 Insertion des comptes...\n";

    $comptes = [
        [
             'id' => '1',
            'solde' => 150000.50,
            'numerotel' => '+221701234567',
            'typecompte' => 'principal',
            'userid' => $userIds[1]
        ],
        [     'id' => '1',
            'solde' => 25000.00,
            'numerotel' => '+221701234568',
            'typecompte' => 'secondaire',
            'userid' => $userIds[1]
        ],
        [
                 'id' => '1',
            'solde' => 75000.75,
            'numerotel' => '+221707654321',
            'typecompte' => 'principal',
            'userid' => $userIds[1]
        ],
        [
                 'id' => '2',
            'solde' => 200000.00,
            'numerotel' => '+221709876543',
            'typecompte' => 'principal',
            'userid' => $userIds[2]
        ],
        [
                 'id' => '2',
            'solde' => 50000.25,
            'numerotel' => '+221709876544',
            'typecompte' => 'secondaire',
            'userid' => $userIds[2]
        ],
        [
            'id' => '3',
            'solde' => 10000.00,
            'numerotel' => '+221705555555',
            'typecompte' => 'principal',
            'userid' => $userIds[3]
        ]
    ];

if ($driver === 'pgsql') {
    $stmtCompte = $pdo->prepare("
        INSERT INTO $tableCompte (solde, numerotel, typecompte, userid)
        VALUES (?, ?, ?, ?)
        RETURNING id
    ");
} else {
    $stmtCompte = $pdo->prepare("
        INSERT INTO $tableCompte (solde, numerotel, typecompte, userid)
        VALUES (?, ?, ?, ?)
    ");
}


  $compteIds = [];

foreach ($comptes as $compte) {
    $stmtCompte->execute([
        $compte['solde'], $compte['numerotel'],
        $compte['typecompte'], $compte['userid']
    ]);

    $id = ($driver === 'pgsql') ? $stmtCompte->fetchColumn() : $pdo->lastInsertId();
    $compteIds[] = $id;
}


    // 3. Insertion transactions
    echo "💰 Insertion des transactions...\n";

  $transactions = [
    [
        'typetransaction' => 'depot',
        'montant' => 100000.00,
        'compteid' => $compteIds[0],
        'date' => date('Y-m-d H:i:s', strtotime('-30 days'))
    ],
    [
        'typetransaction' => 'retrait',
        'montant' => 2000.00,
        'compteid' => $compteIds[1],
        'date' => date('Y-m-d H:i:s')
    ]
];


    if ($driver === 'mysql') {
        $stmtTransaction = $pdo->prepare("
            INSERT INTO $tableTransaction (typetransaction, montant, compteid, date) 
            VALUES (?, ?, ?, ?)
        ");
    } else {
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
    echo "   • " . count($Utilisateurs) . " utilisateurs\n";
    echo "   • " . count($comptes) . " comptes\n";
    echo "   • " . count($transactions) . " transactions\n\n";

    echo "🔐 Comptes de test créés :\n";
    echo "   👤 Client 1 : AD / password123\n";
    echo "   👤 Client 2 : FF / password456\n";
    echo "   👤 Client 3 : MN / password789\n";
    echo "   🏢 Commercial 1 : AB / admin123\n";
    echo "   🏢 Commercial 2 : IS / admin456\n\n";

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "❌ Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}
