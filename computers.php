<?php

$stats = [
    ['label' => 'Available',        'value' => 3, 'class' => 'green',  'id' => 'stat-available'],
    ['label' => 'In use/ paused',   'value' => 4, 'class' => 'orange', 'id' => 'stat-inuse'],
    ['label' => 'Reserved',         'value' => 2, 'class' => 'blue',   'id' => 'stat-reserved'],
    ['label' => 'Pending Requests', 'value' => 1, 'class' => 'red',    'id' => 'stat-pending'],
];

$sessions = [
    ['pc' => 'PC-01', 'customer' => 'James23', 'seconds' => 42 * 60 + 18],
    ['pc' => 'PC-02', 'customer' => 'Miles',   'seconds' => 42 * 60 + 18],
    ['pc' => 'PC-03', 'customer' => 'Man...',  'seconds' => 42 * 60 + 18],
    ['pc' => 'PC-04', 'customer' => 'Butter',  'seconds' => 42 * 60 + 18],
];

$founders = [
    'Villaflores, Jan Irald',
    'Sanagang, Jefone',
    'Duran, Jhon Rey Vic',
    'Hinlo, Ralph James',
    'Maturan, Princess Jean',
];

$currentPage  = 'computers';
$reservations = 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Computers | Comp-Chop ICS Server</title>
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
        <section class="stats">
            <?php foreach ($stats as $s): ?>
                <div class="stat">
                    <span class="stat-label"><?= htmlspecialchars($s['label']) ?></span>
                    <span class="stat-value <?= $s['class'] ?>" id="<?= $s['id'] ?>"><?= (int)$s['value'] ?></span>
                </div>
            <?php endforeach; ?>
        </section>

        <section class="computers">
            <h1>Computers</h1>
            <p class="subtitle">Check availability and manage every session. Pausing keeps the remaining time as the customer's balance.</p>

            <div class="session-list" id="sessionList">
                <?php foreach ($sessions as $row): ?>
                    <article class="session" data-seconds="<?= (int)$row['seconds'] ?>">
                        <div class="pc">
                            <strong><?= htmlspecialchars($row['pc']) ?></strong>
                            <span class="time-left"><span class="time">00:00:00</span> left</span>
                        </div>
                        <div class="status"><i class="dot"></i><span class="status-text">In-use</span></div>
                        <div class="session-right">
                            <span class="customer"><?= htmlspecialchars($row['customer']) ?></span>
                            <div class="actions">
                                <button type="button" class="btn btn-pause">Pause</button>
                                <button type="button" class="btn btn-add">Add Time</button>
                                <button type="button" class="btn btn-end">End Session</button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
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