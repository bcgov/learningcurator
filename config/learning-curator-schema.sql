/** 
This starts a bare-bones Learning Curator with some basic starter data including a primary admin user,
a "Personal Development" pathway.
 */

CREATE TABLE IF NOT EXISTS `roles` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
);
INSERT INTO roles VALUES(1,'Learner','These are regular end-users who can''t do anything but join pathways and claim activities.','','');
INSERT INTO roles VALUES(2,'Curator','Curators are the subject matter experts who create pathways, add steps, assigning activities to steps, and determining which activities are required for pathway completion.','','');
INSERT INTO roles VALUES(5,'Super User','Can do anything, anywhere.','','');

CREATE TABLE IF NOT EXISTS `ministries` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `elm_learner_group` varchar(255) NOT NULL
,  `description` text
,  `hyperlink` varchar(255) DEFAULT NULL
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
,  `featured` integer DEFAULT '0'
);
INSERT INTO ministries VALUES(1,'BC Public Service Agency','All Government of British Columbia Learners','','','','',1);

CREATE TABLE IF NOT EXISTS `users` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `idir` varchar(255) NOT NULL
,  `ministry_id` integer NOT NULL
,  `role_id` integer NOT NULL
,  `image_path` varchar(255) DEFAULT NULL
,  `email` varchar(255) NOT NULL
,  `password` varchar(255) NOT NULL
, `created` datetime,  CONSTRAINT `user_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`)
,  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);

INSERT INTO users VALUES(1,'Super User','ahaggett',1,5,NULL,'super.user@gov.bc.ca','$2y$GDJcDxJlr2LyjsDrvYGfHBH4ZkfNAXHghFOP14f4SuJs7I','2020-07-01 10:10:10');


CREATE TABLE IF NOT EXISTS `statuses` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `description` text
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  UNIQUE (`name`)
,  CONSTRAINT `stat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
);
INSERT INTO statuses VALUES(1,'Draft','','2020-02-02 04:00:07',1);
INSERT INTO statuses VALUES(2,'Published','Activities that, for one reason or another, are no longer valid (e.g. a YouTube video that''s been taken down)','2020-02-09 18:46:41',1);
INSERT INTO statuses VALUES(3,'Defunct','','2020-05-05 19:30:50',1);
INSERT INTO statuses VALUES(4,'Future','An activity or pathway with this status will be included in a scheduled task to see if a publish_on date is passed.','2020-05-05 19:34:40',1);
INSERT INTO statuses VALUES(5,'Suggested','Activities which have been suggested by regular users.','2020-07-11 22:00:55',1);

CREATE TABLE IF NOT EXISTS `categories` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
,  `featured` varchar(255) DEFAULT NULL
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  CONSTRAINT `cat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `activity_types` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
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
INSERT INTO activity_types VALUES(1,'Watch','Only the best of video content from YouTube, Vimeo, and any other source that helps the learning goal.','193,129,183','','fa-video',0,'2020-02-02 03:10:44',1,'2020-07-05 04:19:14',1);
INSERT INTO activity_types VALUES(2,'Read','From real paper books to study abstracts and blog posts; the classic written word enhancing your learning in many ways.','249,145,80','','fa-book-reader',0,'2020-02-02 03:11:03',1,'2020-07-06 23:42:12',1);
INSERT INTO activity_types VALUES(3,'Listen','There are so many things to listen to from podcasts and audio books to radio shows and even music to help achieve your goals.','244,105,115','','fa-headphones',0,'2020-02-02 03:11:24',1,'2020-07-05 04:19:46',1);
INSERT INTO activity_types VALUES(4,'Participate','Activities that require your interactaction, either in person courses, or via elearning, quizzes, or surveys that provide measurable feedback.','255,218,96','','fa-users',0,'2020-02-02 03:11:39',1,'2020-07-05 04:20:02',1);

CREATE TABLE IF NOT EXISTS `competencies` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
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
,  `category_id` integer DEFAULT NULL
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
,  CONSTRAINT `activities_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
,  CONSTRAINT `activityapprovedby_ibfk_1` FOREIGN KEY (`approvedby_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `activitycreateduser_ibfk_1` FOREIGN KEY (`createdby_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `activitymodifieduser_ibfk_1` FOREIGN KEY (`modifiedby_id`) REFERENCES `users` (`id`)
);
/** 26 fields */

CREATE TABLE IF NOT EXISTS `reports` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `user_id` integer NOT NULL
,  `issue` text
,  `curator_id` integer DEFAULT NULL
,  `response` text
,  `created` datetime NOT NULL
,  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`curator_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `report_ibfk_3` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
);



CREATE TABLE IF NOT EXISTS `activities_competencies` (
  `activity_id` integer NOT NULL
,  `competency_id` integer NOT NULL
,  PRIMARY KEY (`activity_id`,`competency_id`)
,  CONSTRAINT `competencies_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
,  CONSTRAINT `competencies_activities_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
);

CREATE TABLE IF NOT EXISTS `tags` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `description` text
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby` integer NOT NULL
,  UNIQUE (`name`)
,  CONSTRAINT `tagcreateduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
,  CONSTRAINT `tagmodifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);
INSERT INTO tags VALUES(2,'Book','Physical book','2020-02-08 18:49:48',1,'2020-02-08 18:49:48',1);
INSERT INTO tags VALUES(3,'YouTube','Videos hosted on the YouTube platform (Google)','2020-02-08 18:50:17',1,'2020-02-08 18:55:46',1);
INSERT INTO tags VALUES(4,'Podcast','A series of audio-only recordings, usually discussions on various topics.','2020-02-08 18:50:53',1,'2020-02-08 18:50:53',1);
INSERT INTO tags VALUES(5,'PDF','An Adobe Portable Document Format (PDF) resource.','2020-02-08 18:51:54',1,'2020-02-08 18:51:54',1);
INSERT INTO tags VALUES(6,'Website','A general-purpose website','2020-02-08 18:52:25',1,'2020-02-08 18:52:25',1);
INSERT INTO tags VALUES(7,'Web App','An application which is accessible via the world wide web. ','2020-02-08 18:53:16',1,'2020-02-08 18:53:16',1);
INSERT INTO tags VALUES(8,'iOS App','A mobile app designed for Apple''s iOS/iPadOS devices.','2020-02-08 18:53:50',1,'2020-02-08 18:53:50',1);
INSERT INTO tags VALUES(9,'Android App','A mobile application designed for Google''s Android platform.','2020-02-08 18:54:17',1,'2020-02-08 18:54:17',1);
INSERT INTO tags VALUES(10,'eBook','Not all physical books are available in eBook format. ','2020-02-08 18:55:21',1,'2020-02-08 18:55:21',1);
INSERT INTO tags VALUES(11,'Vimeo','A video-hosting platform.','2020-02-08 18:56:06',1,'2020-02-08 18:56:06',1);
INSERT INTO tags VALUES(12,'Social Media','This activity relates somehow to social media and its platforms.','2020-02-08 18:56:43',1,'2020-02-08 18:56:43',1);
INSERT INTO tags VALUES(13,'Learning System Course','','2020-03-01 03:19:38',1,'2020-03-01 03:19:38',1);




CREATE TABLE IF NOT EXISTS `pathways` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `color` varchar(255) DEFAULT NULL
,  `description` text
,  `objective` text
,  `file_path` varchar(255) DEFAULT NULL
,  `image_path` varchar(255) DEFAULT NULL
,  `featured` integer DEFAULT '0'
,  `category_id` integer DEFAULT NULL
,  `ministry_id` integer DEFAULT NULL
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby` integer NOT NULL
,  `status_id` integer(100)
,  `slug` varchar(255)
,  `estimated_time` varchar(255)
,  UNIQUE (`name`)
,  CONSTRAINT `pathway_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
,  CONSTRAINT `pathway_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
,  CONSTRAINT `pathway_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`)
,  CONSTRAINT `pathway_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `competencies_pathways` (
  `competency_id` integer NOT NULL
,  `pathway_id` integer NOT NULL
,  PRIMARY KEY (`competency_id`,`pathway_id`)
,  CONSTRAINT `competencies_pathways_ibfk_1` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
,  CONSTRAINT `competencies_pathways_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
);

CREATE TABLE IF NOT EXISTS `competencies_users` (
  `competency_id` integer NOT NULL
,  `user_id` integer NOT NULL
,  `priority` varchar(255) DEFAULT NULL
,  PRIMARY KEY (`competency_id`,`user_id`)
,  CONSTRAINT `competencies_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `competencies_users_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
);



CREATE TABLE IF NOT EXISTS `steps` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `featured` integer DEFAULT '0'
,  `created` datetime NOT NULL
,  `createdby` integer NOT NULL
,  `modified` datetime NOT NULL
,  `modifiedby` integer NOT NULL
,  `slug` varchar(255)
,  CONSTRAINT `step_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
,  CONSTRAINT `step_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
);
=


CREATE TABLE IF NOT EXISTS `pathways_steps` (
  `step_id` integer NOT NULL
,  `pathway_id` integer NOT NULL
,  `date_start` datetime DEFAULT NULL
,  `date_complete` datetime DEFAULT NULL
,  PRIMARY KEY (`step_id`,`pathway_id`)
,  CONSTRAINT `pathways_steps_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
,  CONSTRAINT `pathways_steps_ibfk_2` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
);


CREATE TABLE IF NOT EXISTS `activities_steps` (
`id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `step_id` integer NOT NULL
,  `required` integer DEFAULT '0'
,  `steporder` integer DEFAULT '0'
,  CONSTRAINT `activities_steps_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
,  CONSTRAINT `activities_steps_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
);


CREATE TABLE IF NOT EXISTS `topics` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `name` varchar(255) NOT NULL
,  `description` text
,  `image_path` varchar(255) DEFAULT NULL
,  `color` varchar(255) DEFAULT NULL
,  `featured` varchar(255) DEFAULT NULL
,  `created` datetime NOT NULL
,  `user_id` integer NOT NULL
,  CONSTRAINT `topic_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE IF NOT EXISTS `categories_topics` (
  `category_id` integer NOT NULL
, `topic_id` integer NOT NULL
,  PRIMARY KEY (`category_id`,`topic_id`)
,  CONSTRAINT `categories_topics_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
,  CONSTRAINT `categories_topics_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
);

CREATE TABLE IF NOT EXISTS `pathways_topics` (
  `pathway_id` integer NOT NULL
, `topic_id` integer NOT NULL
,  PRIMARY KEY (`pathway_id`,`topic_id`)
,  CONSTRAINT `pathways_topics_ibfk_1` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
,  CONSTRAINT `pathways_topics_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
);


CREATE TABLE IF NOT EXISTS `activities_bookmarks` (
   `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `user_id` integer NOT NULL
,  `notes` text
,  `created` datetime NOT NULL
,  CONSTRAINT `activities_bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
,  CONSTRAINT `activities_bookmarks_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
);


CREATE TABLE IF NOT EXISTS `activities_tags` (
  `activity_id` integer NOT NULL
,  `tag_id` integer NOT NULL
,  PRIMARY KEY (`activity_id`,`tag_id`)
,  CONSTRAINT `tags_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
,  CONSTRAINT `tags_activities_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
);


CREATE TABLE IF NOT EXISTS `activities_users` (
   `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT
,  `activity_id` integer NOT NULL
,  `user_id` integer NOT NULL
,  `started` datetime DEFAULT NULL
,  `finished` datetime DEFAULT NULL
,  `liked` integer DEFAULT '0'
,  `notes` text
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

CREATE INDEX `idx_statuses_stat_createduser_ibfk_1` ON `statuses` (`createdby`);
CREATE INDEX `idx_competencies_pathways_competencies_pathways_ibfk_1` ON `competencies_pathways` (`pathway_id`);
CREATE INDEX `idx_activity_types_activity_type_createduser_ibfk_1` ON `activity_types` (`createdby`);
CREATE INDEX `idx_activity_types_activity_type_modifieduser_ibfk_1` ON `activity_types` (`modifiedby`);
CREATE INDEX `idx_users_user_ministry_ibfk_1` ON `users` (`ministry_id`);
CREATE INDEX `idx_users_user_role_ibfk_1` ON `users` (`role_id`);
CREATE INDEX `idx_tags_tagcreateduser_ibfk_1` ON `tags` (`createdby`);
CREATE INDEX `idx_tags_tagmodifieduser_ibfk_1` ON `tags` (`modifiedby`);
CREATE INDEX `idx_pathways_steps_pathway_key` ON `pathways_steps` (`pathway_id`);
CREATE INDEX `idx_pathways_pathway_category_ibfk_1` ON `pathways` (`category_id`);
CREATE INDEX `idx_pathways_pathway_ministry_ibfk_1` ON `pathways` (`ministry_id`);
CREATE INDEX `idx_pathways_pathway_createduser_ibfk_1` ON `pathways` (`createdby`);
CREATE INDEX `idx_pathways_pathway_modifieduser_ibfk_1` ON `pathways` (`modifiedby`);
CREATE INDEX `idx_competencies_comp_createduser_ibfk_1` ON `competencies` (`createdby`);
CREATE INDEX `idx_competencies_comp_modifieduser_ibfk_1` ON `competencies` (`modifiedby`);
CREATE INDEX `idx_activities_competencies_competency_key` ON `activities_competencies` (`competency_id`);
CREATE INDEX `idx_activities_activities_ibfk_0` ON `activities` (`status_id`);
CREATE INDEX `idx_activities_activities_ibfk_1` ON `activities` (`activity_types_id`);
CREATE INDEX `idx_activities_activities_ibfk_2` ON `activities` (`ministry_id`);
CREATE INDEX `idx_activities_activities_ibfk_3` ON `activities` (`category_id`);
CREATE INDEX `idx_activities_activityapprovedby_ibfk_1` ON `activities` (`approvedby_id`);
CREATE INDEX `idx_activities_activitycreateduser_ibfk_1` ON `activities` (`createdby_id`);
CREATE INDEX `idx_activities_activitymodifieduser_ibfk_1` ON `activities` (`modifiedby_id`);
CREATE INDEX `idx_activities_tags_tag_key` ON `activities_tags` (`tag_id`);
CREATE INDEX `idx_steps_step_createduser_ibfk_1` ON `steps` (`createdby`);
CREATE INDEX `idx_steps_step_modifieduser_ibfk_1` ON `steps` (`modifiedby`);
CREATE INDEX `idx_competencies_users_competencies_users_ibfk_1` ON `competencies_users` (`user_id`);
CREATE INDEX `idx_categories_cat_createduser_ibfk_1` ON `categories` (`createdby`);
