# RTNTS Global — Food Safety Culture Portal

PHP + MySQL web portal supporting the Food Safety & Quality Culture Plan (FSC-PLAN-001).
Provides the anonymous culture survey, survey results with anonymity suppression, a KPI
dashboard and the culture plan task tracker — the objective evidence trail for
BRCGS Issue 9 (Cl. 1.1.2), FSSC 22000 V6 (Req. 2.5.8), Reg (EC) 852/2004 Ch. XIa and FDA FSMA.

## Requirements

- PHP 7.4+ (8.x recommended) with PDO MySQL extension
- MySQL 5.7+ / 8.x (or MariaDB 10.3+)
- Any web server (Apache/XAMPP/WAMP, nginx + php-fpm, or PHP built-in server)
- Internet access from the browser for Chart.js CDN (or self-host chart.umd.min.js)

## Install on cPanel shared hosting (Just Host / Bluehost)

1. **cPanel → MySQL Database Wizard**: create a database (e.g. `fscportal`), a user, a strong
   password, and grant the user **All Privileges**. Note the full prefixed names (`youracct_fscportal`).
2. **cPanel → phpMyAdmin**: select that database → **Import** → choose `database/schema_cpanel.sql`
   (NOT schema.sql) → Go. You should see 12 tables created.
3. **cPanel → File Manager**: inside `public_html`, create a folder (e.g. `culture`), upload the
   portal zip into it, and **Extract**. Delete the zip afterwards.
4. Edit `config.php` in File Manager: set DB_NAME, DB_USER, DB_PASS to the prefixed values from step 1.
5. **cPanel → MultiPHP Manager**: set the domain to PHP 8.x.
6. Browse to `https://yourdomain.com/culture/install_check.php` — fix anything marked FAIL.
7. Log in (`admin` / `ChangeMe123!`), change the password immediately, then **delete
   `install_check.php`** from the server.

Full illustrated steps: see the Installation Guide document.

## Install (XAMPP example)

1. Copy this folder to `htdocs/fsc_portal`.
2. Create the database and seed data:
   ```
   mysql -u root -p < database/schema.sql
   ```
3. Edit `config.php` with your DB credentials.
4. Browse to `http://localhost/fsc_portal/login.php`.
5. Log in: username `admin`, password `ChangeMe123!` — **change it immediately**
   (Users → Reset), then create manager/employee accounts.

Quick test without Apache: `php -S localhost:8080` from this folder.

## What's included

| Area | File(s) | Who |
|---|---|---|
| Login / logout, sessions, CSRF | `login.php`, `logout.php`, `includes/auth.php` | all |
| Dashboard (participation, dimension radar, site comparison, low scores, task KPIs) | `index.php` | all roles |
| Anonymous survey (25 Likert + 2 free-text, pre-seeded) | `survey.php` | all roles |
| Survey results (dimension/question/department, <5 respondent suppression, comments) | `results.php` | admin, manager |
| Culture plan tasks (16 pre-seeded from the 12-month plan; CRUD, evidence, overdue) | `tasks.php` | all (employees: own tasks) |
| Implementation roadmap (3 phases, 18 detailed next steps with owners, deliverables, status management) | `roadmap.php` | all (status edits: admin, manager) |
| Survey round management (annual/pulse, open/close, headcounts) | `surveys_admin.php` | admin |
| User management (roles, sites, activate, password reset) | `users.php` | admin |
| Schema + seed data | `database/schema.sql` | — |
| Upgrade for existing installs (adds roadmap module) | `database/migration_v2_roadmap.sql` | — |

## Roles

- **admin** — everything, including free-text comment review, users and survey rounds.
- **manager** — dashboard, results (restricted to their site if one is assigned), task management.
- **employee** — take the survey, view and update tasks assigned to them.

## Anonymity design (SOP-FSC-002)

- Responses store site, department and shift only — no user id, no IP.
- Result groups with fewer than 5 respondents (`MIN_GROUP_SIZE` in `config.php`) are suppressed.
- Free-text comments are shown to admins only, in randomised order.

## Production hardening checklist

- Change DB credentials and the admin password; use a dedicated MySQL user with least privilege.
- Serve over HTTPS; set `session.cookie_secure=1` and `session.cookie_httponly=1` in php.ini.
- Take regular DB backups (survey data is your audit evidence — retain per your records procedure).
- Optionally self-host Chart.js if factory kiosks have no internet access.
