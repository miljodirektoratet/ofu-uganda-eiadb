SET NAMES utf8;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `additional_districts`;
CREATE TABLE `additional_districts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `district_id` int(10) unsigned DEFAULT NULL,
  `project_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `additional_districts_district_id_foreign` (`district_id`),
  KEY `additional_districts_project_id_foreign` (`project_id`),
  CONSTRAINT `additional_districts_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  CONSTRAINT `additional_districts_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `audits_inspections`;
CREATE TABLE `audits_inspections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` int(10) unsigned DEFAULT NULL,
  `number` int(10) unsigned DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `coordinated` tinyint(1) DEFAULT '0',
  `advance_notice` tinyint(1) DEFAULT '0',
  `date_carried_out` date DEFAULT NULL,
  `days` int(10) unsigned DEFAULT NULL,
  `findings` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recommendations` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_action_taken` date DEFAULT NULL,
  `action_taken` int(10) unsigned DEFAULT NULL,
  `external_participants` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_deadline` date DEFAULT NULL,
  `date_closing` date DEFAULT NULL,
  `project_id` int(10) unsigned DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `reason` int(10) unsigned DEFAULT NULL,
  `file_metadata_id` int(10) unsigned DEFAULT NULL,
  `file_metadata_report_id` int(10) unsigned DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lead_officer` int(10) unsigned DEFAULT NULL,
  `performance_level` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `audits_inspections_project_id_foreign` (`project_id`),
  KEY `audits_inspections_file_metadata_id_foreign` (`file_metadata_id`),
  KEY `audits_inspections_lead_officer_foreign` (`lead_officer`),
  KEY `audits_inspections_file_metadata_report_id_foreign` (`file_metadata_report_id`),
  CONSTRAINT `audits_inspections_file_metadata_id_foreign` FOREIGN KEY (`file_metadata_id`) REFERENCES `file_metadata` (`id`),
  CONSTRAINT `audits_inspections_file_metadata_report_id_foreign` FOREIGN KEY (`file_metadata_report_id`) REFERENCES `file_metadata` (`id`),
  CONSTRAINT `audits_inspections_lead_officer_foreign` FOREIGN KEY (`lead_officer`) REFERENCES `users` (`id`),
  CONSTRAINT `audits_inspections_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `audits_inspections_documentation`;
CREATE TABLE `audits_inspections_documentation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `audit_inspection_id` int(10) unsigned DEFAULT NULL,
  `file_metadata_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_inspections_documentation_audit_inspection_id_foreign` (`audit_inspection_id`),
  KEY `audits_inspections_documentation_file_metadata_id_foreign` (`file_metadata_id`),
  CONSTRAINT `audits_inspections_documentation_audit_inspection_id_foreign` FOREIGN KEY (`audit_inspection_id`) REFERENCES `audits_inspections` (`id`),
  CONSTRAINT `audits_inspections_documentation_file_metadata_id_foreign` FOREIGN KEY (`file_metadata_id`) REFERENCES `file_metadata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `audits_inspections_lead_agencies`;
CREATE TABLE `audits_inspections_lead_agencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `audit_inspection_id` int(10) unsigned DEFAULT NULL,
  `lead_agency_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_inspections_lead_agencies_audit_inspection_id_foreign` (`audit_inspection_id`),
  KEY `audits_inspections_lead_agencies_lead_agency_id_foreign` (`lead_agency_id`),
  CONSTRAINT `audits_inspections_lead_agencies_audit_inspection_id_foreign` FOREIGN KEY (`audit_inspection_id`) REFERENCES `audits_inspections` (`id`),
  CONSTRAINT `audits_inspections_lead_agencies_lead_agency_id_foreign` FOREIGN KEY (`lead_agency_id`) REFERENCES `lead_agencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `audits_inspections_personnel`;
CREATE TABLE `audits_inspections_personnel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `audit_inspection_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_inspections_personnel_audit_inspection_id_foreign` (`audit_inspection_id`),
  KEY `audits_inspections_personnel_user_id_foreign` (`user_id`),
  CONSTRAINT `audits_inspections_personnel_audit_inspection_id_foreign` FOREIGN KEY (`audit_inspection_id`) REFERENCES `audits_inspections` (`id`),
  CONSTRAINT `audits_inspections_personnel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_short` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_long` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consequence` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `id` int(10) unsigned NOT NULL,
  `description1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value1` int(10) unsigned DEFAULT NULL,
  `dropdown_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `districts`;
CREATE TABLE `districts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hasc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso` int(10) unsigned DEFAULT NULL,
  `fips` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_submitted` date DEFAULT NULL,
  `sub_copy_no` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `number` int(10) unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consultent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `director_copy_no` int(10) unsigned DEFAULT NULL,
  `date_sent_director` date DEFAULT NULL,
  `coordinator_copy_no` int(10) unsigned DEFAULT NULL,
  `date_copies_coordinator` date DEFAULT NULL,
  `date_next_appointment` date DEFAULT NULL,
  `date_sent_from_dep` date DEFAULT NULL,
  `date_sent_officer` date DEFAULT NULL,
  `folio_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conclusion` int(10) unsigned DEFAULT NULL,
  `eia_permit_id` int(10) unsigned DEFAULT NULL,
  `control_id` int(10) unsigned DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks_director` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks_team_leader` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `file_metadata_id` int(10) unsigned DEFAULT NULL,
  `file_metadata_response_id` int(10) unsigned DEFAULT NULL,
  `date_conclusion` date DEFAULT NULL,
  `external_audit_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_eia_permit_id_foreign` (`eia_permit_id`),
  KEY `documents_file_metadata_id_foreign` (`file_metadata_id`),
  KEY `documents_file_metadata_response_id_foreign` (`file_metadata_response_id`),
  KEY `documents_external_audit_id_foreign` (`external_audit_id`),
  CONSTRAINT `documents_eia_permit_id_foreign` FOREIGN KEY (`eia_permit_id`) REFERENCES `eias_permits` (`id`),
  CONSTRAINT `documents_external_audit_id_foreign` FOREIGN KEY (`external_audit_id`) REFERENCES `external_audits` (`id`),
  CONSTRAINT `documents_file_metadata_id_foreign` FOREIGN KEY (`file_metadata_id`) REFERENCES `file_metadata` (`id`),
  CONSTRAINT `documents_file_metadata_response_id_foreign` FOREIGN KEY (`file_metadata_response_id`) REFERENCES `file_metadata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `eias_permits`;
CREATE TABLE `eias_permits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT NULL,
  `teamleader_id` int(10) unsigned DEFAULT NULL,
  `cost` bigint(20) unsigned DEFAULT NULL,
  `cost_currency` int(10) unsigned DEFAULT NULL,
  `expected_jobs_created` decimal(24,6) DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `inspection_recommended` int(10) unsigned DEFAULT NULL,
  `date_inspection` date DEFAULT NULL,
  `officer_recommend` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee` decimal(24,6) DEFAULT NULL,
  `fee_currency` int(10) unsigned DEFAULT NULL,
  `date_sent_ded_approval` date DEFAULT NULL,
  `decision` int(10) unsigned DEFAULT NULL,
  `date_decision` date DEFAULT NULL,
  `date_fee_notification` date DEFAULT NULL,
  `date_fee_payed` date DEFAULT NULL,
  `fee_receipt_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` int(10) unsigned DEFAULT NULL,
  `date_certificate` date DEFAULT NULL,
  `certificate_no` int(10) unsigned DEFAULT NULL,
  `date_cancelled` date DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_metadata_id` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eias_permits_project_id_foreign` (`project_id`),
  KEY `eias_permits_user_id_foreign` (`user_id`),
  KEY `eias_permits_file_metadata_id_foreign` (`file_metadata_id`),
  CONSTRAINT `eias_permits_file_metadata_id_foreign` FOREIGN KEY (`file_metadata_id`) REFERENCES `file_metadata` (`id`),
  CONSTRAINT `eias_permits_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `eias_permits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `eias_permits_personnel`;
CREATE TABLE `eias_permits_personnel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eia_permit_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eias_permits_personnel_eia_permit_id_foreign` (`eia_permit_id`),
  KEY `eias_permits_personnel_user_id_foreign` (`user_id`),
  CONSTRAINT `eias_permits_personnel_eia_permit_id_foreign` FOREIGN KEY (`eia_permit_id`) REFERENCES `eias_permits` (`id`),
  CONSTRAINT `eias_permits_personnel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `email_orders`;
CREATE TABLE `email_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` int(10) unsigned DEFAULT NULL,
  `foreign_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_status` int(10) unsigned NOT NULL DEFAULT '2',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `recipient` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bcc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks_from_service` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_attempts` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_orders_user_id_foreign` (`user_id`),
  CONSTRAINT `email_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `external_audits`;
CREATE TABLE `external_audits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT NULL,
  `teamleader_id` int(10) unsigned DEFAULT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `verification_inspection` int(10) unsigned DEFAULT NULL,
  `date_inspection` date DEFAULT NULL,
  `date_response` date DEFAULT NULL,
  `file_metadata_response_id` int(10) unsigned DEFAULT NULL,
  `response` int(10) unsigned DEFAULT NULL,
  `review_findings` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_deadline_compliance` date DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `external_audits_project_id_foreign` (`project_id`),
  KEY `external_audits_user_id_foreign` (`user_id`),
  KEY `external_audits_file_metadata_response_id_foreign` (`file_metadata_response_id`),
  CONSTRAINT `external_audits_file_metadata_response_id_foreign` FOREIGN KEY (`file_metadata_response_id`) REFERENCES `file_metadata` (`id`),
  CONSTRAINT `external_audits_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `external_audits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `external_audits_personnel`;
CREATE TABLE `external_audits_personnel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `external_audit_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `external_audits_personnel_external_audit_id_foreign` (`external_audit_id`),
  KEY `external_audits_personnel_user_id_foreign` (`user_id`),
  CONSTRAINT `external_audits_personnel_external_audit_id_foreign` FOREIGN KEY (`external_audit_id`) REFERENCES `external_audits` (`id`),
  CONSTRAINT `external_audits_personnel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `file_metadata`;
CREATE TABLE `file_metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `storage_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size_bytes` int(10) unsigned NOT NULL,
  `size_human_readable` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_metadata_storage_filename_unique` (`storage_filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `hearings`;
CREATE TABLE `hearings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lead_agency` int(10) unsigned DEFAULT NULL,
  `district_id` int(10) unsigned DEFAULT NULL,
  `date_dispatched` date DEFAULT NULL,
  `date_expected` date DEFAULT NULL,
  `date_received` date DEFAULT NULL,
  `recommendations` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `document_id` int(10) unsigned DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_metadata_id` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `hearings_district_id_foreign` (`district_id`),
  KEY `hearings_document_id_foreign` (`document_id`),
  KEY `hearings_file_metadata_id_foreign` (`file_metadata_id`),
  CONSTRAINT `hearings_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  CONSTRAINT `hearings_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`),
  CONSTRAINT `hearings_file_metadata_id_foreign` FOREIGN KEY (`file_metadata_id`) REFERENCES `file_metadata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `lead_agencies`;
CREATE TABLE `lead_agencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `short_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `long_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'SYSTEM',
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'SYSTEM',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `organisations`;
CREATE TABLE `organisations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tin` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visiting_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `physical_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `box_no` int(10) unsigned DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `password_reminders`;
CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `permits_licenses`;
CREATE TABLE `permits_licenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT NULL,
  `regulation` int(10) unsigned DEFAULT NULL,
  `date_submitted` date DEFAULT NULL,
  `waste_license_type` int(10) unsigned DEFAULT NULL,
  `ecosystem` int(10) unsigned DEFAULT NULL,
  `regulation_activity` int(10) unsigned DEFAULT NULL,
  `area` decimal(24,6) DEFAULT NULL,
  `unit` int(10) unsigned DEFAULT NULL,
  `approved_by_the_lc1` tinyint(1) DEFAULT '0',
  `approved_by_the_dec` tinyint(1) DEFAULT '0',
  `application_number` int(10) unsigned DEFAULT NULL,
  `application_fee_receipt_number` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_feedback_to_applicants` date DEFAULT NULL,
  `date_sent_to_director` date DEFAULT NULL,
  `date_sent_from_dep` date DEFAULT NULL,
  `date_sent_officer` date DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `application_evaluation_by_officer` int(10) unsigned DEFAULT NULL,
  `date_of_evaluation` date DEFAULT NULL,
  `folio_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inspection_recommended` int(10) unsigned DEFAULT NULL,
  `date_inspection` date DEFAULT NULL,
  `officer_recommend` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee_receipt_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_fee_payed` date DEFAULT NULL,
  `date_sent_for_decision` date DEFAULT NULL,
  `decision` int(10) unsigned DEFAULT NULL,
  `date_decision` date DEFAULT NULL,
  `signature_on_permit_license` int(10) unsigned DEFAULT NULL,
  `date_permit_license` date DEFAULT NULL,
  `permit_license_no` int(10) unsigned DEFAULT NULL,
  `date_permit_license_expired` date DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permits_licenses_project_id_foreign` (`project_id`),
  KEY `permits_licenses_user_id_foreign` (`user_id`),
  CONSTRAINT `permits_licenses_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `permits_licenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `permits_licenses_documentation`;
CREATE TABLE `permits_licenses_documentation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permit_license_id` int(10) unsigned DEFAULT NULL,
  `file_metadata_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permits_licenses_documentation_permit_license_id_foreign` (`permit_license_id`),
  KEY `permits_licenses_documentation_file_metadata_id_foreign` (`file_metadata_id`),
  CONSTRAINT `permits_licenses_documentation_file_metadata_id_foreign` FOREIGN KEY (`file_metadata_id`) REFERENCES `file_metadata` (`id`),
  CONSTRAINT `permits_licenses_documentation_permit_license_id_foreign` FOREIGN KEY (`permit_license_id`) REFERENCES `permits_licenses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `permits_licenses_personnel`;
CREATE TABLE `permits_licenses_personnel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permit_license_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permits_licenses_personnel_permit_license_id_foreign` (`permit_license_id`),
  KEY `permits_licenses_personnel_user_id_foreign` (`user_id`),
  CONSTRAINT `permits_licenses_personnel_permit_license_id_foreign` FOREIGN KEY (`permit_license_id`) REFERENCES `permits_licenses` (`id`),
  CONSTRAINT `permits_licenses_personnel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `practitioners`;
CREATE TABLE `practitioners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `practitioner_title_id` int(10) unsigned DEFAULT NULL,
  `person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tin` bigint(20) unsigned DEFAULT NULL,
  `organisation_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visiting_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `box_no` int(10) unsigned DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` int(10) unsigned DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qualifications` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expertise` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `practitioners_practitioner_title_id_foreign` (`practitioner_title_id`),
  CONSTRAINT `practitioners_practitioner_title_id_foreign` FOREIGN KEY (`practitioner_title_id`) REFERENCES `codes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `practitioner_certificates`;
CREATE TABLE `practitioner_certificates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `practitioner_id` int(10) unsigned DEFAULT NULL,
  `year` int(10) unsigned DEFAULT NULL,
  `date_of_entry` date DEFAULT NULL,
  `cert_type` int(10) unsigned DEFAULT NULL,
  `number` int(10) unsigned DEFAULT NULL,
  `cert_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conditions` int(10) unsigned DEFAULT NULL,
  `is_cancelled` tinyint(1) DEFAULT '0',
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `practitioner_certificates_practitioner_id_foreign` (`practitioner_id`),
  CONSTRAINT `practitioner_certificates_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `practitioners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `district_id` int(10) unsigned DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` decimal(24,6) DEFAULT NULL,
  `latitude` decimal(24,6) DEFAULT NULL,
  `has_industrial_waste_water` int(10) unsigned DEFAULT NULL,
  `organisation_id` int(10) unsigned DEFAULT NULL,
  `remarks` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `risk_level` int(10) unsigned DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `projects_category_id_foreign` (`category_id`),
  KEY `projects_district_id_foreign` (`district_id`),
  KEY `projects_organisation_id_foreign` (`organisation_id`),
  CONSTRAINT `projects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `projects_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  CONSTRAINT `projects_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `team_members`;
CREATE TABLE `team_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `practitioner_id` int(10) unsigned DEFAULT NULL,
  `eia_permit_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_members_practitioner_id_foreign` (`practitioner_id`),
  KEY `team_members_eia_permit_id_foreign` (`eia_permit_id`),
  CONSTRAINT `team_members_eia_permit_id_foreign` FOREIGN KEY (`eia_permit_id`) REFERENCES `eias_permits` (`id`),
  CONSTRAINT `team_members_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `practitioners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `team_members_external_audits`;
CREATE TABLE `team_members_external_audits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `practitioner_id` int(10) unsigned DEFAULT NULL,
  `external_audit_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_members_external_audits_practitioner_id_foreign` (`practitioner_id`),
  KEY `team_members_external_audits_external_audit_id_foreign` (`external_audit_id`),
  CONSTRAINT `team_members_external_audits_external_audit_id_foreign` FOREIGN KEY (`external_audit_id`) REFERENCES `external_audits` (`id`),
  CONSTRAINT `team_members_external_audits_practitioner_id_foreign` FOREIGN KEY (`practitioner_id`) REFERENCES `practitioners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `initials` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_position_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_position_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_passive` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_initials_unique` (`initials`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2021-06-05 12:15:42