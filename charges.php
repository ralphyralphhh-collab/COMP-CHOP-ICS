<?php

$founders = [
    'Villaflores, Jan Irald',
    'Sanagang, Jefone',
    'Duran, Jhon Rey Vic',
    'Hinlo, Ralph James',
    'Maturan, Princess Jean',
];
$currentPage  = 'charges';
$reservations = 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Charges | Comp-Chop ICS Server</title>
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
        <section class="charges">
            <h1>Extra Charges and Receipts</h1>

            <form class="panel charge-form" id="chargeForm" novalidate>
                <label class="field">Item
                    <input type="text" id="chargeItem" autocomplete="off">
                </label>
                <label class="field">Amount
                    <input type="number" id="chargeAmount" min="0" step="0.01" inputmode="decimal">
                </label>
                <button type="submit" class="btn-big">Record charge and issue receipt</button>
                <p class="msg" id="chargeMsg" role="status"></p>
            </form>

            <div class="panel receipt" id="receipt" hidden>
                <h2>Receipt <span id="rNo"></span></h2>
                <div class="r-row"><span>Item</span><span id="rItem"></span></div>
                <div class="r-row"><span>Amount</span><span id="rAmount"></span></div>
                <div class="r-row"><span>Issued</span><span id="rTime"></span></div>
                <div class="bar"><button type="button" class="btn-main" id="printReceipt">Print receipt</button></div>
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