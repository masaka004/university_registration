<?php
// Local PostgreSQL development settings (e.g., XAMPP/PostgreSQL installed)
$local = [
    'driver' => 'pgsql',
    'host'   => 'localhost',
    'port'   => '5432',
    'db'     => 'must_registration',
    'user'   => 'postgres',  // or your local PostgreSQL username
    'pass'   => '',          // your local PostgreSQL password
    'charset'=> 'utf8'
];

// Production (Render) connection settings - use external URL
$productionUrl = getenv('DATABASE_URL') ?: 'postgresql://masaka:UO6IVWtalHoF02k1s827XU1mchGSopJF@dpg-d0hmlj8dl3ps738uaasg-a/must_registration';
$production = parse_url($productionUrl);

// Parse DB info from the full URL
$render = [
    'driver' => 'pgsql',
    'host'   => $production['host'] ?? 'localhost',
    'port'   => $production['port'] ?? '5432',
    'db'     => ltrim($production['path'], '/'),
    'user'   => $production['user'] ?? '',
    'pass'   => $production['pass'] ?? '',
    'charset'=> 'utf8'
];

// Choose environment (set ENVIRONMENT=production in Render)
$envConfig = getenv('ENVIRONMENT') === 'production' ? $render : $local;

// Build DSN string
$dsn = "{$envConfig['driver']}:host={$envConfig['host']};port={$envConfig['port']};dbname={$envConfig['db']};options='--client_encoding={$envConfig['charset']}'";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Create PDO connection
try {
    $pdo = new PDO($dsn, $envConfig['user'], $envConfig['pass'], $options);
    // echo "✅ Connected to PostgreSQL!";
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());

    if (getenv('ENVIRONMENT') === 'production') {
        die("Database connection error. Please contact support.");
    } else {
        die("❌ Database connection failed: " . $e->getMessage());
    }
}
?>
