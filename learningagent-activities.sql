--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);


--
-- Table structure for table `ministries`
--

DROP TABLE IF EXISTS `ministries`;
CREATE TABLE `ministries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `elm_learner_group` varchar(255) NOT NULL,
  `description` text,
  `hyperlink` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
);


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE users (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `idir` VARCHAR(255) NOT NULL,
  `ministry_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`),
  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);


--
-- Table structure for table `competencies`
--

DROP TABLE IF EXISTS `competencies`;
CREATE TABLE `competencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `featured` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `comp_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `comp_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);

--
-- Table structure for table `competencies_users`
-- Competencies which a user has identified as wanting to develop
--

DROP TABLE IF EXISTS `competencies_users`;
CREATE TABLE `competencies_users` (
  `competency_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `priority` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`competency_id`,`user_id`),
  CONSTRAINT `competencies_users_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`),
  CONSTRAINT `competencies_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);



--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  CONSTRAINT `stat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
);

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `featured` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `cat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
);


--
-- Table structure for table `pathways`
--

DROP TABLE IF EXISTS `pathways`;
CREATE TABLE `pathways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `description` text,
  `objective` text,
  `file_path` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `ministry_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  CONSTRAINT `pathway_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `pathway_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`),
  CONSTRAINT `pathway_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `pathway_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);

--
-- Table structure for table `competencies_pathways`
--

DROP TABLE IF EXISTS `competencies_pathways`;
CREATE TABLE `competencies_pathways` (
  `competency_id` int(11) NOT NULL,
  `pathway_id` int(11) NOT NULL,
  PRIMARY KEY (`competency_id`,`pathway_id`),
  CONSTRAINT `competencies_pathways_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`),
  CONSTRAINT `competencies_pathways_ibfk_1` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
);

--
-- Table structure for table `pathways_users`
--

DROP TABLE IF EXISTS `pathways_users`;
CREATE TABLE `pathways_users` (
  `user_id` int(11) NOT NULL,
  `pathway_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT 1,
  `date_start` datetime DEFAULT NULL,
  `date_complete` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`pathway_id`),
  KEY `pathway_key` (`pathway_id`),
  CONSTRAINT `pathways_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pathways_users_ibfk_2` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`),
  CONSTRAINT `pathways_users_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`)
);


--
-- Table structure for table `steps`
--

DROP TABLE IF EXISTS `steps`;
CREATE TABLE `steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT 0,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `step_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `step_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);

--
-- Table structure for table `pathways_steps`
--

DROP TABLE IF EXISTS `pathways_steps`;
CREATE TABLE `pathways_steps` (
  `step_id` int(11) NOT NULL,
  `pathway_id` int(11) NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_complete` datetime DEFAULT NULL,
  PRIMARY KEY (`step_id`,`pathway_id`),
  KEY `pathway_key` (`pathway_id`),
  CONSTRAINT `pathways_steps_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`),
  CONSTRAINT `pathways_steps_ibfk_2` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
);

--
-- Table structure for table `activity_types`
--

DROP TABLE IF EXISTS `activity_types`;
CREATE TABLE `activity_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `color` varchar(255) DEFAULT NULL,
  `delivery_method` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT 0,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `activity_type_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `activity_type_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hyperlink` varchar(255) DEFAULT NULL,
  `description` text,
  `licensing` text,
  `moderator_notes` text,
  `isbn` varchar(100) DEFAULT NULL,
  `status_id` int(11) DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `featured` int(11) DEFAULT 0,
  `moderation_flag` int(11) DEFAULT 0,
  `file_path` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `hours` int(11) DEFAULT 0,
  `recommended` int(11) DEFAULT 0,
  `ministry_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `approvedby_id` int(11) DEFAULT 1,
  `created` datetime NOT NULL,
  `createdby_id` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby_id` int(11) NOT NULL,
  `activity_types_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `activities_ibfk_0` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`activity_types_id`) REFERENCES `activity_types` (`id`),
  CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`),
  CONSTRAINT `activities_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `activityapprovedby_ibfk_1` FOREIGN KEY (`approvedby_id`) REFERENCES `users` (`id`),
  CONSTRAINT `activitycreateduser_ibfk_1` FOREIGN KEY (`createdby_id`) REFERENCES `users` (`id`),
  CONSTRAINT `activitymodifieduser_ibfk_1` FOREIGN KEY (`modifiedby_id`) REFERENCES `users` (`id`)
);

--
-- Table structure for table `activities_competencies`
--

DROP TABLE IF EXISTS `activities_competencies`;
CREATE TABLE `activities_competencies` (
  `activity_id` int(11) NOT NULL,
  `competency_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`competency_id`),
  KEY `competency_key` (`competency_id`),
  CONSTRAINT `competencies_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `competencies_activities_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
);

--
-- Table structure for table `activities_steps`
--

DROP TABLE IF EXISTS `activities_steps`;
CREATE TABLE `activities_steps` (
  `activity_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `required` int(11) DEFAULT 0,
  `steporder` int(11) DEFAULT 0,
  PRIMARY KEY (`activity_id`,`step_id`),
  KEY `step_key` (`step_id`),
  CONSTRAINT `activities_steps_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `activities_steps_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
);


--
-- Table structure for table `activities_users`
--

DROP TABLE IF EXISTS `activities_users`;
CREATE TABLE `activities_users` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `started` datetime DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `liked` int(11) DEFAULT 0,
  `notes` TEXT DEFAULT NULL,
  PRIMARY KEY (`user_id`,`activity_id`),
  KEY `activity_key` (`activity_id`),
  CONSTRAINT `users_activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_activities_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
);


--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  CONSTRAINT `tagcreateduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `tagmodifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);

--
-- Table structure for table `activities_tags`
--

DROP TABLE IF EXISTS `activities_tags`;
CREATE TABLE `activities_tags` (
  `activity_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`tag_id`),
  KEY `tag_key` (`tag_id`),
  CONSTRAINT `tags_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `tags_activities_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
);


