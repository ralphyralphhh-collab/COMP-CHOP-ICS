<?php

$requests = [
    ['id' => 1203, 'pc' => 'PC-02', 'minutes' => 60,  'status' => 'accepted', 'seconds_left' => 8 * 60 + 40],
    ['id' => 1064, 'pc' => 'PC-07', 'minutes' => 120, 'status' => 'pending',  'seconds_left' => 14 * 60 + 10],
    ['id' => 1187, 'pc' => 'PC-04', 'minutes' => 30,  'status' => 'pending',  'seconds_left' => 3 * 60 + 5],
    ['id' => 1259, 'pc' => 'PC-21', 'minutes' => 90,  'status' => 'pending',  'seconds_left' => 12 * 60 + 30],
];


$arrivalLimitMinutes = 15;


function formatDuration(int $minutes): string {
    $h = intdiv($minutes, 60);
    $m = $minutes % 60;
    $parts = [];
    if ($h > 0) $parts[] = $h . ($h === 1 ? ' hr' : ' hrs');
    if ($m > 0) $parts[] = $m . ($m === 1 ? ' min' : ' mins');
    return implode(' ', $parts) ?: '0 mins';
}

$founders = [
    'Villaflores, Jan Irald',
    'Sanagang, Jefone',
    'Duran, Jhon Rey Vic',
    'Hinlo, Ralph James',
    'Maturan, Princess Jean',
];
$currentPage  = 'reservations';
$reservations = 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservations | Comp-Chop ICS Server</title>
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
        <section class="reservation-page">
            <h1>Reservation Requests</h1>
            <p class="subtitle rule">Customers have <?= $arrivalLimitMinutes ?> minutes to reach the shop. After that the reservation is terminated.</p>

            <div class="res-scroll">
                <div class="res-list">
                    <?php foreach ($requests as $r): ?>
                        <article class="rescard">
                            <span class="res-status status-<?= htmlspecialchars($r['status']) ?>"><?= ucfirst(htmlspecialchars($r['status'])) ?></span>
                            <h3>Customer #<?= (int)$r['id'] ?></h3>
                            <p class="res-pc">Requested <strong><?= htmlspecialchars($r['pc']) ?></strong></p>
                            <p class="res-pc">Reserved for <strong><?= formatDuration((int)$r['minutes']) ?></strong></p>
                            <p class="res-pc res-timer" data-seconds="<?= min((int)$r['seconds_left'], $arrivalLimitMinutes * 60) ?>">Arrive within <strong class="timer">--:--</strong></p>
                            <div class="res-actions">
                                <button type="button" class="btn-accept" data-action="accepted">Accept</button>
                                <button type="button" class="btn-decline" data-action="declined">Decline</button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
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