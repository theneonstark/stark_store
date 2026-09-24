<?php
/**
 * Stark Store - Automated Database Setup & Health Check Tool
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

$action = $_GET['action'] ?? '';
$message = '';
$status = '';

if ($action === 'install') {
    $sql_file = __DIR__ . '/stark_store_complete.sql';
    if (!file_exists($sql_file)) {
        $message = "Schema file stark_store_complete.sql not found!";
        $status = 'error';
    } else {
        $sql = file_get_contents($sql_file);
        // Execute multi-query using the active connection
        if (mysqli_multi_query($con, $sql)) {
            do {
                // Fetch and discard all results
                if ($res = mysqli_store_result($con)) {
                    mysqli_free_result($res);
                }
            } while (mysqli_more_results($con) && mysqli_next_result($con));
            
            $message = "Database tables and seed data installed successfully!";
            $status = 'success';
        } else {
            $message = "Database setup error: " . mysqli_error($con);
            $status = 'error';
        }
    }
}

// Check existing tables
$tables = [];
if ($con) {
    $res = mysqli_query($con, "SHOW TABLES");
    if ($res) {
        while ($row = mysqli_fetch_array($res)) {
            $tables[] = $row[0];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pehunt Store - Database Setup & Health Check</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-2xl w-full bg-slate-800/90 border border-slate-700/80 rounded-2xl shadow-2xl p-8 backdrop-blur-md">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center font-black text-xl shadow-lg shadow-indigo-500/30">
                P
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white">Pehunt Store Database Diagnostics</h1>
                <p class="text-sm text-slate-400">Environment & Schema Health Status</p>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-xl text-sm font-medium <?php echo $status === 'success' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="space-y-4 mb-8">
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/60 flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase font-semibold text-slate-400 tracking-wider">Database Connection</span>
                    <p class="text-sm font-medium text-slate-200"><?php echo DB_HOST; ?> &bull; <?php echo DB_NAME; ?> (User: <?php echo DB_USER; ?>)</p>
                </div>
                <div>
                    <?php if ($con): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                            &check; Connected
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/20 text-rose-400 border border-rose-500/30">
                            &times; Disconnected
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/60">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs uppercase font-semibold text-slate-400 tracking-wider">Detected Tables</span>
                    <span class="text-xs font-semibold text-indigo-400"><?php echo count($tables); ?> Tables Found</span>
                </div>
                <?php if (empty($tables)): ?>
                    <p class="text-sm text-amber-400/90 bg-amber-500/10 p-3 rounded-lg border border-amber-500/20">
                        No tables detected in database '<?php echo DB_NAME; ?>'. Click "Install Schema & Seed Data" below.
                    </p>
                <?php else: ?>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($tables as $tbl): ?>
                            <span class="px-2.5 py-1 rounded-lg text-xs bg-slate-800 text-slate-300 border border-slate-700 font-mono">
                                <?php echo htmlspecialchars($tbl); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/60 space-y-2 text-xs text-slate-300">
                <div class="font-semibold text-slate-200">Default Demo Credentials:</div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-2 rounded bg-slate-800/80 border border-slate-700/50">
                        <span class="text-slate-400">Admin:</span> <code class="text-indigo-300">admin@PeHuntstore.com</code> / <code class="text-indigo-300">admin123</code>
                    </div>
                    <div class="p-2 rounded bg-slate-800/80 border border-slate-700/50">
                        <span class="text-slate-400">Customer:</span> <code class="text-indigo-300">sahil@gmail.com</code> / <code class="text-indigo-300">sahil123</code>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="index.php" class="px-5 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-slate-200 font-semibold text-sm transition">
                &larr; Go to Storefront
            </a>
            <div class="flex gap-3">
                <a href="admin/index.php" class="px-5 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-slate-200 font-semibold text-sm transition">
                    Admin Portal
                </a>
                <a href="setup.php?action=install" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition shadow-lg shadow-indigo-600/30">
                    Install / Reset Schema
                </a>
            </div>
        </div>
    </div>
</body>
</html>
