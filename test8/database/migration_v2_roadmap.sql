-- Migration v2: adds the Implementation Roadmap module to an existing fsc_portal install
USE fsc_portal;

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

