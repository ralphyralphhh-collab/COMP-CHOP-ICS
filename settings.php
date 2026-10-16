<?php

$founders = [
    'Villaflores, Jan Irald',
    'Sanagang, Jefone',
    'Duran, Jhon Rey Vic',
    'Hinlo, Ralph James',
    'Maturan, Princess Jean',
];
$currentPage  = 'settings';
$reservations = 2;
$pcCount      = 8;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings | Comp-Chop ICS Server</title>
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
            <a href="settings.php" class="btn-settings active">Settings</a>
        </div>
    </aside>

    <main class="content">
        <section class="settings">
            <h1>Settings</h1>
            <p class="subtitle">Theme changes apply right away on every page. The other settings are saved when you press Save settings.</p>

            <div class="panel" id="themePanel">
                <h2>Theme</h2>
                <p class="hint">Saved in this browser and applied to all pages.</p>
                <div class="grid">
                    <div class="field">Mode
                        <div class="chips">
                            <label class="chip"><input type="radio" name="mode" value="dark"><span>Dark</span></label>
                            <label class="chip"><input type="radio" name="mode" value="black"><span>Black</span></label>
                            <label class="chip"><input type="radio" name="mode" value="light"><span>Light</span></label>
                        </div>
                    </div>
                    <div class="field">Accent color
                        <div class="swatches" id="swatches">
                            <button type="button" class="swatch" data-color="#ff1a1a" style="background:#ff1a1a" aria-label="Red"></button>
                            <button type="button" class="swatch" data-color="#ff7a00" style="background:#ff7a00" aria-label="Orange"></button>
                            <button type="button" class="swatch" data-color="#00c853" style="background:#00c853" aria-label="Green"></button>
                            <button type="button" class="swatch" data-color="#1e90ff" style="background:#1e90ff" aria-label="Blue"></button>
                            <button type="button" class="swatch" data-color="#a855f7" style="background:#a855f7" aria-label="Purple"></button>
                            <input type="color" id="customAccent" value="#ff1a1a" aria-label="Custom accent color">
                        </div>
                    </div>
                    <label class="field">Interface size
                        <select id="themeSize">
                            <option value="0.9">Small</option>
                            <option value="1">Default</option>
                            <option value="1.2">Large</option>
                            <option value="1.4">Extra large</option>
                        </select>
                    </label>
                    <label class="field">Font
                        <select id="themeFont">
                            <option value="mono">Monospace</option>
                            <option value="sans">Sans-serif</option>
                        </select>
                    </label>
                    <label class="check"><input type="checkbox" id="themeCompact"> Compact session rows</label>
                </div>
                <div class="bar"><button type="button" class="btn-main btn-ghost" id="resetTheme">Reset theme</button></div>
            </div>

            <form id="settingsForm" novalidate>
                <div class="panel">
                    <h2>Rates</h2>
                    <p class="hint">Amounts in pesos.</p>
                    <div class="grid">
                        <label class="field">Price per hour (₱)<input type="number" min="0" step="1" data-s="rateHour" value="30"></label>
                        <label class="field">Price per extra 15 minutes (₱)<input type="number" min="0" step="1" data-s="rateExtra" value="8"></label>
                        <label class="field">Minimum charge (₱)<input type="number" min="0" step="1" data-s="rateMin" value="10"></label>
                    </div>
                </div>

                <div class="panel">
                    <h2>Sessions</h2>
                    <p class="hint">The Add Time step is already used by the Add Time button on the Computers page.</p>
                    <div class="grid">
                        <label class="field">Default session length (minutes)<input type="number" min="1" data-s="sessionLen" value="60"></label>
                        <label class="field">Add Time step (minutes)<input type="number" min="1" data-s="addStep" value="15"></label>
                        <label class="field">Warn when time left is below (minutes)<input type="number" min="0" data-s="warnAt" value="5"></label>
                    </div>
                </div>

                <div class="panel">
                    <h2>Reservations</h2>
                    <p class="hint">How long a reserved computer is held while the customer travels to the shop. Maximum 15 minutes, then the reservation is terminated.</p>
                    <div class="grid">
                        <label class="field">Hold time (minutes, 1 to 15)<input type="number" min="1" max="15" data-s="holdMins" value="15"></label>
                    </div>
                </div>

                <div class="panel">
                    <h2>Computers</h2>
                    <p class="hint">Rename a computer or switch it off so it can't be used.</p>
                    <div class="pc-list">
                        <?php for ($i = 1; $i <= $pcCount; $i++): $n = sprintf('PC-%02d', $i); ?>
                            <div class="pc-row">
                                <input type="text" data-s="pc<?= $i ?>Name" value="<?= $n ?>" aria-label="Name of <?= $n ?>">
                                <label class="check"><input type="checkbox" data-s="pc<?= $i ?>On" checked> Enabled</label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="panel">
                    <h2>Shop</h2>
                    <div class="grid">
                        <label class="field">Shop name<input type="text" data-s="shopName" value="Comp-Chop ICS Server"></label>
                        <label class="field">Founders (one per line)<textarea data-s="founders"><?= htmlspecialchars(implode("\n", $founders)) ?></textarea></label>
                    </div>
                </div>

                <div class="panel">
                    <h2>Admin account</h2>
                    <p class="hint">Passwords are only checked here and never saved until the backend is ready.</p>
                    <div class="grid">
                        <label class="field">Admin name<input type="text" data-s="adminName" value="Admin" autocomplete="username"></label>
                        <label class="field">New password<input type="password" id="newPass" autocomplete="new-password"></label>
                        <label class="field">Confirm new password<input type="password" id="confirmPass" autocomplete="new-password"></label>
                    </div>
                </div>

                <div class="bar">
                    <button type="submit" class="btn-main">Save settings</button>
                    <span class="msg" id="saveMsg" role="status"></span>
                </div>
            </form>
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