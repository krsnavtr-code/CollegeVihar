-- Table: adminpagegroup
CREATE TABLE `adminpagegroup` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_title` VARCHAR(255) NOT NULL,
  `group_index` INT(11) NOT NULL
);

-- Table: adminpages
CREATE TABLE `adminpages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `admin_page_title` VARCHAR(255) NOT NULL,
  `admin_page_url` VARCHAR(255) NOT NULL,
  `page_group` INT(11) DEFAULT 999,
  `can_display` INT(11) NOT NULL DEFAULT 1,
  `admin_page_status` INT(11) NOT NULL DEFAULT 1,
  FOREIGN KEY (`page_group`) REFERENCES `adminpagegroup` (`id`)
);

-- Table: metadata
CREATE TABLE `metadata` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `url_slug` VARCHAR(255) NOT NULL,
  `meta_title` VARCHAR(255) NOT NULL,
  `meta_h1` VARCHAR(999) NOT NULL,
  `meta_description` VARCHAR(999) NOT NULL,
  `meta_keywords` VARCHAR(999) NOT NULL,
  `meta_image` VARCHAR(255) DEFAULT NULL,
  `meta_canonical` VARCHAR(255) NOT NULL,
  `other_meta_tags` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: states
CREATE TABLE `states` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `state_name` VARCHAR(100) NOT NULL,
  `state_short` VARCHAR(10) NOT NULL
);

-- Table: courses
CREATE TABLE `courses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `course_name` VARCHAR(255) NOT NULL,
  `course_short_name` VARCHAR(255) NOT NULL,
  `course_type` VARCHAR(40) NOT NULL,
  `course_online` INT(11) NOT NULL DEFAULT 0,
  `course_duration` VARCHAR(100) DEFAULT NULL,
  `course_eligibility_short` VARCHAR(100) DEFAULT NULL,
  `course_intro` LONGTEXT,
  `course_overview` LONGTEXT,
  `course_highlights` LONGTEXT,
  `course_subjects` LONGTEXT,
  `course_eligibility` LONGTEXT,
  `course_freights` VARCHAR(999) DEFAULT NULL,
  `course_specialization` LONGTEXT,
  `course_job` LONGTEXT,
  `course_types` LONGTEXT,
  `why_this_course` LONGTEXT,
  `course_faqs` LONGTEXT,
  `course_slug` INT(11) DEFAULT NULL,
  `course_status` INT(11) NOT NULL DEFAULT 1,
  `course_detail_added` INT(11) NOT NULL DEFAULT 0,
  FOREIGN KEY (`course_slug`) REFERENCES `metadata` (`id`)
);

-- Table: jobroles
CREATE TABLE `jobroles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `job_role_title` VARCHAR(255) NOT NULL,
  `permissions` LONGTEXT,
  `role_sensitive` INT(11) NOT NULL DEFAULT 0
);

-- Table: employees
CREATE TABLE `employees` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `emp_name` VARCHAR(255) NOT NULL,
  `emp_username` VARCHAR(255) NOT NULL,
  `emp_pic` VARCHAR(255) DEFAULT NULL,
  `emp_contact` VARCHAR(255) DEFAULT NULL,
  `emp_email` VARCHAR(255) DEFAULT NULL,
  `emp_company_email` VARCHAR(255) DEFAULT NULL,
  `emp_password` VARCHAR(255) NOT NULL,
  `emp_address` VARCHAR(999) DEFAULT NULL,
  `emp_gender` ENUM('male', 'female', 'transgender') NOT NULL,
  `emp_dob` DATE NOT NULL,
  `emp_joining_date` DATE NOT NULL,
  `emp_job_role` INT(11) NOT NULL,
  `emp_salary` INT(11) DEFAULT NULL,
  `emp_state` INT(11) NOT NULL,
  `emp_type` ENUM('office', 'field', 'franchise') NOT NULL,
  `emp_docs` LONGTEXT,
  `emp_team` INT(11) DEFAULT NULL,
  `emp_status` INT(11) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`emp_team`) REFERENCES `team` (`id`),
  FOREIGN KEY (`emp_state`) REFERENCES `states` (`id`),
  FOREIGN KEY (`emp_job_role`) REFERENCES `jobroles` (`id`)
);

-- Table: team
CREATE TABLE `team` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `team_name` VARCHAR(255) NOT NULL,
  `team_leader` INT(11) NOT NULL,
  FOREIGN KEY (`team_leader`) REFERENCES `employees`(`id`)
);

-- Table: universities
CREATE TABLE `universities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `univ_name` VARCHAR(255) NOT NULL,
  `univ_url` VARCHAR(255) NOT NULL,
  `univ_logo` VARCHAR(255) DEFAULT NULL,
  `univ_image` VARCHAR(255) DEFAULT 'university_temp.webp',
  `univ_type` ENUM('online', 'offline') NOT NULL,
  `univ_person` VARCHAR(255) DEFAULT NULL,
  `univ_person_email` VARCHAR(100) DEFAULT NULL,
  `univ_person_phone` VARCHAR(20) DEFAULT NULL,
  `univ_state` INT(11) DEFAULT NULL,
  `univ_address` VARCHAR(255) DEFAULT NULL,
  `univ_description` TEXT,
  `univ_facts` TEXT,
  `univ_advantage` LONGTEXT,
  `univ_industry` LONGTEXT,
  `univ_carrier` LONGTEXT,
  `univ_slug` INT(11) DEFAULT NULL,
  `univ_status` INT(11) NOT NULL DEFAULT 1,
  `univ_detail_added` INT(11) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `univ_payout` INT(11) DEFAULT NULL,
  FOREIGN KEY (`univ_state`) REFERENCES `states` (`id`),
  FOREIGN KEY (`univ_slug`) REFERENCES `metadata` (`id`)
);

-- Table: universitycourses
CREATE TABLE `universitycourses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `university_id` INT(11) NOT NULL,
  `course_id` INT(11) NOT NULL,
  `univ_course_commision` TEXT NOT NULL,
  `univ_course_fee` INT(11) DEFAULT NULL,
  `univ_course_desc` LONGTEXT,
  `univ_course_faqs` LONGTEXT,
  `univ_course_slug` INT(11) DEFAULT NULL,
  `univ_course_status` INT(11) NOT NULL DEFAULT 1,
  `univ_course_detail_added` INT(11) NOT NULL DEFAULT 0,
  FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`),
  FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  FOREIGN KEY (`univ_course_slug`) REFERENCES `metadata` (`id`)
);

-- Table: leads
CREATE TABLE `leads` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `lead_name` VARCHAR(255) NOT NULL,
  `lead_dob` VARCHAR(255) DEFAULT NULL,
  `lead_contact` VARCHAR(20) NOT NULL,
  `lead_email` VARCHAR(255) DEFAULT NULL,
  `lead_old_qualification` VARCHAR(255) DEFAULT NULL,
  `lead_university` INT(11) DEFAULT NULL,
  `lead_course` INT(11) DEFAULT NULL,
  `lead_query` LONGTEXT,
  `lead_source` VARCHAR(50) DEFAULT NULL,
  `lead_owner` INT(11) DEFAULT NULL,
  `lead_status` ENUM('new', 'active', 'disable') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`lead_university`) REFERENCES `universities` (`id`),
  FOREIGN KEY (`lead_course`) REFERENCES `courses` (`id`),
  FOREIGN KEY (`lead_owner`) REFERENCES `employees` (`id`)
);

-- Table: leadupdates
CREATE TABLE `leadupdates` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `lead_id` INT(11) DEFAULT NULL,
  `update_text` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`)
);