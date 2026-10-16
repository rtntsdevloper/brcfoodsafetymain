<?php



$batch = $_GET['batch'];

if (isset($_GET['create'])) {

    $create = $_GET['create'];
} else {

    $create = '';
}



if (isset($_POST['approve'])) {

    mysqli_query($con, "UPDATE `tblmarination` SET `confirm`='Approved' WHERE id='$batch'");
}

if (isset($_POST['reject'])) {

    mysqli_query($con, "UPDATE `tblmarination` SET `confirm`='Rejected' WHERE id='$batch'");
}





?>





<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">



<style>
    :root {

        --bg: #f4f6fb;

        --bg-2: #eef1f8;

        --bg-3: #e8ecf4;

        --panel: #ffffff;

        --panel-hover: #fafbfe;

        --panel-2: #f7f8fc;

        --border: #e5e8f0;

        --border-light: #dce0ea;

        --border-glow: rgba(234, 88, 12, .35);

        --fg: #1a1d2e;

        --fg-dim: #4a5068;

        --muted: #8891a8;

        --accent: #ea580c;

        --accent-2: #f97316;

        --accent-deep: #c2410c;

        --accent-glow: rgba(234, 88, 12, .08);

        --accent-glow-strong: rgba(234, 88, 12, .18);

        --ok: #16a34a;

        --ok-bg: #f0fdf4;

        --ok-border: #bbf7d0;

        --warn: #ca8a04;

        --warn-bg: #fefce8;

        --warn-border: #fde68a;

        --bad: #dc2626;

        --bad-bg: #fef2f2;

        --bad-border: #fecaca;

        --info: #2563eb;

        --info-bg: #eff6ff;

        --info-border: #bfdbfe;

    }



    * {

        box-sizing: border-box;

        margin: 0;

        padding: 0;

    }



    html,

    body {

        background: var(--bg);

        color: var(--fg);

        min-height: 100vh;

        overflow-x: hidden;

    }



    body {

        background:

            radial-gradient(ellipse 900px 500px at 20% 0%, rgba(234, 88, 12, .05), transparent),

            radial-gradient(ellipse 600px 400px at 85% 5%, rgba(37, 99, 235, .03), transparent),

            var(--bg);

    }



    body::before {

        content: "";

        position: fixed;

        inset: 0;

        pointer-events: none;

        z-index: 0;

        background-image:

            linear-gradient(rgba(26, 29, 46, .018) 1px, transparent 1px),

            linear-gradient(90deg, rgba(26, 29, 46, .018) 1px, transparent 1px);

        background-size: 56px 56px;

    }



    .mono {

        font-weight: 600;

        letter-spacing: .3px;

    }



    .main-container {

        position: relative;

        z-index: 1;

        padding: 32px 24px 60px;

        max-width: 1320px;

        margin: 0 auto;

    }



    .brand-strip {

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-bottom: 36px;

        flex-wrap: wrap;

        gap: 16px;

    }



    .brand-left {

        display: flex;

        align-items: center;

        gap: 14px;

    }



    .brand-logo {

        width: 46px;

        height: 46px;

        border-radius: 13px;

        background: linear-gradient(135deg, var(--accent), var(--accent-deep));

        display: grid;

        place-items: center;

        box-shadow: 0 6px 24px -4px rgba(234, 88, 12, .4);

        color: #fff;

        font-weight: 800;

        font-size: 17px;

        letter-spacing: -0.5px;

    }



    .brand-text h1 {

        font-size: 20px;

        font-weight: 800;

        letter-spacing: -0.3px;

        line-height: 1.2;

        color: var(--fg);

    }



    .brand-text span {

        font-size: 11px;

        color: var(--muted);

        letter-spacing: 2px;

        text-transform: uppercase;

        font-weight: 500;

    }



    .brand-right {

        display: flex;

        align-items: center;

        gap: 10px;

    }



    .live-chip {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        padding: 7px 14px;

        border-radius: 100px;

        background: var(--ok-bg);

        border: 1px solid var(--ok-border);

        font-size: 12px;

        font-weight: 600;

        color: var(--ok);

    }



    .live-dot {

        width: 7px;

        height: 7px;

        border-radius: 50%;

        background: var(--ok);

        box-shadow: 0 0 10px var(--ok);

        animation: livePulse 2s ease-in-out infinite;

    }



    @keyframes livePulse {



        0%,

        100% {

            opacity: 1;

            transform: scale(1);

        }



        50% {

            opacity: .5;

            transform: scale(.8);

        }

    }



    .search-wrapper {

        position: relative;

        margin-bottom: 32px;

        max-width: 640px;

    }



    .search-bar {

        display: flex;

        align-items: center;

        background: var(--panel);

        border: 1.5px solid var(--border-light);

        border-radius: 16px;

        padding: 6px 6px 6px 20px;

        gap: 4px;

        transition: all .3s ease;

        box-shadow: 0 1px 3px rgba(0, 0, 0, .04), 0 4px 16px rgba(0, 0, 0, .03);

    }



    .search-bar:focus-within {

        border-color: var(--accent);

        box-shadow: 0 0 0 4px var(--accent-glow-strong), 0 4px 20px rgba(234, 88, 12, .08);

    }



    .search-bar .s-icon {

        color: var(--muted);

        font-size: 18px;

        flex-shrink: 0;

        transition: color .3s;

    }



    .search-bar:focus-within .s-icon {

        color: var(--accent);

    }



    .search-bar input {

        flex: 1;

        border: none;

        outline: none;

        background: transparent;

        font-size: 14px;

        color: var(--fg);

        padding: 12px 14px;

        letter-spacing: .3px;

    }



    .search-bar input::placeholder {

        color: var(--muted);

        font-size: 13.5px;

        letter-spacing: 0;

    }



    .btn-search {

        background: linear-gradient(135deg, var(--accent), var(--accent-deep));

        color: #fff;

        border: none;

        padding: 11px 24px;

        border-radius: 12px;

        font-weight: 700;

        font-size: 13px;

        cursor: pointer;

        display: flex;

        align-items: center;

        gap: 7px;

        flex-shrink: 0;

        box-shadow: 0 4px 16px -2px rgba(234, 88, 12, .35);

        transition: all .25s ease;

        letter-spacing: .3px;

    }



    .btn-search:hover {

        transform: translateY(-1px);

        box-shadow: 0 6px 24px -2px rgba(234, 88, 12, .5);

        background: linear-gradient(135deg, var(--accent-2), var(--accent));

    }



    .btn-ghost {

        background: #fff;

        border: 1px solid var(--border-light);

        color: var(--fg);

        padding: 10px 18px;

        border-radius: 8px;

        font-weight: 500;

        cursor: pointer;

        display: inline-flex;

        align-items: center;

        gap: 8px;

        text-decoration: none;

    }



    .btn-ghost:hover {

        border-color: var(--accent);

        color: var(--accent);

        background: var(--accent-glow);

        text-decoration: none;

    }



    .btn-search:active {

        transform: translateY(0);

    }



    .search-hint {

        margin-top: 10px;

        font-size: 12px;

        color: var(--muted);

        padding-left: 4px;

    }



    .kv-label {

        font-size: 10.5px;

        letter-spacing: 1.5px;

        color: var(--muted);

        text-transform: uppercase;

        font-weight: 600
    }



    .kv-value {

        font-size: 15px;

        color: var(--fg);

        font-weight: 600;

        font-family: 'JetBrains Mono', monospace
    }



    .search-hint code {

        background: var(--panel);

        border: 1px solid var(--border-light);

        padding: 2px 7px;

        border-radius: 5px;

        font-size: 11px;

        color: var(--accent);

        font-weight: 500;

    }



    .card {

        background: transparent !important;

        border: none !important;

        border-radius: 0 !important;

    }



    .card-body {

        padding: 0 !important;

    }



    .batch-hero {

        position: relative;

        background: var(--panel);

        border: 1px solid var(--border);

        border-radius: 20px;

        overflow: hidden;

        padding: 32px;

        margin-bottom: 24px;

        display: flex;

        flex-wrap: wrap;

        justify-content: space-between;

        align-items: center;

        gap: 24px;

        box-shadow: 0 1px 3px rgba(0, 0, 0, .04), 0 8px 32px -8px rgba(0, 0, 0, .06);

    }



    .batch-hero::before {

        content: "";

        position: absolute;

        top: 0;

        left: 0;

        right: 0;

        height: 3px;

        background: linear-gradient(90deg, var(--accent), var(--accent-2), var(--accent-deep), var(--accent));

        background-size: 300% 100%;

        animation: gradientSlide 4s ease infinite;

    }



    @keyframes gradientSlide {

        0% {

            background-position: 0% 50%;

        }



        50% {

            background-position: 100% 50%;

        }



        100% {

            background-position: 0% 50%;

        }

    }



    .batch-hero::after {

        content: "";

        position: absolute;

        top: 0;

        right: 0;

        width: 280px;

        height: 280px;

        background: radial-gradient(circle, var(--accent-glow-strong), transparent 70%);

        pointer-events: none;

        opacity: .4;

    }



    .hero-left {

        position: relative;

        z-index: 1;

        flex: 1 1 320px;

    }



    .hero-badges {

        display: flex;

        align-items: center;

        gap: 10px;

        margin-bottom: 14px;

    }



    .hero-left h3 {

        font-weight: 800;

        font-size: 24px;

        letter-spacing: -0.5px;

        margin-bottom: 6px;

        color: var(--fg);

    }



    .hero-batch-id {

        color: var(--accent);

        font-size: 14px;

        font-weight: 600;

        letter-spacing: .3px;

    }



    .hero-right {

        position: relative;

        z-index: 1;

        flex: 1 1 340px;

        display: grid;

        grid-template-columns: 1fr 1fr 1fr;

        gap: 12px;

    }



    .hero-kv {

        background: var(--panel-2);

        border: 1px solid var(--border);

        border-radius: 12px;

        padding: 14px 16px;

        transition: all .25s ease;

    }



    .hero-kv:hover {

        background: #fff;

        border-color: var(--border-light);

        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);

    }



    .kv-label {

        font-size: 10px;

        letter-spacing: 1.8px;

        color: var(--muted);

        text-transform: uppercase;

        font-weight: 700;

        margin-bottom: 6px;

    }



    .kv-value {

        font-size: 15px;

        color: var(--fg);

        font-weight: 700;

        letter-spacing: .3px;

    }



    .badge-status {

        font-size: 10px;

        font-weight: 700;

        padding: 5px 12px;

        border-radius: 8px;

        letter-spacing: .8px;

        display: inline-flex;

        align-items: center;

        gap: 5px;

    }



    .badge-status::before {

        content: "";

        width: 6px;

        height: 6px;

        border-radius: 50%;

        display: inline-block;

    }



    .badge-completed {

        background: var(--ok-bg);

        color: var(--ok);

        border: 1px solid var(--ok-border);

    }



    .badge-completed::before {

        background: var(--ok);

        box-shadow: 0 0 8px var(--ok);

    }



    .badge-in-progress {

        background: var(--info-bg);

        color: var(--info);

        border: 1px solid var(--info-border);

    }



    .badge-in-progress::before {

        background: var(--info);

        box-shadow: 0 0 8px var(--info);

    }



    .badge-on-hold {

        background: var(--warn-bg);

        color: var(--warn);

        border: 1px solid var(--warn-border);

    }



    .badge-on-hold::before {

        background: var(--warn);

        box-shadow: 0 0 8px var(--warn);

    }



    .badge-failed {

        background: var(--bad-bg);

        color: var(--bad);

        border: 1px solid var(--bad-border);

    }



    .badge-failed::before {

        background: var(--bad);

        box-shadow: 0 0 8px var(--bad);

    }



    .shift-chip {

        color: var(--fg-dim);

        font-size: 11px;

        font-weight: 500;

        background: var(--panel-2);

        border: 1px solid var(--border);

        padding: 4px 10px;

        border-radius: 6px;

        letter-spacing: .3px;

    }



    /* ─── Full-width single column layout ─── */

    .row-grid {

        display: grid;

        grid-template-columns: 1fr;

        gap: 20px;

        margin-bottom: 20px;

    }



    @media (max-width: 768px) {

        .hero-right {

            grid-template-columns: 1fr;

        }



        .main-container {

            padding: 20px 14px 40px;

        }



        .batch-hero {

            padding: 24px 20px;

        }

    }



    .stage-card {

        background: var(--panel);

        border: 1px solid var(--border);

        border-radius: 18px;

        padding: 24px;

        height: 100%;

        transition: all .35s cubic-bezier(.4, 0, .2, 1);

        position: relative;

        overflow: hidden;

        box-shadow: 0 1px 3px rgba(0, 0, 0, .03), 0 4px 16px -4px rgba(0, 0, 0, .04);

    }



    .stage-card::before {

        content: "";

        position: absolute;

        top: 0;

        left: 0;

        right: 0;

        height: 1px;

        background: linear-gradient(90deg, transparent, rgba(0, 0, 0, .06), transparent);

    }



    .stage-card:hover {

        border-color: var(--border-glow);

        transform: translateY(-3px);

        box-shadow: 0 8px 32px -4px rgba(234, 88, 12, .1), 0 4px 16px -4px rgba(0, 0, 0, .06);

    }



    .stage-head {

        display: flex;

        align-items: center;

        gap: 14px;

        padding-bottom: 18px;

        margin-bottom: 18px;

        border-bottom: 1px solid var(--border);

    }



    .stage-icon {

        width: 48px;

        height: 48px;

        border-radius: 12px;

        display: grid;

        place-items: center;

        font-size: 20px;

        position: relative;

        flex-shrink: 0;

    }



    .stage-icon.recipe-icon {

        background: linear-gradient(135deg, rgba(168, 85, 247, .12), rgba(168, 85, 247, .04));

        color: #a855f7;

        border: 1px solid rgba(168, 85, 247, .18);

    }



    .stage-icon.bake-icon {

        background: linear-gradient(135deg, rgba(249, 115, 22, .12), rgba(249, 115, 22, .04));

        color: var(--accent);

        border: 1px solid rgba(249, 115, 22, .18);

    }



    .stage-icon.metal-icon {

        background: linear-gradient(135deg, rgba(239, 68, 68, .12), rgba(239, 68, 68, .04));

        color: #ef4444;

        border: 1px solid rgba(239, 68, 68, .18);

    }



    .stage-icon.cool-icon {

        background: linear-gradient(135deg, rgba(59, 130, 246, .12), rgba(59, 130, 246, .04));

        color: #3b82f6;

        border: 1px solid rgba(59, 130, 246, .18);

    }



    .stage-icon.box-icon {

        background: linear-gradient(135deg, rgba(34, 197, 94, .12), rgba(34, 197, 94, .04));

        color: #22c55e;

        border: 1px solid rgba(34, 197, 94, .18);

    }



    .stage-title {

        font-size: 16px;

        font-weight: 700;

        color: var(--fg);

    }



    .stage-sub {

        font-size: 11px;

        color: var(--muted);

        text-transform: uppercase;

        letter-spacing: 1.2px;

        margin-top: 2px;

    }



    .stage-head-right {

        margin-left: auto;

        text-align: right;

    }



    .ing-table-wrap {

        overflow-x: auto;

        border-radius: 12px;

        border: 1px solid var(--border);

    }



    .ing-table {

        width: 100%;

        font-size: 13px;

        border-collapse: collapse;

        letter-spacing: .2px;

    }



    .ing-table thead th {

        color: var(--muted);

        font-size: 10px;

        letter-spacing: 1.5px;

        text-transform: uppercase;

        font-weight: 700;

        padding: 14px 16px;

        border-bottom: 1px solid var(--border-light);

        background: var(--panel-2);

        text-align: left;

        white-space: nowrap;

    }



    .ing-table tbody td {

        padding: 14px 16px;

        border-bottom: 1px solid var(--border);

        color: var(--fg-dim);

        transition: background .15s;

    }



    .ing-table tbody tr:hover td {

        background: rgba(234, 88, 12, .02);

    }



    .ing-table tbody tr:last-child td {

        border-bottom: none;

    }



    .ing-name {

        font-weight: 600;

        color: var(--fg);

    }



    .ing-bar {

        height: 5px;

        border-radius: 100px;

        background: var(--bg-3);

        overflow: hidden;

        min-width: 100px;

    }



    .ing-bar-fill {

        height: 100%;

        border-radius: 100px;

        background: linear-gradient(90deg, var(--accent), var(--accent-2));

        box-shadow: 0 0 8px rgba(249, 115, 22, .2);

    }



    .allergen-tag {

        display: inline-flex;

        align-items: center;

        gap: 4px;

        padding: 3px 10px;

        border-radius: 6px;

        background: var(--bad-bg);

        color: var(--bad);

        font-size: 10px;

        font-weight: 700;

        border: 1px solid var(--bad-border);

        letter-spacing: .5px;

    }



    .allergen-tag.none {

        background: var(--ok-bg);

        color: var(--ok);

        border-color: var(--ok-border);

    }



    /* ─── Metrics: 4-column for full-width cards ─── */

    .metrics-grid {

        display: grid;

        grid-template-columns: repeat(5, 1fr);

        gap: 12px;

    }



    .metrics-grid.cols-2 {

        grid-template-columns: repeat(2, 1fr);

        max-width: 480px;

    }



    @media (max-width: 992px) {

        .metrics-grid {

            grid-template-columns: repeat(2, 1fr);

        }



        .metrics-grid.cols-2 {

            max-width: none;

        }

    }



    @media (max-width: 576px) {

        .metrics-grid {

            grid-template-columns: 1fr;

        }

    }



    .metric-tile {

        background: var(--panel-2);

        border: 1px solid var(--border);

        border-radius: 14px;

        padding: 16px;

        transition: all .25s ease;

    }



    .metric-tile:hover {

        border-color: var(--border-light);

        background: #fff;

        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);

    }



    .metric-tile .label {

        font-size: 10px;

        color: var(--muted);

        text-transform: uppercase;

        letter-spacing: 1.5px;

        font-weight: 700;

    }



    .metric-tile .value {

        font-size: 22px;

        font-weight: 800;

        color: var(--fg);

        margin-top: 6px;

        line-height: 1;

        letter-spacing: .3px;

    }



    .metric-tile .unit {

        font-size: 12px;

        color: var(--muted);

        margin-left: 3px;

        font-weight: 500;

    }



    .temp-curve {

        background: var(--panel-2);

        border: 1px solid var(--border);

        border-radius: 12px;

        padding: 14px;

        margin-top: 14px;

        position: relative;

    }



    .temp-curve-label {

        font-size: 10px;

        color: var(--muted);

        text-transform: uppercase;

        letter-spacing: 1.5px;

        font-weight: 700;

        margin-bottom: 8px;

    }



    .metal-result {

        display: flex;

        align-items: center;

        gap: 16px;

        padding: 18px;

        border-radius: 14px;

        margin-bottom: 14px;

        transition: all .25s;

    }



    .metal-result.passed {

        background: var(--ok-bg);

        border: 1px solid var(--ok-border);

    }



    .metal-result.failed {

        background: var(--bad-bg);

        border-color: var(--bad-border);

    }



    .metal-result.pending {

        background: var(--panel-2);

        border-color: var(--border-light);

    }



    .metal-check-icon {

        width: 52px;

        height: 52px;

        border-radius: 14px;

        display: grid;

        place-items: center;

        font-size: 24px;

        flex-shrink: 0;

    }



    .metal-result.passed .metal-check-icon {

        background: rgba(22, 163, 74, .12);

        color: var(--ok);

        box-shadow: 0 0 20px rgba(22, 163, 74, .1);

    }



    .metal-result.failed .metal-check-icon {

        background: rgba(220, 38, 38, .12);

        color: var(--bad);

    }



    .metal-result.pending .metal-check-icon {

        background: var(--bg-3);

        color: var(--muted);

    }



    .metal-text-main {

        font-weight: 700;

        font-size: 16px;

        color: var(--fg);

    }



    .metal-result.passed .metal-text-main {

        color: var(--ok);

    }



    .metal-result.failed .metal-text-main {

        color: var(--bad);

    }



    .metal-text-sub {

        font-size: 11px;

        color: var(--muted);

        margin-top: 3px;

        letter-spacing: .2px;

    }



    .qc-row {

        display: flex;

        justify-content: space-between;

        align-items: center;

        padding: 16px;

        background: var(--panel-2);

        border: 1px solid var(--border);

        border-radius: 14px;

        margin-top: 10px;

    }



    .qc-stamp {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        padding: 8px 16px;

        border-radius: 10px;

        border: 2px solid var(--ok);

        color: var(--ok);

        font-weight: 800;

        font-size: 12px;

        letter-spacing: .5px;

        background: var(--ok-bg);

        transform: rotate(-1.5deg);

    }



    .qc-stamp.pending {

        border-color: var(--warn);

        color: var(--warn);

        background: var(--warn-bg);

    }



    .empty-state {

        text-align: center;

        padding: 80px 24px;

        position: relative;

    }



    .empty-state::before {

        content: "";

        position: absolute;

        top: 50%;

        left: 50%;

        transform: translate(-50%, -50%);

        width: 300px;

        height: 300px;

        background: radial-gradient(circle, var(--accent-glow-strong), transparent 70%);

        pointer-events: none;

        opacity: .3;

    }



    .empty-icon-wrap {

        width: 100px;

        height: 100px;

        border-radius: 28px;

        background: var(--panel);

        border: 1px solid var(--border-light);

        display: inline-grid;

        place-items: center;

        margin-bottom: 28px;

        position: relative;

        box-shadow: 0 8px 32px rgba(0, 0, 0, .06);

    }



    .empty-icon-wrap i {

        font-size: 40px;

        color: var(--muted);

        opacity: .6;

    }



    .empty-icon-wrap::after {

        content: "";

        position: absolute;

        inset: -1px;

        border-radius: 28px;

        background: linear-gradient(135deg, var(--accent-glow-strong), transparent 50%);

        z-index: -1;

        opacity: .5;

    }



    .empty-title {

        font-size: 22px;

        font-weight: 800;

        color: var(--fg);

        margin-bottom: 10px;

        letter-spacing: -0.3px;

    }



    .empty-desc {

        font-size: 14px;

        color: var(--fg-dim);

        max-width: 380px;

        margin: 0 auto 28px;

        line-height: 1.6;

    }



    .empty-example {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        padding: 10px 18px;

        border-radius: 10px;

        background: var(--panel);

        border: 1px solid var(--border-light);

        font-size: 13px;

        color: var(--accent);

        font-weight: 600;

        letter-spacing: .3px;

        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);

    }



    /* ─── Compact Empty State ─── */

    .empty-state-compact {

        text-align: center;

        padding: 32px 20px;

        background: var(--panel-2);

        border: 1px dashed var(--border-light);

        border-radius: 16px;

        margin: 12px 0 4px;

    }



    .empty-state-compact .empty-icon {

        width: 52px;

        height: 52px;

        border-radius: 14px;

        background: var(--accent-glow);

        color: var(--accent);

        display: inline-flex;

        align-items: center;

        justify-content: center;

        font-size: 24px;

        margin-bottom: 12px;

        border: 1px solid var(--border-glow);

    }



    .empty-state-compact .empty-title {

        font-size: 15px;

        font-weight: 700;

        color: var(--fg);

        margin-bottom: 4px;

        letter-spacing: -0.2px;

    }



    .empty-state-compact .empty-sub {

        font-size: 13px;

        color: var(--muted);

        margin: 0;

    }



    /* ─── Batch Action Buttons ─── */

    .btn-action-approve {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        background: linear-gradient(135deg, #16a34a, #15803d);

        color: #ffffff;

        border: none;

        padding: 11px 24px;

        border-radius: 12px;

        font-weight: 700;

        font-size: 13.5px;

        cursor: pointer;

        letter-spacing: .4px;

        box-shadow: 0 4px 16px -2px rgba(22, 163, 74, .35);

        transition: all .25s cubic-bezier(.4, 0, .2, 1);

    }



    .btn-action-approve:hover {

        transform: translateY(-2px);

        box-shadow: 0 6px 24px -2px rgba(22, 163, 74, .5);

        background: linear-gradient(135deg, #22c55e, #16a34a);

    }



    .btn-action-approve:active {

        transform: translateY(0);

    }



    .btn-action-reject {

        display: inline-flex;

        align-items: center;

        gap: 8px;

        background: linear-gradient(135deg, #dc2626, #b91c1c);

        color: #ffffff;

        border: none;

        padding: 11px 24px;

        border-radius: 12px;

        font-weight: 700;

        font-size: 13.5px;

        cursor: pointer;

        letter-spacing: .4px;

        box-shadow: 0 4px 16px -2px rgba(220, 38, 38, .35);

        transition: all .25s cubic-bezier(.4, 0, .2, 1);

    }



    .btn-action-reject:hover {

        transform: translateY(-2px);

        box-shadow: 0 6px 24px -2px rgba(220, 38, 38, .5);

        background: linear-gradient(135deg, #ef4444, #dc2626);

    }



    .btn-action-reject:active {

        transform: translateY(0);

    }



    .empty-example span {

        color: var(--muted);

        font-size: 12px;

        font-weight: 400;

    }



    ::-webkit-scrollbar {

        width: 6px;

        height: 6px;

    }



    ::-webkit-scrollbar-track {

        background: transparent;

    }



    ::-webkit-scrollbar-thumb {

        background: rgba(0, 0, 0, .1);

        border-radius: 100px;

    }



    ::-webkit-scrollbar-thumb:hover {

        background: rgba(0, 0, 0, .18);

    }



    @keyframes fadeUp {

        from {

            opacity: 0;

            transform: translateY(20px);

        }



        to {

            opacity: 1;

            transform: translateY(0);

        }

    }



    .animate-in {

        animation: fadeUp .5s cubic-bezier(.4, 0, .2, 1) both;

    }



    .delay-1 {

        animation-delay: .05s;

    }



    .delay-2 {

        animation-delay: .1s;

    }



    .delay-3 {

        animation-delay: .15s;

    }



    .delay-4 {

        animation-delay: .2s;

    }



    .delay-5 {

        animation-delay: .25s;

    }



    .top-actions {

        display: flex;

        justify-content: flex-end;

        margin-bottom: 16px;

    }



    /* ─── Test Type Badge ─── */

    .test-type-badge {

        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 6px 14px;

        border-radius: 8px;

        background: linear-gradient(135deg, rgba(37, 99, 235, .1), rgba(37, 99, 235, .04));

        color: var(--info);

        font-size: 13px;

        font-weight: 700;

        border: 1px solid var(--info-border);

        letter-spacing: .3px;

    }



    /* ─── Checklist ─── */

    .checklist-wrap {

        border: 1px solid var(--border);

        border-radius: 14px;

        overflow: hidden;

        background: var(--panel-2);

    }



    .checklist-title-row {

        display: flex;

        align-items: center;

        justify-content: space-between;

        padding: 14px 18px;

        border-bottom: 1px solid var(--border);

        background: var(--panel);

    }



    .checklist-label {

        font-size: 11px;

        color: var(--muted);

        text-transform: uppercase;

        letter-spacing: 1.5px;

        font-weight: 700;

    }



    .checklist-count {

        font-size: 12px;

        font-weight: 700;

        color: var(--ok);

        background: var(--ok-bg);

        border: 1px solid var(--ok-border);

        padding: 4px 12px;

        border-radius: 100px;

        letter-spacing: .3px;

    }



    .checklist-table {

        width: 100%;

        border-collapse: collapse;

        font-size: 13px;

    }



    .checklist-table thead th {

        color: var(--muted);

        font-size: 10px;

        letter-spacing: 1.5px;

        text-transform: uppercase;

        font-weight: 700;

        padding: 12px 18px;

        background: var(--panel-2);

        border-bottom: 1px solid var(--border-light);

        text-align: left;

        white-space: nowrap;

    }



    .checklist-table tbody td {

        padding: 14px 18px;

        border-bottom: 1px solid var(--border);

        color: var(--fg-dim);

        vertical-align: middle;

        transition: background .15s;

    }



    .checklist-table tbody tr:hover td {

        background: rgba(234, 88, 12, .02);

    }



    .checklist-table tbody tr:last-child td {

        border-bottom: none;

    }



    /* ─── Checklist Status Badges ─── */

    .cl-pass,

    .cl-fail,

    .cl-na {

        display: inline-flex;

        align-items: center;

        gap: 5px;

        padding: 4px 12px;

        border-radius: 6px;

        font-size: 11px;

        font-weight: 700;

        letter-spacing: .4px;

    }



    .cl-pass {

        background: var(--ok-bg);

        color: var(--ok);

        border: 1px solid var(--ok-border);

    }



    .cl-fail {

        background: var(--bad-bg);

        color: var(--bad);

        border: 1px solid var(--bad-border);

    }



    .cl-na {

        background: var(--panel-2);

        color: var(--muted);

        border: 1px solid var(--border-light);

    }
</style>



<div class="card">

    <div class="card-body">

        <div class="main-container">



            <div class="top-actions">

                <a class="btn-ghost btn" href="admin.php?id=trace">

                    <i class="bi bi-arrow-left mr-2"></i>Back to List

                </a>

            </div>



            <section id="detail">



                <div class="batch-hero animate-in delay-2">



                    <?php

                    $mainm = mysqli_query($con, "SELECT m.*, r.name as rname, m.user as muser FROM `tblmarination` as m join tblrecipe as r on m.name = r.id WHERE m.id='$batch'");

                    $brt = mysqli_fetch_assoc($mainm);

                    $batchcode = $brt['batchcode'];



                    if ($brt['confirm'] == 'Waiting') {

                        $statusb = "badge-on-hold";
                    } else if ($brt['confirm'] == 'Approved') {

                        $statusb = "badge-completed";
                    } else {

                        $statusb = "badge-failed";
                    }





                    $receipeuser = $brt['muser'];

                    $receipeuserdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$receipeuser' and c1.type ='Procedure' and c1.status='Active'");

                    $receipeusercert1 = mysqli_fetch_assoc($receipeuserdet);



                    ?>



                    <div class="hero-left">

                        <?php

                        if ($create == '1') {

                        ?>

                            <span class="badge-status <?= $statusb ?> mb-2"><?= $brt['confirm'] ?></span>

                        <?php

                        }

                        ?>

                        <h3><?= $brt['rname'] ?></h3>

                        <div class="hero-batch-id mono"><?= $brt['batchcode'] ?></div>

                    </div>

                    <div class="hero-right">

                        <div class="hero-kv">

                            <div class="kv-label">Date</div>

                            <div class="kv-value mono"><?= date('d F Y', strtotime($brt['date'])) ?></div>

                        </div>

                        <div class="hero-kv">

                            <div class="kv-label">Product Qty</div>

                            <div class="kv-value" style="font-size:13px;"><?= $brt['quantity'] ?></div>

                        </div>

                        <div class="hero-kv">

                            <div class="kv-label">Use By Date</div>

                            <div class="kv-value mono"><?= date('d F Y', strtotime($brt['useby1'])) ?></div>

                        </div>

                        <?php

                        if (!empty($brt['stime'])) {

                        ?>

                            <div class="hero-kv">

                                <div class="kv-label">Start Time</div>

                                <div class="kv-value mono"><?= date('h:i A', strtotime($brt['stime'])) ?></div>

                            </div>

                        <?php

                        }

                        ?>



                    </div>

                </div>



                <div class="row-grid">



                    <!-- Recipe Record -->

                    <div class="animate-in delay-3">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon recipe-icon"><i class="bi bi-file-earmark-richtext-fill"></i>

                                </div>

                                <div>

                                    <div class="stage-title">Recipe Record</div>



                                    <!-- user detail of attempt -->

                                    <?php

                                    if (isset($receipeusercert1['certdate']) && $receipeusercert1['certdate'] != '') {

                                        $date = new DateTime($receipeusercert1['certdate']);

                                        $date->modify('-3 years');

                                        $cerdate = $date->format('d-m-Y');
                                    } else {

                                        $cerdate = 'Not Trained';
                                    }



                                    // User Photo

                                    if (isset($receipeusercert1['simg']) && $receipeusercert1['simg'] != '') {

                                        $userPhoto = 'student/' . $receipeusercert1['simg'];
                                    } else {

                                        $userPhoto = '#';
                                    }



                                    // User Certificate

                                    if (isset($receipeusercert1['certificate']) && $receipeusercert1['certificate'] != '') {

                                        $userCertificate = 'student/' . $receipeusercert1['certificate'];
                                    } else {

                                        $userCertificate = '';
                                    }



                                    ?>

                                    <div class=" h6">Attempt By (Training Date) :

                                        <a href="#" class="openModalLink hover-pop"  id="openModalLink"

                                            data-name="<?= $receipeuser ?>" data-pic="<?= $userPhoto ?>"

                                            data-cert-date="<?= $cerdate ?>" data-pdf="<?= $userCertificate ?>"

                                            data-pdf-label="Training Document">

                                            <?= htmlspecialchars($receipeuser) ?>

                                            (<?= $cerdate ?>)

                                        </a>

                                    </div>

                                </div>

                                <div class="stage-head-right ">

                                    <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                            href="admin.php?id=reciepereport&sno=<?= $batchcode ?>" target="_blank"

                                            class="btn-ghost btn text-info"><i

                                                class="bi bi-file-earmark-richtext-fill"></i> View Report</a><br>

                                    </div>



                                </div>

                            </div>





                            <div class="ing-table-wrap">

                                <table class="ing-table">

                                    <thead>

                                        <tr>

                                            <th>#</th>

                                            <th>Ingredient</th>

                                            <th>Quantity Used</th>

                                            <th>Allergen</th>

                                            <th>Use By</th>

                                            <th>Batchcode</th>

                                            <th>Supplier</th>

                                            <th>Goods In Date</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        $mainsub = mysqli_query($con, "SELECT m1.*, r.pname,r.id as rid,g.grncode as grncode, s.supid as supid,r.riskall as riskall, s.supname, g.date as gooddate, g.useby as guseby, g.batchcode as gcode FROM `tblmarination1` as m1 JOIN tblrawsupplier as s JOIN tblrawmaterial as r JOIN tblgrn1 as g ON m1.pid = r.id AND m1.supplier = s.supid AND m1.grnid = g.id WHERE m1.batchcode ='$batchcode'");



                                        $mainsubn = mysqli_num_rows($mainsub);

                                        if ($mainsubn == 0) {

                                        ?>

                                            <tr>

                                                <td colspan="7" class="text-center">No Record Found</td>

                                            </tr>

                                            <?php

                                        } else {



                                            $i = 1;

                                            foreach ($mainsub as $subdata) {







                                                $rawspec = mysqli_query($con, "SELECT * FROM `tblrawspecdetail` WHERE status !='archived' and product ='$subdata[rid]'  ");

                                                $sqw = mysqli_fetch_assoc($rawspec);



                                                $subgrnc = $subdata['grncode'];



                                                $goods1 = mysqli_query($con, "SELECT * FROM `tblgrnno2` WHERE grnno='$subgrnc'");



                                                $sq1 = mysqli_fetch_assoc($goods1);





                                            ?>

                                                <tr>

                                                    <td style="color:var(--muted);"><?= $i ?></td>

                                                    <td class="ing-name"><a href="specdetail/<?= $sqw['spec'] ?>"

                                                            target="_blank"

                                                            rel="noopener noreferrer"><?= $subdata['product'] ?></a></td>

                                                    <td style="color:var(--muted);">

                                                        <?= $subdata['totalqty'] . ' ' . $subdata['qty1'] ?>

                                                    </td>

                                                    <td style="color:var(--muted);">

                                                        <?php echo !empty($subdata['riskall']) ? $subdata['riskall'] : 'None'; ?>

                                                    </td>

                                                    <td><?= date('d F Y', strtotime($subdata['guseby'])) ?></td>

                                                    <td><a href="admin.php?id=massbalance&mid=<?= $subdata['grnid'] ?>"

                                                            target="_blank" class="hover-pop"

                                                            rel="noopener noreferrer"><?= $subdata['gcode'] ?></a></td>

                                                    <td> <a href="admin.php?id=trace_supplier&view=<?= $subdata['supid'] ?>"

                                                            target="_blank"  class="hover-pop"

                                                            rel="noopener noreferrer"><?= $subdata['supname'] ?></a></td>

                                                    <td><a href="admin.php?id=goodsinreport&sno=<?= $sq1['id'] ?>"  class="hover-pop"

                                                            target="_blank"><?= date('d F Y', strtotime($subdata['gooddate'])) ?></a>

                                                    </td>



                                                </tr>

                                        <?php

                                                $i++;
                                            }
                                        }

                                        ?>

                                        <tr>

                                            <td style="color:var(--muted);"><?= $i ?></td>

                                            <td class="ing-name">Water</td>

                                            <td style="color:var(--muted);">

                                                <?= $brt['water'] ?>

                                            </td>

                                            <td style="color:var(--muted);">

                                                None

                                            </td>

                                            <td>N/A</td>

                                            <td>N/A</td>

                                            <td>N/A</td>



                                            <td>N/A</td>



                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <?php

                    $prob = mysqli_query($con, "SELECT * FROM `trace_doc` where id='1'");

                    $prob1 = mysqli_fetch_assoc($prob);

                    $probname = $prob1['name'];

                    $probserial = $prob1['serial'];

                    $probcertificate = $prob1['path'];



                    $procd = mysqli_query($con, "SELECT * FROM `trace_doc` where id='3'");

                    $procd1 = mysqli_fetch_assoc($procd);

                    $procdcertificate = $procd1['path'];





                    $baketray = mysqli_query($con, "SELECT distinct tray FROM `tblbaking` WHERE productbatch='$batchcode'");



                    foreach ($baketray as $traydata) {

                        $tray = $traydata['tray'];









                    ?>

                        <!-- Baking -->

                        <div class="animate-in delay-3">

                            <div class="stage-card">

                                <div class="stage-head">

                                    <div class="stage-icon bake-icon"><i class="bi bi-fire"></i></div>

                                    <div>

                                        <div class="stage-title">Baking (<?= $tray ?>)</div>

                                        <div class="stage-sub text-danger"><b>Critical limit</b> : 120&deg;C or

                                            above</div>



                                        <div class="stage-sub text-danger"> <b>Equipment Name :</b> <?= $probname ?>

                                        </div>

                                        <div class="stage-sub text-danger"><b>Serial No :</b> <?= $probserial ?></div>

                                        <div class="stage-sub text-danger"><b>Calibration Certificate :</b> <a

                                                href="<?= $probcertificate ?>"  class="hover-pop" target="_blank" rel="noopener noreferrer"><i

                                                    class="bi bi-file-pdf"></i> view certificate</a></div>

                                        <div class="stage-sub text-danger"><b>Procedure :</b> <a

                                                href="<?= $procdcertificate ?>"  class="hover-pop" target="_blank" rel="noopener noreferrer"><i

                                                    class="bi bi-file-text"></i> view procedure</a></div>

                                    </div>

                                    <div class="stage-head-right ">

                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=bakingreport&batch=<?= $batchcode ?>&bake=<?= $tray ?>"

                                                target="_blank" class="btn-ghost btn

                                                text-info"><i class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>

                                </div>



                                <?php



                                $baking = mysqli_query($con, "SELECT * FROM `tblbaking` WHERE productbatch='$batchcode' and tray='$tray'");

                                foreach ($baking as $bakedata) {

                                    $detuser = $bakedata['user'];

                                    $userdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$detuser' and c1.type ='Procedure' and c1.status='Active'");

                                    $usercert1 = mysqli_fetch_assoc($userdet);

                                ?>

                                    <div class="metrics-grid cols-4 mb-2">

                                        <div class="metric-tile">

                                            <div class="label">Date</div>

                                            <div class="h4"><?= date('d F Y', strtotime($bakedata['datetime'])) ?>

                                            </div>

                                        </div>

                                        <div class="metric-tile">

                                            <div class="label">Time</div>

                                            <div class="h4"><?= date('h:i A', strtotime($bakedata['datetime'])) ?>

                                            </div>

                                        </div>

                                        <?php

                                        if (intval($bakedata['temp']) < 120) {

                                            $tempb = '#dc143c ';
                                        } else {

                                            $tempb = 'green';
                                        }



                                        ?>

                                        <div class="metric-tile">

                                            <div class="label">Temperature</div>

                                            <div class="h4" style="color:<?= $tempb ?>;"><?= $bakedata['temp'] ?>°C</div>

                                        </div>

                                        <div class="metric-tile">

                                            <div class="label">Oven Used</div>

                                            <div class="h4 text-info"><?= $bakedata['tray'] ?></div>

                                        </div>

                                        <!-- user detail of attempt -->

                                        <?php

                                        if (isset($usercert1['certdate']) && $usercert1['certdate'] != '') {

                                            $date = new DateTime($usercert1['certdate']);

                                            $date->modify('-3 years');

                                            $cerdate = $date->format('d-m-Y');
                                        } else {

                                            $cerdate = 'Not Trained';
                                        }



                                        // User Photo

                                        if (isset($usercert1['simg']) && $usercert1['simg'] != '') {

                                            $userPhoto = 'student/' . $usercert1['simg'];
                                        } else {

                                            $userPhoto = '#';
                                        }



                                        // User Certificate

                                        if (isset($usercert1['certificate']) && $usercert1['certificate'] != '') {

                                            $userCertificate = 'student/' . $usercert1['certificate'];
                                        } else {

                                            $userCertificate = '';
                                        }



                                        ?>

                                        <div class="metric-tile">

                                            <div class="label">Attempt By (Training Date) </div>

                                            <div class="h4 text-primary">

                                                <a href="#" class="openModalLink hover-pop" id="openModalLink" data-name="<?= $detuser ?>"

                                                    data-pic="<?= $userPhoto ?>" data-cert-date="<?= $cerdate ?>"

                                                    data-pdf="<?= $userCertificate ?>" data-pdf-label="Training Document">

                                                    <?= htmlspecialchars($detuser) ?>

                                                    (<?= $cerdate ?>)

                                                </a>

                                            </div>





                                        </div>

                                    </div>

                                <?php

                                }

                                ?>

                            </div>

                        </div>

                    <?php

                    }





                    $cooltray = mysqli_query($con, "SELECT distinct tray FROM `tblcooling` WHERE productbatch='$batchcode'");



                    foreach ($cooltray as $ctraydata) {

                        $ctray = $ctraydata['tray'];

                    ?>



                        <!-- Cooling -->



                        <div class="animate-in delay-4">

                            <div class="stage-card">

                                <div class="stage-head">

                                    <div class="stage-icon cool-icon"><i class="bi bi-snow"></i></div>

                                    <div>

                                        <div class="stage-title">Cooling (<?= $ctray; ?>)</div>

                                        <div class="stage-sub text-danger"><b>Critical limit :</b> 25&deg;C or

                                            below</div>

                                        <div class="stage-sub text-danger"> <b>Equipment Name :</b> <?= $probname ?>

                                        </div>

                                        <div class="stage-sub text-danger"><b>Serial No :</b> <?= $probserial ?></div>

                                        <div class="stage-sub text-danger"><b>Calibration Certificate :</b> <a

                                                href="<?= $probcertificate ?>"  class="hover-pop" target="_blank" rel="noopener noreferrer"><i

                                                    class="bi bi-file-pdf"></i> view certificate</a></div>

                                        <div class="stage-sub text-danger"><b>Procedure :</b> <a

                                                href="<?= $procdcertificate ?>"  class="hover-pop" target="_blank" rel="noopener noreferrer"><i

                                                    class="bi bi-file-text"></i> view procedure</a></div>

                                    </div>



                                    <div class="stage-head-right ">

                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=coolingreport&batch=<?= $batchcode ?>&cool=<?= $ctray ?>"

                                                target="_blank" class="btn-ghost btn

                                                text-info"><i class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>

                                </div>





                                <?php

                                $cool = mysqli_query($con, "SELECT * FROM `tblcooling` WHERE `productbatch`='$batchcode' and tray='$ctray'");

                                $coolr = mysqli_fetch_assoc($cool);



                                while ($coolr = mysqli_fetch_assoc($cool)) {

                                    $cdetuser = $coolr['user'];

                                    $cuserdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$cdetuser' and c1.type ='Procedure' and c1.status='Active'");

                                    $cusercert1 = mysqli_fetch_assoc($cuserdet);





                                ?>

                                    <div class="metrics-grid cols-4 mb-2">

                                        <div class="metric-tile">

                                            <div class="label">Date</div>

                                            <div class="h4"><?= date('d-m-Y', strtotime($coolr['datetime'])); ?>

                                            </div>

                                        </div>

                                        <div class="metric-tile">

                                            <div class="label">Time</div>

                                            <div class="h4"><?= date('h:i A', strtotime($coolr['datetime'])); ?>

                                            </div>

                                        </div>

                                        <div class="metric-tile">

                                            <div class="label">Temperature</div>

                                            <?php

                                            if (intval($coolr['temp']) > 25) {

                                                $tempc = '#dc143c ';
                                            } else {

                                                $tempc = 'green';
                                            }



                                            ?>

                                            <div class="h4" style="color:<?= $tempc ?>;"><?= $coolr['temp'] ?>°C</div>

                                        </div>

                                        <div class="metric-tile">

                                            <div class="label">Cooling Spirals</div>

                                            <div class="h4 text-info"> <?= $coolr['tray'] ?></div>

                                        </div>

                                        <!-- user detail of attempt -->

                                        <?php

                                        if (isset($cusercert1['certdate']) && $cusercert1['certdate'] != '') {

                                            $date = new DateTime($usercert1['certdate']);

                                            $date->modify('-3 years');

                                            $cerdate = $date->format('d-m-Y');
                                        } else {

                                            $cerdate = 'Not Trained';
                                        }



                                        // User Photo

                                        if (isset($cusercert1['simg']) && $cusercert1['simg'] != '') {

                                            $userPhoto = 'student/' . $cusercert1['simg'];
                                        } else {

                                            $userPhoto = '#';
                                        }



                                        // User Certificate

                                        if (isset($cusercert1['certificate']) && $cusercert1['certificate'] != '') {

                                            $userCertificate = 'student/' . $cusercert1['certificate'];
                                        } else {

                                            $userCertificate = '';
                                        }



                                        ?>

                                        <div class="metric-tile">

                                            <div class="label">Attempt By (Training Date) </div>

                                            <div class="h4 text-primary">

                                                <a href="#" class="openModalLink hover-pop" id="openModalLink"

                                                    data-name="<?= $cdetuser ?>" data-pic="<?= $userPhoto ?>"

                                                    data-cert-date="<?= $cerdate ?>" data-pdf="<?= $userCertificate ?>"

                                                    data-pdf-label="Training Document">

                                                    <?= htmlspecialchars($cdetuser) ?>

                                                    (<?= $cerdate ?>)

                                                </a>

                                            </div>

                                        </div>



                                    </div>

                                <?php

                                }



                                ?>





                            </div>

                        </div>

                    <?php

                    }



                    ?>





                    <!-- Packaging -->

                    <div class="animate-in delay-5">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon box-icon"><i class="bi bi-box-seam"></i></div>

                                <div>

                                    <div class="stage-title">Packaging Record</div>



                                </div>

                                <div class="stage-head-right ">

                                    <div class="stage-head-right ">

                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=packagingreport&batch=<?= $batchcode ?>" class="btn-ghost

                                                btn text-info" target="_blank"><i

                                                    class="bi bi-file-earmark-richtext-fill" target="_blank"></i> View

                                                Report</a></div>



                                    </div>

                                </div>



                            </div>

                            <?php

                            $packing = mysqli_query($con, "SELECT * FROM  `tblpacking` WHERE `productbatch`='$batchcode'");

                            $packingn = mysqli_num_rows($packing);

                            if ($packingn == 0) {

                            ?>

                                <div class="empty-state-compact">

                                    <div class="empty-icon">

                                        <i class="bi bi-box-seam"></i>

                                    </div>

                                    <div class="empty-title">No Record Found</div>

                                    <div class="empty-sub">No Packaging details have been recorded for this batch code.

                                    </div>

                                </div>

                                <?php

                            } else {

                                foreach ($packing as $packing1) {

                                    $packdetuser = $packing1['user'];

                                    $packuserdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$packdetuser' and c1.type ='Procedure' and c1.status='Active'");

                                    $packusercert1 = mysqli_fetch_assoc($packuserdet);

                                ?>

                                    <div

                                        style="display:flex; align-items:flex-start; gap:24px; flex-wrap:wrap;margin-bottom:10px;">

                                        <div class="metrics-grid cols-4" style="flex:1 1 240px; margin-bottom:0;">

                                            <div class="metric-tile">

                                                <div class="label">Date </div>

                                                <div class="h4">

                                                    <?= date('d-m-Y', strtotime($packing1['datetime'])); ?>

                                                </div>

                                            </div>

                                            <div class="metric-tile">

                                                <div class="label">Time</div>

                                                <div class="h4">

                                                    <?= date('h:i A', strtotime($packing1['datetime'])); ?>

                                                </div>

                                            </div>

                                            <div class="metric-tile">

                                                <a href="admin.php?id=boxingpo&po=<?= $packing1['packfilm'] ?>" target="_blank">

                                                    <div class="label">Top Film Batchcode</div>

                                                    <div class="h4 text-info">

                                                        <?= $packing1['packfilm'] ?>

                                                    </div>

                                                </a>

                                            </div>

                                            <div class="metric-tile">

                                                <a href="admin.php?id=boxingpo&po=<?= $packing1['botfilm'] ?>">

                                                    <div class="label">Bottom Film Batchcode</div>

                                                    <div class="h4 text-info">

                                                        <?= $packing1['botfilm'] ?>

                                                    </div>

                                                </a>

                                            </div>

                                            <!-- user detail of attempt -->

                                            <?php

                                            if (isset($packusercert1['certdate']) && $packusercert1['certdate'] != '') {

                                                $date = new DateTime($packusercert1['certdate']);

                                                $date->modify('-3 years');

                                                $cerdate = $date->format('d-m-Y');
                                            } else {

                                                $cerdate = 'Not Trained';
                                            }



                                            // User Photo

                                            if (isset($packusercert1['simg']) && $packusercert1['simg'] != '') {

                                                $userPhoto = 'student/' . $packusercert1['simg'];
                                            } else {

                                                $userPhoto = '#';
                                            }



                                            // User Certificate

                                            if (isset($packusercert1['certificate']) && $packusercert1['certificate'] != '') {

                                                $userCertificate = 'student/' . $packusercert1['certificate'];
                                            } else {

                                                $userCertificate = '';
                                            }



                                            ?>

                                            <div class="metric-tile">

                                                <div class="label">Attempt By (Training Date) </div>

                                                <div class="h4 text-primary">

                                                    <a href="#" class="openModalLink hover-pop" id="openModalLink"

                                                        data-name="<?= $packdetuser ?>" data-pic="<?= $userPhoto ?>"

                                                        data-cert-date="<?= $cerdate ?>" data-pdf="<?= $userCertificate ?>"

                                                        data-pdf-label="Training Document">

                                                        <?= htmlspecialchars($packdetuser) ?>

                                                        (<?= $cerdate ?>)

                                                    </a>

                                                </div>





                                            </div>





                                        </div>

                                    </div>

                            <?php

                                }
                            }

                            ?>



                        </div>

                    </div>



                    <?php



                    $metalprocd = mysqli_query($con, "SELECT * FROM `trace_doc` where id='5'");

                    $metalprocd1 = mysqli_fetch_assoc($metalprocd);

                    $metalprocdcertificate = $metalprocd1['path'];

                    ?>

                    <!-- Metal Detection -->

                    <div class="animate-in delay-4">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon metal-icon"><i class="bi bi-magnet"></i></div>

                                <div>

                                    <div class="stage-title">Metal Detection</div>

                                    <div class="stage-sub text-danger"><b>Procedure :</b> <a

                                            href="<?= $metalprocdcertificate ?>"  class="hover-pop" target="_blank"

                                            rel="noopener noreferrer"><i class="bi bi-file-text"></i> view procedure</a>

                                    </div>

                                </div>

                                <div class="stage-head-right ">

                                    <div class="stage-head-right ">

                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=metalreport&batch=<?= $batchcode ?>" class="btn-ghost btn

                                                text-info" target="_blank"><i

                                                    class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>

                                </div>

                            </div>



                            <?php

                            $metalm = mysqli_query($con, "SELECT * FROM `tblmetal` WHERE productbatch ='$batchcode'");

                            $metalmn = mysqli_num_rows($metalm);

                            if ($metalmn == 0) {

                            ?>

                                <div class="empty-state-compact">

                                    <div class="empty-icon">

                                        <i class="bi bi-magnet"></i>

                                    </div>

                                    <div class="empty-title">No Record Found</div>

                                    <div class="empty-sub">No metal details have been recorded for this batch code.

                                    </div>

                                </div>

                                <?php

                            } else {

                                foreach ($metalm as $metalmr) {

                                    $ansar = explode(';', $metalmr['ans']);



                                    $testmty = $metalmr['testtype'];

                                    $metaluser = $metalmr['user'];

                                    $metaluserdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$metaluser' and c1.type ='Procedure' and c1.status='Active'");

                                    $metalusercert1 = mysqli_fetch_assoc($metaluserdet);

                                ?>



                                    <!-- Top: Result + Test Type + Gas Reading -->

                                    <div

                                        style="display:flex; align-items:stretch; gap:16px; flex-wrap:wrap; margin-bottom:20px;">



                                        <!-- Result Block -->

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Date Time</div>

                                            <div style="margin-top:8px;">

                                                <span

                                                    class="test-type-badge"><?= date('d-m-Y h:i A', strtotime($metalmr['datetime'])); ?></span>

                                            </div>

                                        </div>

                                        <!-- Test Type -->

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Test Type</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['testtype'] ?></span>

                                            </div>

                                        </div>





                                        <!-- Gas Reading -->

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Gas Reading</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['gas'] ?></span>

                                            </div>

                                        </div>

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Is correct packaging film being used?</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['pack1'] ?></span>

                                            </div>

                                        </div>

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Any correction needed ?</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['pack2'] ?></span>

                                            </div>

                                        </div>





                                        <!-- user detail of attempt -->

                                        <?php

                                        if (isset($metalusercert1['certdate']) && $metalusercert1['certdate'] != '') {

                                            $date = new DateTime($metalusercert1['certdate']);

                                            $date->modify('-3 years');

                                            $mcerdate = $date->format('d-m-Y');
                                        } else {

                                            $cerdate = 'Not Trained';
                                        }



                                        // User Photo

                                        if (isset($metalusercert1['simg']) && $metalusercert1['simg'] != '') {

                                            $userPhoto = 'student/' . $metalusercert1['simg'];
                                        } else {

                                            $userPhoto = '#';
                                        }



                                        // User Certificate

                                        if (isset($metalusercert1['certificate']) && $metalusercert1['certificate'] != '') {

                                            $userCertificate = 'student/' . $metalusercert1['certificate'];
                                        } else {

                                            $userCertificate = '';
                                        }



                                        ?>

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Attempt By (Training Date) </div>

                                            <div class="h4 text-primary">

                                                <a href="#" class="openModalLink hover-pop" id="openModalLink"

                                                    data-name="<?= $metaluser ?>" data-pic="<?= $userPhoto ?>"

                                                    data-cert-date="<?= $mcerdate ?>" data-pdf="<?= $userCertificate ?>"

                                                    data-pdf-label="Training Document">

                                                    <?= htmlspecialchars($metaluser) ?>

                                                    (<?= $cerdate ?>)

                                                </a>

                                            </div>





                                        </div>



                                    </div>



                                    <!-- Checklist Questions -->

                                    <div class="checklist-wrap">

                                        <div class="checklist-title-row">

                                            <div class="checklist-label">Inspection Checklist</div>

                                        </div>

                                        <table class="checklist-table" width="100%">

                                            <thead>

                                                <tr>

                                                    <th style="width:40px;">#</th>

                                                    <th>Question</th>

                                                    <th style="width:100px;">Status</th>



                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php

                                                $m = 0;

                                                $metalq = mysqli_query($con, "SELECT * FROM `tblques2` WHERE status='$testmty'");

                                                while ($metalqr = mysqli_fetch_array($metalq)) {

                                                    if ($ansar[$m] = 'Yes') {

                                                        $color = 'cl-pass';

                                                        $cicon = 'bi-check-circle-fill';
                                                    } else {

                                                        $color = 'cl-fail';

                                                        $cicon = 'bi-x-circle-fill';
                                                    }



                                                ?>



                                                    <tr>

                                                        <td style="color:var(--muted);"><?= $m + 1; ?></td>

                                                        <td><?= $metalqr['ques']; ?></td>

                                                        <td><span class=<?= $color; ?>><i class=<?= $cicon; ?>></i>

                                                                <?= $ansar[$m]; ?>

                                                            </span></td>



                                                    </tr>

                                                <?php

                                                    $m++;
                                                }



                                                ?>



                                            </tbody>

                                        </table>

                                    </div>

                                    <br>

                                    <hr><br>



                            <?php

                                }
                            }



                            ?>



                        </div>

                    </div>







                    <!-- Boxing  -->

                    <div class="animate-in delay-5">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon box-icon"><i class="bi bi-box-seam"></i></div>

                                <div>

                                    <div class="stage-title">Boxing Record</div>

                                    <div class="stage-sub">Final Pack</div>

                                </div>

                                <div class="stage-head-right ">

                                    <div class="stage-head-right ">

                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=boxingreport&batch=<?= $batchcode ?>" class="btn-ghost

                                                btn text-info" target="_blank"><i

                                                    class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>



                                </div>

                            </div>

                            <?php



                            $boxchk = mysqli_query($con, "SELECT b.*,r.name as bname FROM `tblboxing` as b join tblrecipe as r  on r.id = b.sno where productbatch ='$batchcode'");

                            $boxchkn = mysqli_num_rows($boxchk);



                            if ($boxchkn > 0) {

                                foreach ($boxchk as $boxc) {

                                    $boxuser = $boxc['user'];

                                    $boxuserdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$boxuser' and c1.type ='Procedure' and c1.status='Active'");

                                    $boxusercert1 = mysqli_fetch_assoc($boxuserdet);







                            ?>

                                    <div

                                        style="display:flex; align-items:flex-start; gap:24px; flex-wrap:wrap;margin-bottom:10px;">

                                        <div class="metrics-grid cols-4" style="flex:1 1 240px; margin-bottom:0;">

                                            <div class="metric-tile">

                                                <div class="label">Date Time</div>

                                                <div class="h4"><?= date('d-m-Y', strtotime($boxc['cdate'])); ?>

                                                </div>

                                            </div>

                                            <div class="metric-tile">

                                                <div class="label">Box Name</div>

                                                <div class="h4 text-info">

                                                    <?= $boxc['bname'] ?>

                                                </div>

                                            </div>

                                            <div class="metric-tile">

                                                <div class="label">Box Batchcode (Best Before)</div>

                                                <div class="h4 text-info">

                                                    <?= $boxc['boxbatchcode'] . " (" . date('d-m-Y', strtotime($boxc['bestbefore'])) . ")" ?>

                                                </div>



                                            </div>

                                            <div class="metric-tile">

                                                <div class="label">Total Packs</div>

                                                <div class="h4" style="color:var(--ok);">

                                                    <?= $boxc['img'] ?>

                                                </div>

                                            </div>



                                            <?php

                                            if (isset($boxusercert1['certdate']) && $boxusercert1['certdate'] != '') {

                                                $date = new DateTime($boxusercert1['certdate']);

                                                $date->modify('-3 years');

                                                $bcerdate = $date->format('d-m-Y');
                                            } else {

                                                $bcerdate = 'Not Trained';
                                            }



                                            // User Photo

                                            if (isset($boxusercert1['simg']) && $boxusercert1['simg'] != '') {

                                                $userPhoto = 'student/' . $boxusercert1['simg'];
                                            } else {

                                                $userPhoto = '#';
                                            }



                                            // User Certificate

                                            if (isset($boxusercert1['certificate']) && $boxusercert1['certificate'] != '') {

                                                $userCertificate = 'student/' . $boxusercert1['certificate'];
                                            } else {

                                                $userCertificate = '';
                                            }



                                            ?>

                                            <div class="metric-tile">

                                                <div class="label">Attempt By (Training Date) </div>

                                                <div class="h4 text-primary">

                                                    <a href="#" class="openModalLink hover-pop" id="openModalLink"

                                                        data-name="<?= $boxuser ?>" data-pic="<?= $userPhoto ?>"

                                                        data-cert-date="<?= $bcerdate ?>" data-pdf="<?= $userCertificate ?>"

                                                        data-pdf-label="Training Document">

                                                        <?= htmlspecialchars($boxuser) ?>

                                                        (<?= $bcerdate ?>)

                                                    </a>

                                                </div>





                                            </div>



                                        </div>

                                    </div>



                                <?php

                                }
                            } else {

                                ?>

                                <div class="empty-state-compact">

                                    <div class="empty-icon">

                                        <i class="bi bi-box-seam"></i>

                                    </div>

                                    <div class="empty-title">No Record Found</div>

                                    <div class="empty-sub">No boxing details have been recorded for this batch

                                        code.</div>

                                </div>

                            <?php

                            }

                            ?>

                        </div>

                    </div>



                    <!-- goods out -->

                    <!-- Recipe Record -->

                    <?php

                    $goodsub = mysqli_query($con, "SELECT c.name as cname , g.po as invoice, g.cdate as godate,b.* FROM `tblboxing` as b join tblgdn1 as g1 join tblgdn as g join tblcustomer as c  on g1.batchcode =  b.boxbatchcode AND g1.gdn = g.gdn AND g.customer = c.id where b.productbatch ='$batchcode'");

                    $goodsubn = mysqli_num_rows($goodsub);

                    ?>

                    <div class="animate-in delay-3">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon recipe-icon"><i class="bi bi-send"></i>

                                </div>

                                <div>

                                    <div class="stage-title">Goods Out Record</div>

                                </div>

                                <div class="stage-head-right ">

                                    <div class="stage-head-right ">



                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=goodsreport&batch=<?= $batchcode ?>" class="btn-ghost btn

                                                text-info" target="_blank"><i

                                                    class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>

                                </div>

                            </div>



                            <div class="ing-table-wrap">

                                <table class="ing-table">

                                    <thead>

                                        <tr>

                                            <th>#</th>

                                            <th>Customer Name</th>

                                            <th>Invoice No.</th>

                                            <th>Date</th>

                                            <th>Box Batchcode</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        $goodsub = mysqli_query($con, "SELECT c.name as cname , g.po as invoice, g.cdate as godate,b.* FROM `tblboxing` as b join tblgdn1 as g1 join tblgdn as g join tblcustomer as c  on g1.batchcode =  b.boxbatchcode AND g1.gdn = g.gdn AND g.customer = c.id where b.productbatch ='$batchcode'");

                                        $goodsubn = mysqli_num_rows($goodsub);

                                        if ($goodsubn > 0) {



                                            $i = 1;

                                            foreach ($goodsub as $gooddata) {

                                        ?>

                                                <tr>

                                                    <td style="color:var(--muted);"><?= $i ?></td>



                                                    <td style="color:var(--muted);">

                                                        <?= $gooddata['cname'] ?>

                                                    </td>

                                                    <td><?= $gooddata['invoice'] ?></td>

                                                    <td><?= $gooddata['godate'] ?></td>

                                                    <td><?= $gooddata['boxbatchcode'] ?></td>



                                                </tr>

                                            <?php

                                                $i++;
                                            }
                                        } else {

                                            ?>

                                            <tr>

                                                <td colspan="5" class="text-center">No Record Found</td>

                                            </tr>

                                        <?php

                                        }

                                        ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <?php



                    if ($brt['confirm'] == 'Waiting') {

                    ?>





                        <div class="animate-in delay-3">

                            <div class="stage-card">

                                <div class="stage-head">

                                    <div class="stage-icon"

                                        style="background: linear-gradient(135deg, rgba(22, 163, 74, .12), rgba(22, 163, 74, .04)); color: var(--ok); border: 1px solid rgba(22, 163, 74, .2);">

                                        <i class="bi bi-shield-check"></i>

                                    </div>

                                    <div>

                                        <div class="stage-title">Update Status of this Batch</div>

                                        <div class="stage-sub">Batch Approval & Verification Control</div>

                                    </div>

                                </div>

                                <div style="padding: 6px 0 0;">

                                    <form method="post"

                                        style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; background: var(--panel-2); border: 1px solid var(--border); border-radius: 14px; padding: 20px 24px;">

                                        <div style="display: flex; align-items: center; gap: 14px;">

                                            <div

                                                style="width: 44px; height: 44px; border-radius: 12px; background: #fff; border: 1px solid var(--border-light); display: grid; place-items: center; font-size: 20px; color: var(--accent); flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,.04);">

                                                <i class="bi bi-sliders"></i>

                                            </div>

                                            <div>

                                                <div style="font-size: 14px; font-weight: 700; color: var(--fg);">

                                                    Batch

                                                    Quality Action</div>

                                                <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">

                                                    Select

                                                    an outcome below to approve or reject this batch record.

                                                </div>

                                            </div>

                                        </div>

                                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">

                                            <button type="submit" name="approve" class="btn-action-approve">

                                                <i class="bi bi-check-circle-fill" style="font-size: 15px;"></i>

                                                APPROVE

                                                BATCH

                                            </button>

                                            <button type="submit" name="reject" class="btn-action-reject">

                                                <i class="bi bi-x-circle-fill" style="font-size: 15px;"></i>

                                                REJECT BATCH

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    <?php

                    }



                    ?>

                </div>

            </section>



        </div>

    </div>

</div>







<style>
    /* Modal Overlay */

    .modal-overlay {

        display: none;

        position: fixed;

        top: 0;

        left: 0;

        width: 100%;

        height: 100%;

        background: rgba(0, 0, 0, 0.5);

        z-index: 9999;

        justify-content: center;

        align-items: center;

        padding: 20px;

    }



    .modal-overlay.active {

        display: flex;

    }



    /* Modal Box */

    .modal-box {

        background: #ffffff;

        max-width: 700px;

        width: 100%;

        border-radius: 12px;

        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);

        animation: modalFade 0.3s ease;

    }



    @keyframes modalFade {

        from {

            transform: scale(0.9);

            opacity: 0;

        }



        to {

            transform: scale(1);

            opacity: 1;

        }

    }



    /* User list styling */

    .user-list {

        list-style: none;

        padding: 0;

        max-width: 600px;

        margin: 30px auto;

    }



    .user-list li {

        padding: 12px 16px;

        border-bottom: 1px solid #e5e8f0;

    }



    .user-list li:last-child {

        border-bottom: none;

    }



    .user-link {

        color: #007bff;

        text-decoration: none;

        cursor: pointer;

        font-size: 16px;

    }



    .user-link:hover {

        text-decoration: underline;

    }



    .user-link .badge-date {

        font-size: 12px;

        background: #e9ecef;

        color: #495057;

        padding: 2px 10px;

        border-radius: 12px;

        margin-left: 8px;

    }
</style>





<!-- ─── MODAL ─── -->

<div class="modal-overlay" id="personModal">

    <div class="modal-box">

        <!-- Modal Header -->

        <div class="modal-header"

            style="padding: 18px 24px; border-bottom: 1px solid #e5e8f0; display: flex; justify-content: space-between; align-items: center;">

            <h5 style="margin: 0; font-size: 18px; font-weight: 600; color: #1a1d2e;">

                <i class="bi bi-person-circle" style="color: #007bff;"></i>

                <span id="modalName">Person</span>

            </h5>

            <button class="modal-close" id="closeModal"

                style="background: none; border: none; font-size: 28px; line-height: 1; color: #8891a8; cursor: pointer; padding: 0 8px;">

                &times;

            </button>

        </div>



        <!-- Modal Body -->

        <div class="modal-body" style="padding: 24px;">

            <!-- User Info -->

            <div

                style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px; padding: 16px; background: #f8f9fa; border-radius: 8px;">

                <img id="personPic" src="" alt="Profile"

                    style="width: 90px; height: 90px; border-radius: 2%; object-fit: cover; border: 1px solid #007bff;">

                <div style="flex: 1;">

                    <h3 id="dispName" style="font-size: 18px; font-weight: 600; color: #1a1d2e; margin: 0 0 4px 0;">—

                    </h3>

                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">

                        <span

                            style="background: #d4edda; color: #155724; padding: 4px 14px; border-radius: 20px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">

                            <i class="bi bi-patch-check-fill"></i> <span id="traindt">-</span>

                        </span>

                        <span style="color: #6c757d; font-size: 14px;">

                            <i class="bi bi-calendar3"></i> <span id="certDate">—</span>

                        </span>

                    </div>

                </div>

            </div>



            <!-- PDF Section -->

            <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: #f8f9fa;">

                <div

                    style="padding: 12px 16px; background: #fff; border-bottom: 1px solid #dee2e6; display: flex; align-items: center; gap: 8px; font-weight: 500;">

                    <i class="bi bi-file-pdf" style="color: #dc3545;"></i>

                    <span id="pdfLabel">Document</span>

                </div>

                <div style="height: 280px; background: #fff;">

                    <iframe id="pdfIframe" src="about:blank" title="PDF viewer"

                        style="width: 100%; height: 100%; border: none;"></iframe>

                </div>

                <div

                    style="padding: 10px 16px; background: #fff; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">

                    <span style="font-size: 13px; color: #495057;">

                        <i class="bi bi-file-pdf" style="color: #dc3545; margin-right: 6px;"></i>

                        <span id="pdfFileName">document.pdf</span>

                    </span>

                    <a href="#" id="pdfOpenLink" target="_blank"

                        style="color: #007bff; text-decoration: none; font-weight: 500; font-size: 14px; padding: 4px 12px; border: 1px solid #007bff; border-radius: 4px; transition: all 0.2s;">

                        <i class="bi bi-box-arrow-up-right"></i> Open PDF

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- Bootstrap 4 JS + dependencies -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>



<script>
    $(document).ready(function() {

        const overlay = document.getElementById('personModal');

        const closeBtn = document.getElementById('closeModal');



        // DOM refs

        const modalName = document.getElementById('modalName');

        const dispName = document.getElementById('dispName');

        const traindt = document.getElementById('traindt');

        const personPic = document.getElementById('personPic');

        const certDate = document.getElementById('certDate');

        const pdfIframe = document.getElementById('pdfIframe');

        const pdfLabel = document.getElementById('pdfLabel');

        const pdfFileName = document.getElementById('pdfFileName');

        const pdfOpenLink = document.getElementById('pdfOpenLink');



        // Open modal

        $('.openModalLink').on('click', function(e) {

            e.preventDefault();



            // Get data from the clicked link

            const name = $(this).data('name') || 'Unknown';

            const pic = $(this).data('pic') || '';

            const cert = $(this).data('cert-date') || 'Not certified';

            let train = '';

            if (cert == 'Not certified') {

                train = 'Not Trained';

            } else {

                train = 'Trained';

            }

            const pdfUrl = $(this).data('pdf') || '';

            const pdfLabelText = $(this).data('pdf-label') || 'document.pdf';



            // Inject into modal

            modalName.textContent = name;

            dispName.textContent = name;

            traindt.textContent = train;



            // Picture

            if (pic && pic.trim() !== '') {

                personPic.src = pic;

                personPic.alt = name;

            } else {

                personPic.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&background=007bff&color=fff&size=100';

                personPic.alt = name;

            }



            certDate.textContent = cert;



            // PDF

            if (pdfUrl && pdfUrl.trim() !== '') {

                pdfIframe.src = pdfUrl;

                pdfLabel.textContent = pdfLabelText;

                pdfFileName.textContent = pdfLabelText;

                pdfOpenLink.href = pdfUrl;

            } else {

                pdfIframe.src = 'about:blank';

                pdfLabel.textContent = 'No PDF available';

                pdfFileName.textContent = '—';

                pdfOpenLink.href = '#';

            }



            // Show modal

            overlay.classList.add('active');

            document.body.style.overflow = 'hidden';

        });



        // Close modal

        function closeModal() {

            overlay.classList.remove('active');

            document.body.style.overflow = '';

        }



        closeBtn.addEventListener('click', closeModal);



        // Click outside to close

        overlay.addEventListener('click', function(e) {

            if (e.target === overlay) closeModal();

        });



        // ESC key to close

        document.addEventListener('keydown', function(e) {

            if (e.key === 'Escape' && overlay.classList.contains('active')) {

                closeModal();

            }

        });

    });
</script>

<!-- ─── HOVER BUTTON POPUP (added) ─── -->
<style>
    .hover-popup {
        position: fixed;
        z-index: 1000;
        padding: 6px;
        background: #ffffff;
        border: 1px solid var(--border-light, #dce0ea);
        border-radius: 12px;
        box-shadow: 0 10px 28px rgba(26, 29, 46, .16), 0 2px 6px rgba(26, 29, 46, .08);
        opacity: 0;
        visibility: hidden;
        transform: translateY(var(--hp-shift, 6px));
        transition: opacity .15s ease, transform .15s ease, visibility .15s;
    }

    .hover-popup.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Arrow pointing at the mouse */
    .hover-popup::before {
        content: "";
        position: absolute;
        left: var(--hp-arrow-x, 20px);
        width: 12px;
        height: 12px;
        background: #ffffff;
        border: 1px solid var(--border-light, #dce0ea);
        transform: rotate(45deg);
    }

    .hover-popup[data-side="bottom"]::before {
        top: -7px;
        border-right: 0;
        border-bottom: 0;
    }

    .hover-popup[data-side="top"]::before {
        bottom: -7px;
        border-left: 0;
        border-top: 0;
    }

    .hover-popup-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--accent, #ea580c), var(--accent-deep, #c2410c));
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
        cursor: pointer;
        box-shadow: 0 4px 16px -2px rgba(234, 88, 12, .35);
        transition: filter .15s;
    }

    .hover-popup-btn:hover,
    .hover-popup-btn:focus-visible {
        filter: brightness(1.08);
        outline: none;
    }

    @media (prefers-reduced-motion: reduce) {
        .hover-popup {
            transition: none;
        }
    }
</style>

<div class="hover-popup" id="hoverPopup">
    <button type="button" class="hover-popup-btn" id="hoverPopupBtn">
        <i class="bi bi-eye"></i> Acess data
    </button>
</div>

<script>
    (function() {
        // Hover only exists on mouse devices; on touch the links work as normal
        if (!window.matchMedia('(hover: hover)').matches) return;

        // Add this class to any <a> to turn the hover button ON, remove it to turn it OFF
        var HOVER_CLASS = 'hover-pop';

        var popup = document.getElementById('hoverPopup');
        var popupBtn = document.getElementById('hoverPopupBtn');
        var hideTimer = null;
        var activeLink = null;

        // Place the popup right under the mouse; flip above if there is no room
        function placeAt(x, y) {
            var w = popup.offsetWidth;
            var h = popup.offsetHeight;
            var gap = 14;

            var below = y + gap + h < window.innerHeight || y - gap - h < 0;
            var top = below ? y + gap : y - gap - h;
            var left = Math.max(12, Math.min(x - w / 2, window.innerWidth - w - 12));

            popup.style.top = top + 'px';
            popup.style.left = left + 'px';
            popup.style.setProperty('--hp-arrow-x', Math.max(14, Math.min(x - left - 6, w - 26)) + 'px');
            popup.style.setProperty('--hp-shift', below ? '6px' : '-6px');
            popup.dataset.side = below ? 'bottom' : 'top';
        }

        function show(link, e) {
            clearTimeout(hideTimer);
            // Already open for this link: keep it where it is so the button doesn't move
            if (activeLink === link && popup.classList.contains('show')) return;
            activeLink = link;
            placeAt(e.clientX, e.clientY);
            popup.classList.add('show');
        }

        function hide() {
            popup.classList.remove('show');
            activeLink = null;
        }

        // Short delay so the popup stays open while the mouse moves from the link to the button
        function hideSoon() {
            clearTimeout(hideTimer);
            hideTimer = setTimeout(hide, 200);
        }

        // Finds the anchor that has the class (checked live, so adding/removing the class works any time)
        function getLink(target) {
            if (!target || !target.closest) return null;
            if (target.closest('#personModal') || target.closest('#hoverPopup')) return null; // not in the modal / popup
            var a = target.closest('a.' + HOVER_CLASS);
            if (!a) return null;
            var href = (a.getAttribute('href') || '').trim();
            if (href === '' || href.toLowerCase().indexOf('javascript:') === 0) return null;
            return a;
        }

        document.addEventListener('mouseover', function(e) {
            var link = getLink(e.target);
            if (link) show(link, e);
        });

        document.addEventListener('mouseout', function(e) {
            var link = getLink(e.target);
            if (!link) return;
            // Still inside the same link (moving between its children): ignore
            if (e.relatedTarget && link.contains(e.relatedTarget)) return;
            hideSoon();
        });

        popup.addEventListener('mouseenter', function() {
            clearTimeout(hideTimer);
        });
        popup.addEventListener('mouseleave', hideSoon);

        // The button does exactly what clicking the link does:
        // opens the data modal, or follows the link (same tab or new tab, as the link is set)
        popupBtn.addEventListener('click', function() {
            var link = activeLink;
            hide();
            if (link) link.click();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') hide();
        });
        window.addEventListener('scroll', hide, {
            passive: true
        });
        window.addEventListener('resize', hide);
    })();
</script>