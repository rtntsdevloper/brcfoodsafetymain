-- =====================================================================
-- RTNTS Global — Food Safety Culture Portal
-- MySQL 5.7+ / 8.x schema + seed data
-- Import: mysql -u root -p < schema.sql
-- =====================================================================
CREATE DATABASE IF NOT EXISTS fsc_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fsc_portal;

-- ---------- Reference tables ----------
CREATE TABLE sites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(10) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE dimensions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL UNIQUE,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ---------- Users ----------
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(100) NOT NULL,
  role ENUM('admin','manager','employee') NOT NULL DEFAULT 'employee',
  site_id INT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------- Survey ----------
CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dimension_id INT NULL,
  qtype ENUM('likert','text') NOT NULL DEFAULT 'likert',
  qtext VARCHAR(255) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  active TINYINT(1) NOT NULL DEFAULT 1,
  FOREIGN KEY (dimension_id) REFERENCES dimensions(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE survey_rounds (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(120) NOT NULL,
  rtype ENUM('annual','pulse') NOT NULL DEFAULT 'annual',
  opens_on DATE NOT NULL,
  closes_on DATE NOT NULL,
  status ENUM('draft','open','closed') NOT NULL DEFAULT 'draft',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Anonymous: stores site / department / shift only — never user identity
CREATE TABLE responses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  round_id INT NOT NULL,
  site_id INT NOT NULL,
  department_id INT NOT NULL,
  shift ENUM('Days','Nights','Weekend','Rotating') NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (round_id) REFERENCES survey_rounds(id) ON DELETE CASCADE,
  FOREIGN KEY (site_id) REFERENCES sites(id),
  FOREIGN KEY (department_id) REFERENCES departments(id)
) ENGINE=InnoDB;

CREATE TABLE answers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  response_id INT NOT NULL,
  question_id INT NOT NULL,
  score TINYINT NULL,           -- 1..5 for likert
  comment TEXT NULL,            -- for text questions
  FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES questions(id)
) ENGINE=InnoDB;

-- ---------- Culture plan tasks ----------
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT NULL,
  dimension_id INT NULL,
  site_id INT NULL,                                -- NULL = group-wide
  owner_user_id INT NULL,
  owner_role VARCHAR(80) NULL,                     -- RACI accountable role label
  due_date DATE NULL,
  priority ENUM('low','medium','high') NOT NULL DEFAULT 'medium',
  status ENUM('open','in_progress','completed') NOT NULL DEFAULT 'open',
  effectiveness_measure VARCHAR(255) NULL,
  evidence TEXT NULL,
  created_by INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  completed_at DATETIME NULL,
  FOREIGN KEY (dimension_id) REFERENCES dimensions(id) ON DELETE SET NULL,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE SET NULL,
  FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------- Implementation roadmap (next steps, managed on the portal) ----------
CREATE TABLE plan_phases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  timeframe VARCHAR(60) NOT NULL,
  objective VARCHAR(255) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE plan_steps (
  id INT AUTO_INCREMENT PRIMARY KEY,
  phase_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  detail TEXT NULL,
  owner_role VARCHAR(100) NULL,
  due_label VARCHAR(40) NULL,
  deliverable VARCHAR(255) NULL,
  status ENUM('not_started','in_progress','completed') NOT NULL DEFAULT 'not_started',
  sort_order INT NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (phase_id) REFERENCES plan_phases(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Headcount per site per round, for participation % on the dashboard
CREATE TABLE site_headcount (
  id INT AUTO_INCREMENT PRIMARY KEY,
  site_id INT NOT NULL,
  round_id INT NOT NULL,
  headcount INT NOT NULL,
  UNIQUE KEY uq_site_round (site_id, round_id),
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
  FOREIGN KEY (round_id) REFERENCES survey_rounds(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- SEED DATA
-- =====================================================================
INSERT INTO sites (code, name) VALUES
 ('BHX','Birmingham Manufacturing'),
 ('LDS','Leeds Manufacturing');

INSERT INTO departments (name) VALUES
 ('Production'),('Packing'),('Warehouse & Despatch'),('Hygiene'),
 ('Engineering'),('Quality / Technical'),('Office / Support');

INSERT INTO dimensions (name, sort_order) VALUES
 ('Vision & Mission',1),('People',2),('Consistency',3),
 ('Adaptability',4),('Hazards & Risk Awareness',5);

-- Default admin — username: admin  password: ChangeMe123!  (CHANGE AFTER FIRST LOGIN)
INSERT INTO users (username, password_hash, full_name, role) VALUES
 ('admin', '$2y$10$Gvtm410wwjyVDyOcIyKZpOpJaZQoixsgEbULKkxVxO7iuK5AY4GB6', 'System Administrator', 'admin');

-- 25 Likert questions (Appendix D of FSC-PLAN-001) + 2 free-text
INSERT INTO questions (dimension_id, qtype, qtext, sort_order) VALUES
 (1,'likert','I understand our company''s food safety vision and objectives.',1),
 (1,'likert','Senior managers visibly demonstrate that food safety is a priority.',2),
 (1,'likert','Food safety is never compromised to meet production targets.',3),
 (1,'likert','Site leaders regularly talk about food safety on the factory floor.',4),
 (1,'likert','I know how my role contributes to making safe food for consumers.',5),
 (2,'likert','I have received the training I need to do my job safely and hygienically.',6),
 (2,'likert','My ideas and concerns about food safety are listened to and acted on.',7),
 (2,'likert','Good food safety behaviour is recognised and appreciated here.',8),
 (2,'likert','I feel able to stop the line or speak up if I see a food safety risk.',9),
 (2,'likert','New starters and agency staff are properly trained before working unsupervised.',10),
 (3,'likert','Food safety procedures are applied the same way on every shift.',11),
 (3,'likert','I have the time, equipment and people I need to work hygienically.',12),
 (3,'likert','Everyone follows the hygiene rules, including managers and visitors.',13),
 (3,'likert','Checks and records are completed accurately and at the time of the task.',14),
 (3,'likert','Changing priorities do not undermine food safety standards.',15),
 (4,'likert','When problems occur we fix the root cause rather than blame individuals.',16),
 (4,'likert','This site responds quickly and effectively to food safety issues.',17),
 (4,'likert','Changes to products, equipment or processes are risk-assessed before use.',18),
 (4,'likert','Lessons from complaints, audits and incidents are shared with us.',19),
 (4,'likert','I am encouraged to suggest improvements to food safety practices.',20),
 (5,'likert','I understand the food safety hazards in my own work area.',21),
 (5,'likert','I would report a food safety problem even if it slowed production.',22),
 (5,'likert','My colleagues would challenge unsafe or unhygienic behaviour.',23),
 (5,'likert','I understand why allergen and hygiene controls matter to our consumers.',24),
 (5,'likert','Monitoring data and checks are used to make decisions about risk.',25),
 (NULL,'text','What one thing would most improve food safety here?',26),
 (NULL,'text','Is there anything else you want to tell us?',27);

-- Baseline survey round (open) + headcounts
INSERT INTO survey_rounds (title, rtype, opens_on, closes_on, status) VALUES
 ('2026 Baseline Culture Survey','annual', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 21 DAY), 'open');

INSERT INTO site_headcount (site_id, round_id, headcount) VALUES (1,1,180),(2,1,140);

-- Implementation roadmap: phases and detailed next steps (Section 13 of FSC-PLAN-001)
INSERT INTO plan_phases (name, timeframe, objective, sort_order) VALUES
 ('Phase 1 — Mobilise & Baseline','Months 1–3','Stand up governance, make the portal the single system of record, and measure the cultural starting point at every site.',1),
 ('Phase 2 — Analyse & Act','Months 4–6','Turn baseline results into visible action: feed back to every shift, load site action plans, open the confidential route, build leadership capability.',2),
 ('Phase 3 — Embed & Improve','Months 7–12','Make culture activity habitual: campaigns, pulses, recognition, cross-site learning, and the annual effectiveness review that produces the year-2 plan.',3);

INSERT INTO plan_steps (phase_id, title, detail, owner_role, due_label, deliverable, status, sort_order) VALUES
 (1,'Appoint sponsor, Steering Committee and Site Culture Teams','Confirm the MD as plan sponsor. Group Technical Director chairs the quarterly Steering Committee (Site Directors, Group HR, Group Ops). Each site forms a Site Culture Team — Site Director, Technical Manager, Ops Manager, HR plus two Culture Champions per shift — meeting monthly.','Managing Director','Month 1','Signed terms of reference and 12-month meeting calendar (uploaded to portal)','completed',1),
 (1,'Configure the portal as the single system of record','Load sites, departments, users and roles, site headcounts; verify the 25-question bank; set survey round dates; change the default admin password; set nightly DB backups. All culture records — survey data, tasks and evidence, roadmap status, review outputs — are kept and managed in this portal.','Group Technical Director','Month 1','Portal live at all sites; backup schedule documented','completed',2),
 (1,'Sign and display the Food Safety & Quality Culture Policy','MD signs the policy; display on notice boards, screens and the portal; include in induction pack in all site languages.','Managing Director','Month 1','Policy displayed and acknowledged in portal','in_progress',3),
 (1,'Recruit and train Culture Champions','Two volunteer champions per shift per site. Train in feedback facilitation, root-cause basics and portal use (SOP-FSC-004).','HR / Technical Managers','Months 1–2','Champion register and training records in portal','in_progress',4),
 (1,'MD launch briefings on every shift','Face-to-face briefing on why culture matters, what will happen and what is asked of everyone; runs on days, nights and weekends including agency staff.','MD / Site Directors','Month 2','Attendance >= 90% per shift; briefing quiz results','not_started',5),
 (1,'Run the baseline perception survey','Three-week window via portal kiosks and personal devices; paper fallback transcribed. Monitor participation daily on the dashboard; escalate any site below 60% at mid-window (SOP-FSC-002).','Group Technical Director','Months 2–3','Participation >= 75% per site; dataset locked in portal','not_started',6),
 (2,'Analyse results and flag mandatory actions','Analyse by dimension, question, site, department and shift with n<5 suppression. Flag every question below 3.0 and any management/operative gap above 0.8 as mandatory action items.','Group Technical Director / Technical Managers','Month 4','Results pack published on portal Results module','not_started',1),
 (2,'"You said, we will do" feedback briefings','Brief headline results and committed actions to every shift within four weeks of survey close; capture reactions and further suggestions via champions.','Site Directors','Month 4','Briefing records per shift uploaded to portal','not_started',2),
 (2,'Build site action plans as portal tasks','Every corrective and improvement action becomes a portal task with owner, due date and effectiveness measure. No actions are tracked outside the portal.','Site Culture Teams','Month 5','Action plans approved at Steering Committee; tasks live','not_started',3),
 (2,'Relaunch the Speak Up confidential route','Independent HR-administered route; toolbox talks and posters on every shift; annual route test. Aggregate outcomes reported monthly (SOP-FSC-003).','HR (independent)','Months 5–6','Awareness >= 90% in next pulse survey','not_started',4),
 (2,'Deliver leadership culture workshops','"Leading Food Safety Culture" for 100% of managers and supervisors: psychological safety, just culture, coaching behaviours, responding to concerns.','Group HR','Month 6','Attendance register and evaluations in portal','not_started',5),
 (2,'Start monthly behavioural observation walks','GMP culture walks per SOP-FSC-005 across all areas and shifts; positive engagement, scores logged as portal records; trend monthly.','Operations Managers','Month 6 onward','Walk scores trending on dashboard','not_started',6),
 (3,'Run hazard awareness campaigns','Campaign 1: allergens ("Know your consumer"). Campaign 2: foreign body and glass discipline. Quiz-verified understanding, linked to complaint and NC trends.','Technical Managers','Months 7–10','Quiz pass >= 90%; campaign materials archived in portal','not_started',1),
 (3,'Quarterly pulse surveys','Five rotating questions, one-week window, all shifts. Compare against baseline on the dashboard; investigate any dimension moving down by more than 0.3.','Group Technical Director','Months 7 & 10','Pulse trend charts on dashboard','not_started',2),
 (3,'Launch recognition scheme and focus groups','Monthly peer-nominated Food Safety Star per shift; two operative-only focus groups per site per year, facilitated without line managers (SOP-FSC-003/005).','HR / Operations','Month 8 onward','Nominations log; focus group action lists as portal tasks','not_started',3),
 (3,'Cross-site best-practice exchange','Champions and team members visit the sister site; each visit must return at least one adopted improvement, logged as a portal task.','Group Operations Director','Month 11','Adopted improvements logged and closed','not_started',4),
 (3,'Interim maturity self-assessment','Each site scores itself against the five-level maturity ladder (Section 3 of the plan) using survey, walk and KPI evidence; moderated by the Steering Committee.','Site Culture Teams','Month 10','Maturity scores recorded on portal','not_started',5),
 (3,'Annual review and year-2 plan','Full effectiveness review of every completed activity (did its measure move?), culture performance pack to management review, MD approves year-2 plan; new plan loaded into portal tasks and roadmap.','MD / Steering Committee','Month 12','Management review minutes; year-2 plan live on portal','not_started',6);

-- 12-month culture plan tasks (Section 7 of FSC-PLAN-001)
INSERT INTO tasks (title, description, dimension_id, site_id, owner_role, due_date, priority, effectiveness_measure) VALUES
 ('Programme launch briefings','MD briefing to all shifts; culture policy signed and displayed; portal accounts created.',1,NULL,'MD / Site Directors', DATE_ADD(CURDATE(), INTERVAL 1 MONTH),'high','Attendance >= 90%; briefing quiz'),
 ('Recruit & train Culture Champions','Two champions per shift per site; deliver champion training.',2,NULL,'HR / Technical Manager', DATE_ADD(CURDATE(), INTERVAL 2 MONTH),'high','Champions in post; training records'),
 ('Baseline perception survey','All sites, all shifts, via portal; target participation 75%+.',NULL,NULL,'Group Technical Director', DATE_ADD(CURDATE(), INTERVAL 3 MONTH),'high','Participation >= 75%'),
 ('Start behavioural observation walks','Monthly GMP culture walks per SOP-FSC-005.',3,NULL,'Operations Managers', DATE_ADD(CURDATE(), INTERVAL 3 MONTH),'medium','Walks completed; score trend'),
 ('Brief survey results to all staff','"You said, we will do" sessions on every shift.',2,NULL,'Site Directors', DATE_ADD(CURDATE(), INTERVAL 4 MONTH),'high','Briefing records; feedback volume'),
 ('Publish site culture action plans','Load actions into portal tasks; approve at Steering Committee.',4,NULL,'Site Culture Teams', DATE_ADD(CURDATE(), INTERVAL 5 MONTH),'high','Plans approved by Steering Cttee'),
 ('Relaunch Speak Up confidential route','Toolbox talks on every shift; posters; test the route.',2,NULL,'HR / Technical Manager', DATE_ADD(CURDATE(), INTERVAL 6 MONTH),'medium','Awareness >= 90% in pulse survey'),
 ('Culture leadership workshops','All managers and supervisors complete "Leading Food Safety Culture".',1,NULL,'Group HR', DATE_ADD(CURDATE(), INTERVAL 6 MONTH),'high','100% attendance; evaluations'),
 ('Allergen awareness campaign','"Know your consumer" campaign with quiz.',5,NULL,'Technical Managers', DATE_ADD(CURDATE(), INTERVAL 7 MONTH),'medium','Quiz pass >= 90%; allergen NC trend'),
 ('Q2 pulse survey','Five-question pulse via portal.',NULL,NULL,'Group Technical Director', DATE_ADD(CURDATE(), INTERVAL 7 MONTH),'medium','Score trend vs baseline'),
 ('Launch recognition scheme','Monthly Food Safety Star per shift, peer nominated.',2,NULL,'HR / Operations', DATE_ADD(CURDATE(), INTERVAL 8 MONTH),'medium','Nominations per month'),
 ('Operative focus groups round 1','Facilitated without line managers present.',2,NULL,'Group HR', DATE_ADD(CURDATE(), INTERVAL 9 MONTH),'medium','Actions raised and closed'),
 ('Foreign body & glass discipline campaign','Campaign #2 with quiz and line checks.',5,NULL,'Technical Managers', DATE_ADD(CURDATE(), INTERVAL 10 MONTH),'medium','FB complaint trend; quiz results'),
 ('Q3 pulse survey & maturity self-assessment','Pulse plus interim maturity scoring per site.',NULL,NULL,'Site Culture Teams', DATE_ADD(CURDATE(), INTERVAL 10 MONTH),'medium','Pulse trend; maturity score'),
 ('Cross-site best practice exchange','Champions visit sister site; adopt improvements.',4,NULL,'Group Operations Director', DATE_ADD(CURDATE(), INTERVAL 11 MONTH),'low','Improvements adopted per site'),
 ('Annual culture review & year-2 plan','Review effectiveness of all activities in management review; issue year-2 plan.',NULL,NULL,'MD / Steering Committee', DATE_ADD(CURDATE(), INTERVAL 12 MONTH),'high','Review minutes; updated plan');
