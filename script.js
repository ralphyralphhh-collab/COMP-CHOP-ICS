(function () {
    const SETTINGS_KEY = 'cc_settings';
    const THEME_KEY = 'cc_theme';
    const root = document.documentElement;

    const read = (key, fallback) => {
        try { return JSON.parse(localStorage.getItem(key)) || fallback; } catch (e) { return fallback; }
    };
    const write = (key, value) => {
        try { localStorage.setItem(key, JSON.stringify(value)); } catch (e) { /* storage blocked */ }
    };

    /* ---------- Theme (runs in <head>, so the page paints with the right theme) ---------- */
    const THEME_DEFAULTS = { mode: 'dark', accent: '#ff1a1a', size: '1', font: 'mono', compact: false };
    const theme = Object.assign({}, THEME_DEFAULTS, read(THEME_KEY, {}));

    function applyTheme() {
        root.dataset.mode = theme.mode;
        root.dataset.font = theme.font;
        root.dataset.compact = theme.compact ? '1' : '0';
        root.style.setProperty('--accent', theme.accent);
        root.style.setProperty('--zoom', theme.size);
    }
    applyTheme();

    document.addEventListener('DOMContentLoaded', () => {
        initLogout();
        initSessions();
        initSettings();
        initCharges();
        initCustomers();
        initReservations();
    });

    function initLogout() {
        const btn = document.querySelector('.btn-logout');
        if (btn) btn.addEventListener('click', () => alert('Logout will be connected later.'));
    }

    /* ---------- Computers page ---------- */
    function initSessions() {
        const rows = document.querySelectorAll('.session');
        if (!rows.length) return;

        const pad = (n) => String(n).padStart(2, '0');
        const fmt = (s) => `${pad(Math.floor(s / 3600))}:${pad(Math.floor((s % 3600) / 60))}:${pad(s % 60)}`;
        const statAvailable = document.getElementById('stat-available');
        const statInUse = document.getElementById('stat-inuse');
        const bump = (el, by) => { el.textContent = Math.max(0, parseInt(el.textContent, 10) + by); };

        rows.forEach((row) => {
            let seconds = parseInt(row.dataset.seconds, 10) || 0;
            let paused = false;
            let ended = false;

            const timeEl = row.querySelector('.time');
            const statusEl = row.querySelector('.status-text');
            const pauseBtn = row.querySelector('.btn-pause');
            const render = () => { timeEl.textContent = fmt(seconds); };
            render();

            const endSession = () => {
                if (ended) return;
                ended = true;
                clearInterval(timer);
                row.classList.add('ended');
                statusEl.textContent = 'Ended';
                bump(statInUse, -1);
                bump(statAvailable, 1);
            };

            const timer = setInterval(() => {
                if (paused || ended) return;
                seconds = Math.max(0, seconds - 1);
                render();
                if (seconds === 0) endSession();
            }, 1000);

            pauseBtn.addEventListener('click', () => {
                paused = !paused;
                row.classList.toggle('paused', paused);
                pauseBtn.textContent = paused ? 'Resume' : 'Pause';
                statusEl.textContent = paused ? 'Paused' : 'In-use';
            });

            row.querySelector('.btn-add').addEventListener('click', () => {
                const step = parseInt(read(SETTINGS_KEY, {}).addStep, 10) || 15;
                const mins = parseInt(prompt('Add how many minutes?', step), 10);
                if (!isNaN(mins) && mins > 0) { seconds += mins * 60; render(); }
            });

            row.querySelector('.btn-end').addEventListener('click', () => {
                if (confirm('End this session?')) endSession();
            });
        });
    }

    /* ---------- Charges page ---------- */
    function initCharges() {
        const form = document.getElementById('chargeForm');
        if (!form) return;
        const item = document.getElementById('chargeItem');
        const amount = document.getElementById('chargeAmount');
        const msg = document.getElementById('chargeMsg');
        const receipt = document.getElementById('receipt');
        const say = (text, isError) => { msg.textContent = text; msg.classList.toggle('error', !!isError); };

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = item.value.trim();
            const value = parseFloat(amount.value);
            if (!name) { say('Enter the item.', true); item.focus(); return; }
            if (isNaN(value) || value <= 0) { say('Enter an amount greater than 0.', true); amount.focus(); return; }

            const number = (read('cc_receipt_no', 0)) + 1; // temporary counter until the backend issues real numbers
            write('cc_receipt_no', number);
            document.getElementById('rNo').textContent = '#' + String(number).padStart(4, '0');
            document.getElementById('rItem').textContent = name;
            document.getElementById('rAmount').textContent = '₱ ' + value.toFixed(2);
            document.getElementById('rTime').textContent = new Date().toLocaleString([], { dateStyle: 'medium', timeStyle: 'short' });
            receipt.hidden = false;
            form.reset();
            say('Charge recorded.');
        });

        document.getElementById('printReceipt').addEventListener('click', () => window.print());
    }

    /* ---------- Customers page ---------- */
    function initCustomers() {
        const search = document.getElementById('customerSearch');
        if (!search) return;
        const cards = document.querySelectorAll('.ccard');
        const empty = document.getElementById('customerEmpty');

        search.addEventListener('input', () => {
            const q = search.value.trim().toLowerCase().replace('#', '');
            let shown = 0;
            cards.forEach((card) => {
                const match = card.querySelector('h3').textContent.toLowerCase().replace('#', '').includes(q);
                card.hidden = !match;
                if (match) shown++;
            });
            empty.hidden = shown > 0;
        });
    }

    /* ---------- Reservations page ---------- */
    function initReservations() {
        const list = document.querySelector('.res-list');
        if (!list) return;

        const pad = (n) => String(n).padStart(2, '0');
        const fmt = (s) => `${pad(Math.floor(s / 60))}:${pad(s % 60)}`;
        // Hold time from Settings, never more than 15 minutes
        const holdMins = Math.min(15, parseInt(read(SETTINGS_KEY, {}).holdMins, 10) || 15);

        const setStatus = (card, state) => {
            const status = card.querySelector('.res-status');
            status.className = 'res-status status-' + state;
            status.textContent = state.charAt(0).toUpperCase() + state.slice(1);
        };

        list.querySelectorAll('.rescard').forEach((card) => {
            const wrap = card.querySelector('.res-timer');
            if (!wrap) return;
            const out = wrap.querySelector('.timer');
            let left = Math.min(parseInt(wrap.dataset.seconds, 10) || 0, holdMins * 60);

            const terminate = () => {
                clearInterval(card._timer);
                setStatus(card, 'terminated');
                wrap.textContent = 'Customer did not arrive in time. Reservation terminated.';
                card.classList.add('ended');
                card.querySelectorAll('button').forEach((b) => { b.disabled = true; });
            };
            const tick = () => {
                out.textContent = fmt(left);
                wrap.classList.toggle('urgent', left <= 60);
                if (left <= 0) terminate();
            };

            tick();
            if (left > 0) {
                card._timer = setInterval(() => { left -= 1; tick(); }, 1000);
            }
        });

        list.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-action]');
            if (!btn) return;
            const card = btn.closest('.rescard');
            const state = btn.dataset.action;
            if (state === 'declined' && !confirm('Decline this reservation request?')) return;

            setStatus(card, state);
            if (state === 'declined') {
                clearInterval(card._timer);
                const wrap = card.querySelector('.res-timer');
                if (wrap) wrap.hidden = true;
            }
        });
    }

    /* ---------- Settings page ---------- */
    function initSettings() {
        const themePanel = document.getElementById('themePanel');
        const form = document.getElementById('settingsForm');
        if (!themePanel || !form) return;

        // Theme controls
        const swatches = themePanel.querySelectorAll('.swatch');
        const custom = document.getElementById('customAccent');
        const size = document.getElementById('themeSize');
        const font = document.getElementById('themeFont');
        const compact = document.getElementById('themeCompact');
        const modes = themePanel.querySelectorAll('input[name="mode"]');

        const syncControls = () => {
            modes.forEach((r) => { r.checked = r.value === theme.mode; });
            swatches.forEach((s) => s.classList.toggle('on', s.dataset.color.toLowerCase() === theme.accent.toLowerCase()));
            custom.value = theme.accent;
            size.value = theme.size;
            font.value = theme.font;
            compact.checked = theme.compact;
        };
        const update = (changes) => {
            Object.assign(theme, changes);
            applyTheme();
            write(THEME_KEY, theme);
            syncControls();
        };

        modes.forEach((r) => r.addEventListener('change', () => update({ mode: r.value })));
        swatches.forEach((s) => s.addEventListener('click', () => update({ accent: s.dataset.color })));
        custom.addEventListener('input', () => update({ accent: custom.value }));
        size.addEventListener('change', () => update({ size: size.value }));
        font.addEventListener('change', () => update({ font: font.value }));
        compact.addEventListener('change', () => update({ compact: compact.checked }));
        document.getElementById('resetTheme').addEventListener('click', () => update(Object.assign({}, THEME_DEFAULTS)));
        syncControls();

        // Other settings
        const fields = form.querySelectorAll('[data-s]');
        const saved = read(SETTINGS_KEY, {});
        fields.forEach((el) => {
            const key = el.dataset.s;
            if (!(key in saved)) return;
            if (el.type === 'checkbox') el.checked = !!saved[key]; else el.value = saved[key];
        });

        const msg = document.getElementById('saveMsg');
        const say = (text, isError) => { msg.textContent = text; msg.classList.toggle('error', !!isError); };

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const pass = document.getElementById('newPass').value;
            const confirmPass = document.getElementById('confirmPass').value;
            if (pass || confirmPass) {
                if (pass.length < 8) return say('Password must be at least 8 characters.', true);
                if (pass !== confirmPass) return say('The two passwords do not match.', true);
            }
            const hold = parseInt(form.querySelector('[data-s="holdMins"]').value, 10);
            if (isNaN(hold) || hold < 1 || hold > 15) return say('Reservation hold time must be between 1 and 15 minutes.', true);
            const data = {};
            fields.forEach((el) => { data[el.dataset.s] = el.type === 'checkbox' ? el.checked : el.value; });
            write(SETTINGS_KEY, data);
            document.getElementById('newPass').value = '';
            document.getElementById('confirmPass').value = '';
            say(pass ? 'Settings saved. The password change needs the backend, so it was not saved.' : 'Settings saved.');
        });
    }
})();