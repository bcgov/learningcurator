--
--
-- Learning Curator Starter SQL file
-- A blank slate for a new installation with no initial pathways set up.
-- 

CREATE TABLE `sessions` (
  `id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP, -- Optional
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Optional
  `data` blob DEFAULT NULL, -- for PostgreSQL use bytea instead of blob
  `expires` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
);


CREATE TABLE IF NOT EXISTS `ministries` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `elm_learner_group` varchar(255) NOT NULL
,  `description` text
,  `hyperlink` varchar(255) DEFAULT NULL
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
,  `featured` integer DEFAULT '0'
);


CREATE TABLE IF NOT EXISTS `users` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `idir` varchar(255) NOT NULL
,  `ministry_id` integer NOT NULL
,  `role_id` integer NOT NULL
,  `image_path` varchar(255) DEFAULT NULL
,  `email` varchar(255) NOT NULL
,  `password` varchar(255) NOT NULL
,  `created` datetime NOT NULL
,  CONSTRAINT `user_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`)
,  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);




CREATE TABLE IF NOT EXISTS `statuses` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  CONSTRAINT `stat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
);



CREATE TABLE IF NOT EXISTS `activity_types` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `color` varchar(255) DEFAULT NULL
,  `delivery_method` varchar(255) DEFAULT NULL
,  `image_path` varchar(255) DEFAULT NULL
,  `featured` integer DEFAULT '0'
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby` integer NOT NULL
,  CONSTRAINT `activity_type_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
,  CONSTRAINT `activity_type_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);




CREATE TABLE IF NOT EXISTS `categories` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
,  `featured` varchar(255) DEFAULT NULL
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  CONSTRAINT `cat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `topics` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
,  `featured` varchar(255) DEFAULT NULL
,  `created` datetime NOT NULL
,  `user_id` integer NOT NULL
,  CONSTRAINT `topic_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE IF NOT EXISTS `categories_topics` (
 `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `category_id` integer NOT NULL
, `topic_id` integer NOT NULL
,  CONSTRAINT `categories_topics_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
,  CONSTRAINT `categories_topics_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
);


CREATE TABLE IF NOT EXISTS `competencies` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
,  `featured` varchar(255) DEFAULT NULL
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby` integer NOT NULL
,  CONSTRAINT `comp_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
,  CONSTRAINT `comp_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `activities` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `hyperlink` varchar(255) DEFAULT NULL
,  `description` text
,  `licensing` text
,  `moderator_notes` text
,  `isbn` varchar(100) DEFAULT NULL
,  `status_id` integer DEFAULT '1'
,  `meta_title` varchar(255) DEFAULT NULL
,  `meta_description` text
,  `featured` integer DEFAULT '0'
,  `moderation_flag` integer DEFAULT '0'
,  `file_path` varchar(255) DEFAULT NULL
,  `image_path` varchar(255) DEFAULT NULL
,  `hours` integer DEFAULT '0'
,  `recommended` integer DEFAULT '0'
,  `ministry_id` integer DEFAULT NULL
,  `approvedby_id` integer DEFAULT '1'
,  `created` datetime NOT NULL
,  `createdby_id` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby_id` integer NOT NULL
,  `activity_types_id` integer NOT NULL
,  `estimated_time` varchar(100)
,  `slug` varchar(255)
,  CONSTRAINT `activities_ibfk_0` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`)
,  CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`activity_types_id`) REFERENCES `activity_types` (`id`)
,  CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`)
,  CONSTRAINT `activityapprovedby_ibfk_1` FOREIGN KEY (`approvedby_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `activitycreateduser_ibfk_1` FOREIGN KEY (`createdby_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `activitymodifieduser_ibfk_1` FOREIGN KEY (`modifiedby_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `activities_competencies` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `competency_id` integer NOT NULL
,  CONSTRAINT `competencies_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
,  CONSTRAINT `competencies_activities_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
);


CREATE TABLE `pathways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `description` text,
  `objective` text,
  `file_path` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT '0',
  `topic_id` int(11) DEFAULT NULL,
  `ministry_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `status_id` int(100) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `estimated_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_pathways_pathway_topic_ibfk_1` (`topic_id`),
  KEY `idx_pathways_pathway_ministry_ibfk_1` (`ministry_id`),
  KEY `idx_pathways_pathway_createduser_ibfk_1` (`createdby`),
  KEY `idx_pathways_pathway_modifieduser_ibfk_1` (`modifiedby`),
  CONSTRAINT `pathway_topic_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`),
  CONSTRAINT `pathway_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `pathway_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`),
  CONSTRAINT `pathway_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `tags` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby` integer NOT NULL
,  CONSTRAINT `tagcreateduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
,  CONSTRAINT `tagmodifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);



CREATE TABLE IF NOT EXISTS `activities_tags` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `tag_id` integer NOT NULL
,  CONSTRAINT `tags_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
,  CONSTRAINT `tags_activities_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
);


CREATE TABLE IF NOT EXISTS `competencies_pathways` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `competency_id` integer NOT NULL
,  `pathway_id` integer NOT NULL
,  CONSTRAINT `competencies_pathways_ibfk_1` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
,  CONSTRAINT `competencies_pathways_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
);

CREATE TABLE IF NOT EXISTS `competencies_users` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `competency_id` integer NOT NULL
,  `user_id` integer NOT NULL
,  `priority` varchar(255) DEFAULT NULL
,  CONSTRAINT `competencies_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `competencies_users_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
);


CREATE TABLE IF NOT EXISTS `steps` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `slug` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `featured` integer DEFAULT '0'
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby` integer NOT NULL
,  CONSTRAINT `step_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
,  CONSTRAINT `step_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `pathways_steps` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `step_id` integer NOT NULL
,  `pathway_id` integer NOT NULL
,  `sortorder` integer DEFAULT 0
,  `date_start` datetime DEFAULT NULL
,  `date_complete` datetime DEFAULT NULL
,  CONSTRAINT `pathways_steps_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
,  CONSTRAINT `pathways_steps_ibfk_2` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
);



CREATE TABLE IF NOT EXISTS `activities_steps` (
`id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `step_id` integer NOT NULL
,  `required` integer DEFAULT 0
,  `steporder` integer DEFAULT 0
,  `stepcontext` text
,  CONSTRAINT `activities_steps_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
,  CONSTRAINT `activities_steps_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
);



CREATE TABLE IF NOT EXISTS `reports` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `user_id` integer NOT NULL
,  `issue` text
,  `curator_id` integer DEFAULT NULL
,  `response` text
,  `created` datetime NOT NULL
,  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`curator_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `report_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
);

CREATE TABLE IF NOT EXISTS `activities_users` (
   `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `user_id` integer NOT NULL
,  `created` datetime NOT NULL
,  CONSTRAINT `users_activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `users_activities_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
);

CREATE TABLE IF NOT EXISTS `pathways_users` (
    `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `user_id` integer NOT NULL
,  `pathway_id` integer NOT NULL
,  `status_id` integer DEFAULT '1'
,  `date_start` datetime DEFAULT NULL
,  `date_complete` datetime DEFAULT NULL
,  CONSTRAINT `pathways_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `pathways_users_ibfk_2` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
,  CONSTRAINT `pathways_users_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`)
);
