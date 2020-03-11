--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hyperlink` varchar(255) DEFAULT NULL,
  `description` text,
  `licensing` text,
  `moderator_notes` text,
  `isbn` varchar(100) DEFAULT NULL,
  `status_id` int(11) DEFAULT '1',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `featured` int(11) DEFAULT '0',
  `moderation_flag` int(11) DEFAULT '0',
  `file_path` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `hours` int(11) DEFAULT '0',
  `recommended` int(11) DEFAULT '0',
  `ministry_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `approvedby_id` int(11) DEFAULT '1',
  `created` datetime NOT NULL,
  `createdby_id` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby_id` int(11) NOT NULL,
  `activity_types_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_ibfk_0` (`status_id`),
  KEY `activities_ibfk_1` (`activity_types_id`),
  KEY `activities_ibfk_2` (`ministry_id`),
  KEY `activities_ibfk_3` (`category_id`),
  KEY `activityapprovedby_ibfk_1` (`approvedby_id`),
  KEY `activitycreateduser_ibfk_1` (`createdby_id`),
  KEY `activitymodifieduser_ibfk_1` (`modifiedby_id`),
  CONSTRAINT `activities_ibfk_0` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`activity_types_id`) REFERENCES `activity_types` (`id`),
  CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`),
  CONSTRAINT `activities_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `activityapprovedby_ibfk_1` FOREIGN KEY (`approvedby_id`) REFERENCES `users` (`id`),
  CONSTRAINT `activitycreateduser_ibfk_1` FOREIGN KEY (`createdby_id`) REFERENCES `users` (`id`),
  CONSTRAINT `activitymodifieduser_ibfk_1` FOREIGN KEY (`modifiedby_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `activities_competencies`
--

DROP TABLE IF EXISTS `activities_competencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_competencies` (
  `activity_id` int(11) NOT NULL,
  `competency_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`competency_id`),
  KEY `competency_key` (`competency_id`),
  CONSTRAINT `competencies_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `competencies_activities_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `activities_steps`
--

DROP TABLE IF EXISTS `activities_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_steps` (
  `activity_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `required` int(11) DEFAULT '0',
  `steporder` int(11) DEFAULT '0',
  PRIMARY KEY (`activity_id`,`step_id`),
  KEY `step_key` (`step_id`),
  CONSTRAINT `activities_steps_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `activities_steps_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Table structure for table `activities_tags`
--

DROP TABLE IF EXISTS `activities_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_tags` (
  `activity_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`tag_id`),
  KEY `tag_key` (`tag_id`),
  CONSTRAINT `tags_activities_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `tags_activities_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Table structure for table `activities_users`
--

DROP TABLE IF EXISTS `activities_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_users` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `started` datetime DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `liked` int(11) DEFAULT '0',
  `notes` text,
  PRIMARY KEY (`user_id`,`activity_id`),
  KEY `activity_key` (`activity_id`),
  CONSTRAINT `users_activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_activities_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `activity_types`
--

DROP TABLE IF EXISTS `activity_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `color` varchar(255) DEFAULT NULL,
  `delivery_method` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_type_createduser_ibfk_1` (`createdby`),
  KEY `activity_type_modifieduser_ibfk_1` (`modifiedby`),
  CONSTRAINT `activity_type_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `activity_type_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  KEY `cat_createduser_ibfk_1` (`createdby`),
  CONSTRAINT `cat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Leadership','','','','','2020-02-02 04:07:02',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competencies`
--

DROP TABLE IF EXISTS `competencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  KEY `comp_createduser_ibfk_1` (`createdby`),
  KEY `comp_modifieduser_ibfk_1` (`modifiedby`),
  CONSTRAINT `comp_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `comp_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--
-- Table structure for table `competencies_pathways`
--

DROP TABLE IF EXISTS `competencies_pathways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competencies_pathways` (
  `competency_id` int(11) NOT NULL,
  `pathway_id` int(11) NOT NULL,
  PRIMARY KEY (`competency_id`,`pathway_id`),
  KEY `competencies_pathways_ibfk_1` (`pathway_id`),
  CONSTRAINT `competencies_pathways_ibfk_1` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`),
  CONSTRAINT `competencies_pathways_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `competencies_users`
--

DROP TABLE IF EXISTS `competencies_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competencies_users` (
  `competency_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `priority` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`competency_id`,`user_id`),
  KEY `competencies_users_ibfk_1` (`user_id`),
  CONSTRAINT `competencies_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `competencies_users_ibfk_2` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ministries`
--

DROP TABLE IF EXISTS `ministries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ministries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `elm_learner_group` varchar(255) NOT NULL,
  `description` text,
  `hyperlink` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ministries`
--

LOCK TABLES `ministries` WRITE;
/*!40000 ALTER TABLE `ministries` DISABLE KEYS */;
INSERT INTO `ministries` VALUES (1,'BC Public Service Agency','All Government of British Columbia Learners','','','','',1);
/*!40000 ALTER TABLE `ministries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pathways`
--

DROP TABLE IF EXISTS `pathways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pathways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `description` text,
  `objective` text,
  `file_path` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `ministry_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `pathway_category_ibfk_1` (`category_id`),
  KEY `pathway_ministry_ibfk_1` (`ministry_id`),
  KEY `pathway_createduser_ibfk_1` (`createdby`),
  KEY `pathway_modifieduser_ibfk_1` (`modifiedby`),
  CONSTRAINT `pathway_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `pathway_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `pathway_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`),
  CONSTRAINT `pathway_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pathways_steps`
--

DROP TABLE IF EXISTS `pathways_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pathways_steps` (
  `step_id` int(11) NOT NULL,
  `pathway_id` int(11) NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_complete` datetime DEFAULT NULL,
  PRIMARY KEY (`step_id`,`pathway_id`),
  KEY `pathway_key` (`pathway_id`),
  CONSTRAINT `pathways_steps_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`),
  CONSTRAINT `pathways_steps_ibfk_2` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pathways_users`
--

DROP TABLE IF EXISTS `pathways_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pathways_users` (
  `user_id` int(11) NOT NULL,
  `pathway_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT '1',
  `date_start` datetime DEFAULT NULL,
  `date_complete` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`pathway_id`),
  KEY `pathway_key` (`pathway_id`),
  KEY `pathways_users_ibfk_3` (`status_id`),
  CONSTRAINT `pathways_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pathways_users_ibfk_2` FOREIGN KEY (`pathway_id`) REFERENCES `pathways` (`id`),
  CONSTRAINT `pathways_users_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Learner','These are regular end-users who can\'t do anything but join pathways and claim activities.','',''),(2,'Curator','Curators are the subject matter experts who create pathways, add steps, assigning activities to steps, and determining which activities are required for pathway completion.','',''),(5,'Super User','Can do anything, anywhere.','','');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `stat_createduser_ibfk_1` (`createdby`),
  CONSTRAINT `stat_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (1,'Active','','2020-02-02 04:00:07',1),(2,'Defunct','Activities that, for one reason or another, are no longer valid (e.g. a YouTube video that\'s been taken down)','2020-02-09 18:46:41',1);
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `steps`
--

DROP TABLE IF EXISTS `steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `step_createduser_ibfk_1` (`createdby`),
  KEY `step_modifieduser_ibfk_1` (`modifiedby`),
  CONSTRAINT `step_createduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `step_modifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  KEY `tagcreateduser_ibfk_1` (`createdby`),
  KEY `tagmodifieduser_ibfk_1` (`modifiedby`),
  CONSTRAINT `tagcreateduser_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `users` (`id`),
  CONSTRAINT `tagmodifieduser_ibfk_1` FOREIGN KEY (`modifiedby`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (2,'Book','Physical book','2020-02-08 18:49:48',1,'2020-02-08 18:49:48',1),(3,'YouTube','Videos hosted on the YouTube platform (Google)','2020-02-08 18:50:17',1,'2020-02-08 18:55:46',1),(4,'Podcast','A series of audio-only recordings, usually discussions on various topics.','2020-02-08 18:50:53',1,'2020-02-08 18:50:53',1),(5,'PDF','An Adobe Portable Document Format (PDF) resource.','2020-02-08 18:51:54',1,'2020-02-08 18:51:54',1),(6,'Website','A general-purpose website','2020-02-08 18:52:25',1,'2020-02-08 18:52:25',1),(7,'Web App','An application which is accessible via the world wide web. ','2020-02-08 18:53:16',1,'2020-02-08 18:53:16',1),(8,'iOS App','A mobile app designed for Apple\'s iOS/iPadOS devices.','2020-02-08 18:53:50',1,'2020-02-08 18:53:50',1),(9,'Android App','A mobile application designed for Google\'s Android platform.','2020-02-08 18:54:17',1,'2020-02-08 18:54:17',1),(10,'eBook','Not all physical books are available in eBook format. ','2020-02-08 18:55:21',1,'2020-02-08 18:55:21',1),(11,'Vimeo','A video-hosting platform.','2020-02-08 18:56:06',1,'2020-02-08 18:56:06',1),(12,'Social Media','This activity relates somehow to social media and its platforms.','2020-02-08 18:56:43',1,'2020-02-08 18:56:43',1),(13,'Learning System Course','','2020-03-01 03:19:38',1,'2020-03-01 03:19:38',1);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `idir` varchar(255) NOT NULL,
  `ministry_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_ministry_ibfk_1` (`ministry_id`),
  KEY `user_role_ibfk_1` (`role_id`),
  CONSTRAINT `user_ministry_ibfk_1` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`),
  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Allan','ahaggett',1,5,'','allan.haggett@gov.bc.ca','$2y$10$72lxcQm.SiM.dnvK3Ldv4.A9RtIThDwlVnO1slyH./WfW/damMWVC');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

