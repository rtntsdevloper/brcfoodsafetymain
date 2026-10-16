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



    .stage-head-right {

        margin-left: auto;

        text-align: right;

        flex-shrink: 0;

    }



    .stage-head-right .kv-label {

        margin-bottom: 4px;

    }



    .stage-head-right .kv-value {

        font-size: 13px;

        color: var(--info);

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

        grid-template-columns: repeat(4, 1fr);

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

            <div class="brand-strip animate-in">

                <div class="brand-left">

                    <div class="brand-logo">

                        <i class="bi bi-diagram-3-fill" style="font-size:22px;"></i>

                    </div>

                    <div class="brand-text">

                        <h1>Batch Traceability</h1>

                        <span>Production & Quality Control Log</span>

                    </div>

                </div>

                <div class="brand-right">

                    <a class="btn-ghost btn" href="admin.php?id=trace">

                        <i class="bi bi-arrow-left" style="font-size:16px;"></i> Back to List

                    </a>

                </div>

            </div>

            <div class="search-wrapper animate-in delay-1">

                <div class="search-bar">

                    <i class="bi bi-search s-icon"></i>

                    <input type="text" id="searchbatch" name="searchBatch" placeholder="Enter batch code to look up..."

                        value="" autocomplete="off">

                    <button type="button" class="btn-search" onclick="getdata()">

                        <i class="bi bi-arrow-right-short" style="font-size:16px;"></i> Search

                    </button>

                </div>



            </div>

            <br><br>



            <section id="detail">







            </section>



        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function getdata() {

        const batch = document.getElementById("searchbatch").value.trim();



        if (!batch) {

            alert("Please enter a batch code.");

            return;

        }



        $("#detail").html("<h2 class='text-center text-info mt-5'>Please Wait Fetching Data...</h2>");



        $.ajax({

            url: "trace/trace2.php",

            type: "GET",

            data: {
                batch: batch
            },

            success: function(response) {

                $("#detail").html(response);

            },

            error: function(xhr, status, error) {

                $("#detail").html("<p style='color:red;'>Error fetching data.</p>");

                console.error("Error: " + error);

            }

        });

    }
</script>



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