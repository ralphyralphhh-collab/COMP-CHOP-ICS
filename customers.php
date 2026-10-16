<?php

$customers = [
    ['id' => 1908, 'balance' => 42 * 60],
    ['id' => 1233, 'balance' => 3 * 3600],
    ['id' => 1654, 'balance' => 3 * 60 + 27],
    ['id' => 1114, 'balance' => 59 * 60],
    ['id' => 1025, 'balance' => 3 * 3600 + 29 * 60 + 30],
    ['id' => 1738, 'balance' => 30 * 60 + 10],
    ['id' => 1281, 'balance' => 3600 + 8 * 60 + 29],
    ['id' => 1402, 'balance' => 3 * 3600 + 9 * 60],
    ['id' => 1837, 'balance' => 5 * 3600],
    ['id' => 1196, 'balance' => 3 * 3600 + 5 * 60 + 11],
];

function formatBalance(int $s): string {
    return sprintf('%02d:%02d:%02d', intdiv($s, 3600), intdiv($s % 3600, 60), $s % 60);
}

$founders = [
    'Villaflores, Jan Irald',
    'Sanagang, Jefone',
    'Duran, Jhon Rey Vic',
    'Hinlo, Ralph James',
    'Maturan, Princess Jean',
];
$currentPage  = 'customers';
$reservations = 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers | Comp-Chop ICS Server</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>

<header class="topbar">
    <div class="brand">
        <svg class="logo" viewBox="0 0 64 56" aria-hidden="true">
            <rect x="4" y="4" width="48" height="34" rx="4" fill="none" stroke="#e60000" stroke-width="3"/>
            <path d="M30 14a10 10 0 1 0 0 16" fill="none" stroke="#fff" stroke-width="5" stroke-linecap="round"/>
            <path d="M22 46h24M34 38v8" stroke="#e60000" stroke-width="3" stroke-linecap="round"/>
            <path d="M44 8a14 14 0 0 1 12 12" fill="none" stroke="#e60000" stroke-width="3" stroke-linecap="round"/>
        </svg>
        <span class="brand-name">COMP-CHOP <b>ICS</b> <small>SERVER</small></span>
    </div>
    <div class="user">
        <span class="role">ADMIN</span>
        <button class="btn-logout" type="button">LOGOUT</button>
    </div>
</header>

<div class="layout">
    <aside class="sidebar">
        <nav class="side-nav" aria-label="Main">
            <a href="computers.php" class="side-link <?= $currentPage === 'computers' ? 'active' : '' ?>">Computers</a>
            <a href="customers.php" class="side-link <?= $currentPage === 'customers' ? 'active' : '' ?>">Customers</a>
            <a href="charges.php" class="side-link <?= $currentPage === 'charges' ? 'active' : '' ?>">Charges</a>
            <a href="reservations.php" class="side-link <?= $currentPage === 'reservations' ? 'active' : '' ?>">Reservations (<?= $reservations ?>)</a>
            <a href="reports.php" class="side-link <?= $currentPage === 'reports' ? 'active' : '' ?>">Reports</a>
        </nav>

        <div class="side-bottom">
            <a href="settings.php" class="btn-settings">Settings</a>
        </div>
    </aside>

    <main class="content">
        <section class="customer-page">
            <h1>Customer Accounts</h1>

            <label class="field search" for="customerSearch">Search customers
                <input type="search" id="customerSearch" autocomplete="off">
            </label>

            <div class="customer-scroll">
                <div class="customer-grid" id="customerGrid">
                    <?php foreach ($customers as $c): ?>
                        <article class="ccard">
                            <h3>Customer #<?= (int)$c['id'] ?></h3>
                            <span class="ccard-label">Remaining Balance</span>
                            <strong class="balance"><?= formatBalance($c['balance']) ?></strong>
                        </article>
                    <?php endforeach; ?>
                </div>
                <p class="empty" id="customerEmpty" hidden>No customers match your search.</p>
            </div>
        </section>
    </main>
</div>

<footer class="footer">
    <h2>Founders:</h2>
    <ul>
        <?php foreach ($founders as $f): ?>
            <li><?= htmlspecialchars($f) ?></li>
        <?php endforeach; ?>
    </ul>
</footer>

</body>
</html>