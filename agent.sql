-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: the_agent
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

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
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (2,'Healthy Workplaces Resources','https://gww.gov.bc.ca/sites/default/files/article/file/2019/0418/healthyworkplaceresourcessheetapril2019.pdf','Covers counselling services, lifestyle management services, online programs, Morneau Shepell Services, other Workplace Health-focused programs & services, and other BC Public Service / Agency Resources','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,1,1,1,'2020-02-02 04:00:18',1,'2020-02-03 02:01:18',1,2),(3,'Accountability Framework for Human Resource Management','https://www2.gov.bc.ca/assets/gov/careers/about-the-bc-public-service/ethics/hr_accountability_framework.pdf','The Accountability Framework establishes the context within which the Agency Head of the BC Public Service Agency delegates authority, under the Public Service Act, to Deputy Ministers, or other Senior Officials for human resource management.','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-15 21:07:59',1,2),(4,'Health, Safety & Sick Leave Resources','https://www2.gov.bc.ca/gov/content/careers-myhr/about-the-bc-public-service/psa-programs-strategies/health-safety-sick-leave','Covers sick leave, workplace safety, ergonomics, Health & Well-being services (counselling, career support, family support, financial services, healthy living services), & other resources','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',4,1,1,1,1,'2020-02-02 04:00:18',1,'2020-02-16 20:51:46',1,4),(5,'Mental Health','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/health/mental','Covers definitions of mental health, information on self-awareness, tips, & the importance of Resilience','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-15 21:13:57',1,2),(6,'Quittin\' Time Smoking Cessation Services','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/health/substance-use-cessation/quittin-time','Information on the program, contact information, products to stop smoking, support','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,1,1,1,'2020-02-02 04:00:18',1,'2020-02-15 21:14:21',1,2),(7,'Substance Use Disorder Treatment Funding','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/health/substance-use-cessation/substance-use-disorder-treatment-funding','funding, eligibility','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(8,'Cold & Flu','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/health/cold-flu','about, resources, and prevention','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(9,'Provincial Employees Community Services Fund (PECSF)','https://www2.gov.bc.ca/gov/content/careers-myhr/about-the-bc-public-service/corporate-social-responsibility/pecsf','About the program, becoming a volunteer, charities','','Imported from L@WW 2019 HWB actions','',2,'','',0,1,'','',1,0,1,1,1,'2020-02-02 04:00:18',1,'2020-02-09 18:48:38',1,2),(10,'Health & Well-being Workshops','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/health/health-well-being-workshops','workshop descriptions, schedule','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(11,'Health Where You Work','https://gww.gov.bc.ca/groups/health-where-you-work','Healthy workplace resources, mindfulness meditation, stretching guide, blogs & articles','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(12,'LifeSpeak Video Library','https://gww.gov.bc.ca/groups/health-where-you-work/lifespeak-video-library','LifeSpeak is an online video library offering employees expert advice on a range of topics including health, relationships, and professional development.','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-18 21:36:40',1,4),(13,'Eat Well, Live Well','https://gww.gov.bc.ca/groups/health-where-you-work/news/2019/0313/eat-well-live-well','Article on @Work outlining the changes to the Canada Food guide','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',0,0,1,NULL,1,'2020-02-02 04:00:18',1,'2020-02-18 21:37:01',1,3),(14,'Healthy Living Services / workhealthlife','https://www.workhealthlife.com/','counselling services, articles, online programs','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',8,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-18 00:05:53',1,1),(15,'LifeWorks - LIFT (Morneau Shepell)','https://lifeworks-global.liftsession.com/','Create account, download app, complete assessment.  Contains custom programs, live chat, resources.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(16,'Canada Food Guide','https://food-guide.canada.ca/en/','Tips, Recipes, Resources','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-18 00:05:01',1,1),(17,'Physical Activity Recommendations (See CSEP Guidelines)','https://www.canada.ca/en/public-health/services/being-active/physical-activity-your-health.html','Benefits, Tips, Recommendations','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(18,'Physical Activity Tips for Adults (18-64 years)','https://www.canada.ca/en/public-health/services/publications/healthy-living/physical-activity-tips-adults-18-64-years.html','PDF Link - Infographic','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(19,'Are Canadian adults getting enough sleep?','um_HYaya5ls','Infographic Link','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,1,NULL,1,'2020-02-02 04:00:18',1,'2020-03-01 05:52:03',1,3),(20,'Mental Health and Wellness','https://www.canada.ca/en/public-health/topics/mental-health-wellness.html','Information on mental health, mental illness, health services, PTSD, and Cannabis & mental health','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(21,'Canadian 24-Hour Movement Guidelines','https://csepguidelines.ca/','Overview of guidelines, links to guides for age groups and special populations','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',3,0,1,1,1,'2020-02-02 04:00:18',1,'2020-02-16 20:51:01',1,2),(22,'Canadian Physical Activity Guidelines for Adults - 18-64 years','https://csepguidelines.ca/adults-18-64/','Infographic Link','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(23,'Pre-Screening for Physical Activity: Get Active Questionnaire','http://www.csep.ca/CMFiles/GAQ_CSEPPATHReadinessForm_2pages.pdf','For individuals with health concerns to consider completing prior to engaging in physical activity.  Potential tool to provide first steps for individuals with chronic conditions looking to become more active.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(24,'Participaction - Sleep Better','https://www.participaction.com/en-ca/everything-better/sleep-better','Sleep recommendations, tips, and references','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(25,'Participaction - Work Better','https://www.participaction.com/en-ca/everything-better/work-better','Tips for incorporating physical activity into work (with references)','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',2,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-18 00:06:17',1,4),(26,'Participaction - Learn Better','https://www.participaction.com/en-ca/everything-better/learn-better','Information connecting physical with intellectual health','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(27,'Participaction - Age Better','https://www.participaction.com/en-ca/everything-better/age-better','Info and tips for older adults (65+)','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(28,'Participaction - Physical Activity Toolkit for Older Adults','https://prismic-io.s3.amazonaws.com/participaction%2F84f1e964-a43c-419e-994b-57a63c3bf822_pa-seniors-toolkit-design-v03-eng-pa.pdf','Contains PA Guidelines for Older Adults, activiy planning and tracking, articles, and additional resources','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(29,'Participaction - Benefits & Guidelines - Adults: Ages 18 to 64','https://www.participaction.com/en-ca/benefits-and-guidelines/adults-18-to-64','Contains recommendations, reasoning, & benefits','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(30,'The 2018 ParticipACTION Report Card on Physical Activity for Children & Youth','https://www.participaction.com/en-ca/resources/report-card','Contains full and highlight reports broken down by categories','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(31,'Physical Activity','https://www.who.int/en/news-room/fact-sheets/detail/physical-activity','Key facts, what, how much, benefits, tips','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(32,'Healthy diet','https://www.who.int/en/news-room/fact-sheets/detail/healthy-diet','Key facts, overview, recommendations, how to promote a healthy diet','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(33,'Mental health: strengthening our response','https://www.who.int/news-room/fact-sheets/detail/mental-health-strengthening-our-response','Key facts, determinants, mental health promotion, protection, care, & treatment','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,1,1,1,'2020-02-02 04:00:18',1,'2020-02-02 23:33:10',1,2),(34,'Obesity and overweight','https://www.who.int/news-room/fact-sheets/detail/obesity-and-overweight','Key facts, definitions, causes, health consequences','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(35,'Natural toxins in food','https://www.who.int/news-room/fact-sheets/detail/natural-toxins-in-food','Key facts, definitions, how to minimize risk','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(36,'It\'s Good to Give','https://gww.gov.bc.ca/news/2019/0809/its-good-give','August 9, 2019.  Info and poll on donating and volunteering.  Links to GivingTuesday and University of Zurich study linking generosity and happiness.','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-18 00:06:04',1,2),(37,'Giving Tuesday','https://givingtuesday.ca/','\"GivingTuesday is a global day of giving. After the sales of Black Friday and Cyber Monday, GivingTuesday is a time to celebrate and encourage activities that support charities and non profits\"','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(38,'A neural link between generosity and happiness','https://www.nature.com/articles/ncomms15964.pdf','Study from the University of Zerich showing that individuals who made more generous decisions were found to show greater self-reported happiness.  Linked from @Work article - It\'s Good to Give','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',3,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-18 00:05:34',1,1),(39,'Nutrition and supplement information based on science','https://examine.com/','An independent education organization that analyzes nutrition and supplement research.  Research based articles on nutrition, supplements, & other health topics','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(40,'Accessibility in the BC Public Service','https://gww.gov.bc.ca/groups/accessibility-bc-public-service','Information on Work-Able, Employee Accessibility Advisory Council, as well as Resources, Articles and Blogs','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,1,1,1,'2020-02-02 04:00:18',1,'2020-02-03 03:15:32',1,2),(41,'Workplace Safety','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/workplace/planning/ergonomics','Emergency assistance, domestic violence, unsafe work, safety planning & training','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(42,'Ergonomics','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/workplace/planning/ergonomics','Tips, resources, Workstation Self Setup E-Tool','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(43,'WorkSafeBC','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/workplace/worksafebc','Information & resources','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(44,'Workplace Hazardous Materials Information System (WHMIS) 2015','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/workplace/planning/whmis-2015','Information on the System, link to WHMIS 2015 Training E-course','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(45,'Financial & Legal Services','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/health/efas/financial-legal','Information on programs and services','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(46,'Career Support Services','https://www2.gov.bc.ca/gov/content/careers-myhr/all-employees/safety-health-well-being/health/efas/career-services','Advice, coaching, and retirement planning','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(47,'Health-bent - Resource List','https://gww.gov.bc.ca/blogs/health-bent/news/2018/0221/resource_list','Resources in a number of areas with an emphasis on mental health','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(48,'edX','https://www.edx.org/','Mission: Increase access to high-quality education for everyone, everywhere.  Enhance teaching and learning on campus and online.  Advance teaching and learning through research','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(49,'Getting help from a credit counsellor','https://www.canada.ca/en/financial-consumer-agency/services/debt/debt-help.html','Financial counselling, information, & options','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(50,'CleanBC Active Transportation Strategy','https://cleanbc.gov.bc.ca/active/','BC\'s strategy for cleaner, more active transportation','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(51,'The Core Values Workbook','https://dawnbarclay.com/resources/freeresources/','Self-development resource','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(52,'Depression Chart','https://depressionchart.com/','12 question survey that outputs an immediate chart value (score) that may help in diagnosing depression.  Developed by Allan Haggett.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(53,'Anxiety Canada','https://anxietycanada.com/','Expert tools and resources to help Canadians manage anxiety.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(54,'BounceBack','https://cmha.bc.ca/programs-services/bounce-back/','BounceBack is a free skill-building program designed to help adults and youth 15+ manage low mood, mild to moderate depression, anxiety, stress or worry. Delivered online or over the phone with a coach, you will get access to tools that will support you on your path to mental wellness.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(55,'Anxiety in Adults','https://anxietycanada.com/learn-about-anxiety/anxiety-in-adults/','','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(56,'My Anxiety Plans','https://maps.anxietycanada.com/','My Anxiety Plans (MAPs) are anxiety management programs based on cognitive-behavioural therapy (CBT), an evidence-based psychological treatment. You can choose from two MAPs - Children/Teens and Adults.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(57,'MindShift CBT (App)','https://anxietycanada.com/resources/mindshift-cbt/','Is anxiety getting in the way of your life? MindShift CBT uses scientifically proven strategies based on Cognitive Behavioural Therapy (CBT) to help you learn to relax and be mindful, develop more effective ways of thinking, and use active steps to take charge of your anxiety.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(58,'What Helps, What Hurts','https://www.heretohelp.bc.ca/infosheet/what-helps-what-hurts','The What Helps, What Hurts 4-step guide will point you in the direction of what to say and what not to say when you want to help and support a friend who is feeling down or depressed.','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,1,1,1,'2020-02-02 04:00:18',1,'2020-02-16 20:51:14',1,4),(59,'10 Things Depression Makes Us Do (Video)','https://youtu.be/pcmoQinDhJ4','Depression is a sneaky mental disorder. It\'s difficult to catch during the early stages. Most of us realize we have depression when we are deep in the grips of it. Those with this mental disorder feel hopeless, empty or sad, fatigued, irritable, and restless. Here are 10 things Depression makes us do.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(60,'Diabetes Canada','https://www.diabetes.ca/','Diabetes basics; recently diagnosed; signs, risks, & prevention; managing my diabetes, get involved','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(61,'Family Caregivers of British Columbia','https://www.familycaregiversbc.ca/about-family-caregivers-of-british-columbia/','Family Caregivers of British Columbia is a registered non-profit dedicated 100% to supporting family caregivers.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(62,'CSC: Caregiver Self Care - National Initiative for the Care of the Elderly','http://www.nicenet.ca/tools-csc-caregiver-self-care','In addition to managing the challenges of caring for a person with a chronic disease such as dementia, caregivers need to attend to their health needs so as to prevent the onset of disease and increase overall quality of life.  Tips for aiding in the maintenance of healthy lifestyle behaviors.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(63,'McMaster University - Caring for the caregivers','https://www.mcmasteroptimalaging.org/hitting-the-headlines/detail/hitting-the-headlines/2018/04/04/caring-for-the-caregivers','Some helpful evidence-based resources for caregivers.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:18',1,'2020-02-02 04:00:18',1,1),(64,'Caregiver stress: Tips for taking care of yourself','https://www.mayoclinic.org/healthy-lifestyle/stress-management/in-depth/caregiver-stress/art-20044784','Caring for a loved one strains even the most resilient people. If you\'re a caregiver, take steps to preserve your own health and well-being.  Strategies for dealing with caregiver stress.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(65,'British Columbia Bereavement Helpline','https://www.bcbh.ca/','We are a non-profit, free, and confidential service that connects the public to grief support services within the province of BC.','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',1,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-16 03:29:13',1,3),(66,'Victoria Hospice - Online Resources','https://victoriahospice.org/resources/helpful-resources/','At Victoria Hospice, we try to help you find a way through the overwhelming emotions and practical realities of coping with end-of-life illness.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(67,'HealthLinkBC','https://www.healthlinkbc.ca/','Urgent and Primary Care Centres, HealthLinkBC Files, Find Health Services, Check your Symptoms, and more.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(68,'Health Topics','https://medlineplus.gov/healthtopics.html','Read about symptoms, causes, treatment and prevention for over 1000 diseases, illnesses, health conditions and wellness issues. MedlinePlus health topics are regularly reviewed, and links are updated daily.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(69,'Heart disease','https://www.heartandstroke.ca/heart','What is heart disease; signs of a heart attack; conditions, tests, & treatments; living with heart disease; risk and prevention; heart disease news.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(70,'Optimal Aging Portal','https://www.mcmasteroptimalaging.org/','A wealth of information on healthy aging.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(71,'Mental health and substance use information you can trust','https://www.heretohelp.bc.ca/','We\'re here to help you find quality information, learn new skills, and connect with key resources in BC. Explore strategies to help you take care of your mental health and use substances in healthier ways, find the information you need to manage mental health and substance use problems, and learn how you can support a loved one.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(72,'Canadian Mental Health Association BC','https://cmha.bc.ca/','Founded in 1918, the Canadian Mental Health Association (CMHA) is a national charity that helps maintain and improve mental health for all Canadians. As the nation-wide leader and champion for mental health, CMHA promotes the mental health of all and supports the resilience and recovery of people experiencing mental illness.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(73,'MyWorkplaceHealth Resources List','https://www.myworkplacehealth.com/resources','Research, tools and resources for insights into psychological health and safety in the workplace','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(74,'PsychAlive: Psychology for Everyday Life','https://www.psychalive.org/','Articles, webinars, and e-courses on a variety of psychological topics','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(75,'FamilySmart','http://www.familysmart.ca/','FamilySmart is a non-profit organization that comes alongside young people and families to provide support, navigation assistance and information and invites them and professionals to come alongside each other to learn with and from each other to enhance the quality of experiences and services for child and youth mental health','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(76,'Heads Up Guys','https://headsupguys.org/','HeadsUpGuys is a resource for supporting men in their fight against depression by providing tips, tools, information about professional services, and stories of success.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(77,'Canadian Centre for Occupational Health & Safety: Healthy Workplaces: Mental Health','https://www.ccohs.ca/healthyworkplaces/topics/mentalhealth.html','Articles, videos, and other resources on mental health in the workplace','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(78,'Occupationally Aware Clinical Directory','https://firstresponderhealth.org/directory','First Responder Health provides a variety of innovative mental healthcare services for Emergency Workers by utilizing our network of Occupationally Aware Clinicians.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(79,'Canada Life - Workplace Strategies for Mental Health ','https://www.workplacestrategiesformentalhealth.com/','Workplace Strategies for Mental Health (Workplace Strategies) seeks to increase knowledge and awareness of workplace psychological health and safety, improve the ability to respond to mental health issues at work, and turn knowledge into action through practical strategies and tools for employers.','','Imported from L@WW 2019 HWB actions',NULL,1,NULL,'',0,0,NULL,NULL,0,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-02 04:00:19',1,1),(80,'Mental Health Commission of Canada','https://www.mentalhealthcommission.ca/English/resources/training/webinars','Free webinars on mental and physical health topics.','','Imported from L@WW 2019 HWB actions','',1,'','',0,0,'','',2,0,NULL,NULL,1,'2020-02-02 04:00:19',1,'2020-02-18 00:05:16',1,1),(81,'Better Call Saul','https://depressionchart.com','Huh','Huh','Huh','',1,'','',0,0,'','',1,0,1,1,1,'2020-02-10 21:24:31',1,'2020-02-11 01:56:53',1,2),(82,'Plus Expenses','https://depressionchart.com','I haven\'t decided.','','','',1,NULL,NULL,0,0,'',NULL,1,0,1,1,1,'2020-02-11 03:37:44',1,'2020-02-11 03:37:44',1,2),(83,'Diversity and Inclusion Essentials','','D&I Essentials is a short eLearning course that we hope will help employees understand the BC Public Service definition of diversity and inclusion, identify the policy and legislation that guide the work, and show how both diversity and inclusion align with BC Public Service values. D&I Essentials includes an introduction and definitions, a short web-based catalogue of legislation and policy, that explains how our corporate values connect to the values of diversity and inclusion. The resource concludes with a final quiz intended to reinforce your understanding. ','','','',1,'','',1,0,'','',8,0,1,1,1,'2020-03-01 03:09:27',1,'2020-03-01 03:21:43',1,4);
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `activities_competencies`
--

LOCK TABLES `activities_competencies` WRITE;
/*!40000 ALTER TABLE `activities_competencies` DISABLE KEYS */;
INSERT INTO `activities_competencies` VALUES (81,1),(83,2),(81,4),(83,14),(83,15),(82,18),(82,21);
/*!40000 ALTER TABLE `activities_competencies` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `activities_steps`
--

LOCK TABLES `activities_steps` WRITE;
/*!40000 ALTER TABLE `activities_steps` DISABLE KEYS */;
INSERT INTO `activities_steps` VALUES (2,3,0,0),(3,9,1,0),(4,2,0,0),(4,5,0,0),(5,5,0,0),(5,9,0,0),(9,2,0,0),(12,3,0,0),(12,7,1,0),(13,3,0,0),(14,7,0,0),(14,10,1,0),(16,2,0,0),(19,2,1,0),(21,2,0,0),(25,10,0,0),(29,4,1,0),(32,11,1,0),(33,4,0,0),(36,10,0,0),(38,3,1,0),(38,5,1,0),(39,11,1,0),(40,5,0,0),(48,5,0,0),(58,2,0,0),(65,10,0,0),(67,8,1,0),(80,3,0,0),(83,2,1,0);
/*!40000 ALTER TABLE `activities_steps` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `activities_tags`
--

LOCK TABLES `activities_tags` WRITE;
/*!40000 ALTER TABLE `activities_tags` DISABLE KEYS */;
INSERT INTO `activities_tags` VALUES (16,2),(21,2),(36,2),(58,2),(81,2),(19,3),(21,3),(36,3),(16,5),(80,5),(82,5),(4,6),(36,6),(58,6),(80,6),(58,7),(21,8),(4,10),(36,11),(80,11),(4,12),(16,12),(83,13);
/*!40000 ALTER TABLE `activities_tags` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `activities_users`
--

LOCK TABLES `activities_users` WRITE;
/*!40000 ALTER TABLE `activities_users` DISABLE KEYS */;
INSERT INTO `activities_users` VALUES (4,1,'2020-02-17 23:52:25',NULL,0,NULL),(9,1,'2020-02-13 02:09:44',NULL,0,NULL),(16,1,'2020-02-18 00:34:50',NULL,0,NULL),(19,1,'2020-02-17 23:55:29',NULL,0,NULL),(21,1,'2020-02-18 00:33:31',NULL,0,NULL),(58,1,'2020-02-18 00:11:47',NULL,0,NULL),(80,1,'2020-02-19 23:37:12',NULL,0,NULL),(83,1,'2020-03-02 22:58:17',NULL,0,NULL),(4,4,'2020-02-17 19:42:51',NULL,0,NULL),(19,4,'2020-02-17 19:44:44',NULL,0,NULL),(4,5,'2020-02-20 19:08:55',NULL,0,NULL),(16,5,'2020-02-20 19:09:06',NULL,0,NULL),(19,5,'2020-02-20 19:09:04',NULL,0,NULL),(21,5,'2020-02-20 19:09:09',NULL,0,NULL),(38,5,'2020-02-20 19:11:20',NULL,0,NULL),(58,5,'2020-02-20 19:12:41',NULL,0,NULL),(4,6,'2020-02-26 18:54:06',NULL,0,NULL),(16,6,'2020-02-26 18:54:19',NULL,0,NULL),(19,6,'2020-02-26 18:54:15',NULL,0,NULL),(21,6,'2020-02-26 18:54:23',NULL,0,NULL),(58,6,'2020-02-26 18:54:32',NULL,0,NULL);
/*!40000 ALTER TABLE `activities_users` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `activity_types`
--

LOCK TABLES `activity_types` WRITE;
/*!40000 ALTER TABLE `activity_types` DISABLE KEYS */;
INSERT INTO `activity_types` VALUES (1,'Watch','Videos to watch','196,77,60','','fa-video',0,'2020-02-02 03:10:44',1,'2020-03-02 22:40:32',1),(2,'Read','Read the things.','255,107,107','','fa-book-reader',0,'2020-02-02 03:11:03',1,'2020-03-01 01:33:56',1),(3,'Listen','Listen to the things. Podcasts; audio books...','199,244,100','','fa-headphones',0,'2020-02-02 03:11:24',1,'2020-03-01 01:34:06',1),(4,'Participate','Face to face courses','78,205,196','','fa-users',0,'2020-02-02 03:11:39',1,'2020-03-01 01:34:20',1);
/*!40000 ALTER TABLE `activity_types` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `competencies`
--

LOCK TABLES `competencies` WRITE;
/*!40000 ALTER TABLE `competencies` DISABLE KEYS */;
INSERT INTO `competencies` VALUES (1,'Analytical Thinking','Analytical Thinking is the ability to comprehend a situation by breaking it down into its components and identifying key or underlying complex issues.  It implies the ability to systematically organize and compare the various aspects of a problem or situation, and determine cause-and-effect relationships (“if...then…”) to resolve problems in a sound, decisive manner.  Checks to ensure the validity or accuracy of all information.','','','','2019-12-15 00:54:56',1,'2019-12-15 00:54:56',1),(2,'Building Partnerships with Stakeholders','Building Partnerships with Stakeholders is the ability to build long-term or on-going relationships with stakeholders (e.g. someone who shares an interest in what you are doing). This type of relationship is often quite deliberate and is typically focused on the way the relationship is conducted. Implicit in this competency is demonstrating a respect for and stating positive expectations of the stakeholder.','','','','2019-12-15 01:00:28',1,'2019-12-15 01:00:28',1),(3,'Business Acumen','Business Acumen is the ability to understand the business implications of decisions and the ability to strive to improve organizational performance.  It requires an awareness of business issues, processes and outcomes as they impact the client’s and the organization’s business needs.','','','','2019-12-15 01:02:28',1,'2019-12-15 01:02:28',1),(4,'Change Leadership ','Change Leadership involves creating a new vision for the organization and taking the required actions to ensure that the members of the organization accept and support the vision.  It generally requires the individual to be in a relatively senior or high level position, although this is not always the case.','','','','2019-12-15 01:03:54',1,'2019-12-15 01:03:54',1),(5,'Change Management ','Change Management is the ability to support a change initiative that has been mandated within the organization.  It involves helping the organization’s members understand what the change means to them, and providing the ongoing guidance and support that will maintain enthusiasm and commitment to the change process.  People with this competency willingly embrace and champion change.  They take advantage of every opportunity to explain their vision of the future to others and gain their buy-in.','','','','2019-12-15 01:04:31',1,'2019-12-15 01:04:31',1),(6,'Commitment to Continuous Learning','Commitment to Continuous Learning involves a commitment to think about the ongoing and evolving needs of the organization and to learn how new and different solutions can be utilized to ensure success and move the organization forward.','','','','2019-12-15 01:05:27',1,'2019-12-15 01:05:27',1),(7,'Conceptual Thinking ','Conceptual Thinking is the ability to identify patterns or connections between situations that are not obviously related, and to identify key or underlying issues in complex situations.  It includes using creative, conceptual or inductive reasoning or thought processes that are not necessarily categorized by linear thinking.','','','','2019-12-15 01:05:51',1,'2019-12-15 01:05:51',1),(8,'Concern for Image Impact ','Concern for Image Impact is an awareness of how one’s self, one’s role and the organization are seen by others. The highest level of this competency involves an awareness of, and preference for, respect for the organization by the community.  Concern for Image Impact is particularly appropriate for senior management positions.','','','','2019-12-15 01:06:24',1,'2019-12-15 01:06:24',1),(9,'Concern for Order ','Concern for Order reflects an underlying drive to reduce uncertainty in the surrounding environment.  It is expressed as monitoring and checking work or information, insisting on clarity of roles and functions, etc.','','','','2019-12-15 01:06:49',1,'2019-12-15 01:06:49',1),(10,'Conflict Management ','Conflict Management is the ability to develop working relationships that facilitate the prevention and/or resolution of conflicts within the organization.','','','','2019-12-15 01:07:28',1,'2019-12-15 01:07:28',1),(11,'Continuous Development ','Continuous Development involves proactively taking actions to improve personal capability. It also involves being willing to assess one\'s own level of development or expertise relative to one\'s current job, or as part of focused career planning.','','','','2019-12-15 01:08:03',1,'2019-12-15 01:08:03',1),(12,'Customer/Client Development ','Customer/Client Development involves the genuine intent to foster the learning or development of a diverse clientele. “Customers/clients” include the public, internal clients, colleagues, partners, co-workers, peers, branches, agencies and other government organizations.','','','','2019-12-15 01:08:43',1,'2019-12-15 01:08:43',1),(13,'Decisive Insight ','Decisive Insight combines the ability to draw on one’s own experience, knowledge and training and effectively problem-solve increasingly difficult and complex situations.  It involves breaking down problems, tracing implications and recognizing patterns and connections that are not obviously related.  It translates into identifying underlying issues and making the best decisions at the most appropriate time.  At higher levels, the parameters upon which to base the decision become increasingly complex and ambiguous and call upon novel ways to think through issues.','','','','2019-12-15 01:09:23',1,'2019-12-15 01:09:23',1),(14,'Developing Others ','Developing Others involves a genuine intent to foster the long-term learning or development of others through coaching, managing performance and mentoring.  Its focus is on developmental intent and effect rather than on a formal role of training.  For this competency to be considered, the individual’s actions should be driven by a genuine desire to develop others, rather than by a need to transfer adequate skills to complete tasks.','','','','2019-12-15 01:10:06',1,'2019-12-15 01:10:06',1),(15,'Empowerment ','Empowerment is the ability to share responsibility with individuals and groups so that they have a deep sense of commitment and ownership.  People who practice empowerment participate and contribute at high levels, are creative and innovative, take sound risks, are willing to be held accountable and demonstrate leadership.  They also foster teamwork among employees, across government and with colleagues, and, as appropriate, facilitate the effective use of teams.','','','','2019-12-15 01:13:08',1,'2019-12-15 01:13:08',1),(16,'Engaging External Partners','Engaging External Partners: identifies and involves external stakeholders in order to foster long term partnerships.','','','','2019-12-15 01:14:33',1,'2019-12-15 01:14:33',1),(17,'Expertise','Expertise includes the motivation to expand and use technical knowledge or to distribute work-related knowledge to others.','','','','2019-12-15 01:15:51',1,'2019-12-15 01:15:51',1),(18,'Flexibility ','Flexibility is the ability and willingness to adapt to and work effectively within a variety of diverse situations, and with diverse individuals or groups.  Flexibility entails understanding and appreciating different and opposing perspectives on an issue, adapting one’s approach as situations change and accepting changes within one’s own job or organization.','','','','2019-12-15 01:17:38',1,'2019-12-15 01:17:38',1),(19,'Holding People Accountable ','Holding People Accountable involves setting high standards of performance and holding team members, other government jurisdictions, outside contractors, industry agencies, etc., accountable for results and actions.','','','','2019-12-15 01:18:22',1,'2019-12-15 01:18:22',1),(20,'Impact and Influence ','Impact and Influence is the ability to influence, persuade, or convince others to adopt a specific course of action.  It involves the use of persuasive techniques, presentations or negotiation skills to achieve desired results.','','','','2019-12-15 01:19:01',1,'2019-12-15 01:19:01',1),(21,'Improving Operations ','Improving Operations is the ability and motivation to apply one\'s knowledge and past experience for improving upon current modes of operation within the Ministry. This behaviour ranges from adapting widely used approaches to developing entirely new value-added solutions.','','','','2019-12-15 01:19:52',1,'2019-12-15 01:19:52',1);
/*!40000 ALTER TABLE `competencies` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `competencies_pathways`
--

LOCK TABLES `competencies_pathways` WRITE;
/*!40000 ALTER TABLE `competencies_pathways` DISABLE KEYS */;
INSERT INTO `competencies_pathways` VALUES (1,1),(2,1),(4,1),(16,1),(12,2),(14,2),(18,2),(20,2),(21,2),(1,3),(3,3),(12,3),(2,4),(7,4),(11,4),(16,4);
/*!40000 ALTER TABLE `competencies_pathways` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `competencies_users`
--

LOCK TABLES `competencies_users` WRITE;
/*!40000 ALTER TABLE `competencies_users` DISABLE KEYS */;
INSERT INTO `competencies_users` VALUES (1,3,NULL),(4,3,NULL),(10,3,NULL);
/*!40000 ALTER TABLE `competencies_users` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `pathways`
--

LOCK TABLES `pathways` WRITE;
/*!40000 ALTER TABLE `pathways` DISABLE KEYS */;
INSERT INTO `pathways` VALUES (1,'Personal Development','','White cat sleeps on a black shirt rub face on everything tuxedo cats always looking dapper. ','Achieve humility & self-awareness. Receive and use feedback.','','',1,1,1,'2020-02-02 04:37:52',1,'2020-02-07 16:43:54',1),(2,'Functions of Government','','How to understand legislation and policy to be effective in your leadership role. How to make decisions in the matrix of policy and legislation. Who’s who in the zoo. Cabinet Operations and Treasury Board. Awareness of Government Initiatives.','Can explain what the relationship is between understanding your ministry’s core functions & leadership development.','','',0,1,1,'2020-02-02 23:40:10',1,'2020-02-09 19:13:12',1),(3,'Role Advancement','','The learning we’re shut out of because of our level (how do we get there from here? This is a barrier – can’t take supervisor essentials without being a supervisor, but we want supervisory experience… same with leadership presence, etc.). The New Kids on the Block. Interview Skills – competency clubs – helping flesh out the STAR – very helpful for this journey.','Identify 3 key contacts to reach out to for. Describe the benefits of mentoring and identify potential candidates to mentor you. Access resources about mentoring. Apply networking best practices and establish new contacts/relationships.','','',0,1,1,'2020-02-03 15:59:13',1,'2020-02-07 16:50:49',1),(4,'Leading Others','','Leading all Teams Effectively (including virtual teams); building/recruiting – connecting the New Kids on the Block; building capacity within teams.','Understanding the elements of an effective communications/coaching approach that addresses… (include the three types here). Have career conversations with your direct reports.','','',0,1,1,'2020-02-03 16:01:30',1,'2020-02-14 21:32:54',1);
/*!40000 ALTER TABLE `pathways` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `pathways_steps`
--

LOCK TABLES `pathways_steps` WRITE;
/*!40000 ALTER TABLE `pathways_steps` DISABLE KEYS */;
INSERT INTO `pathways_steps` VALUES (2,1,NULL,NULL),(3,1,NULL,NULL),(5,2,NULL,NULL),(7,2,NULL,NULL),(8,3,NULL,NULL),(9,4,NULL,NULL),(10,1,NULL,NULL),(11,4,NULL,NULL);
/*!40000 ALTER TABLE `pathways_steps` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `pathways_users`
--

LOCK TABLES `pathways_users` WRITE;
/*!40000 ALTER TABLE `pathways_users` DISABLE KEYS */;
INSERT INTO `pathways_users` VALUES (1,1,1,NULL,NULL),(1,4,1,NULL,NULL),(4,1,1,NULL,NULL),(5,1,1,NULL,NULL),(5,2,1,NULL,NULL),(6,1,1,NULL,NULL);
/*!40000 ALTER TABLE `pathways_users` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `steps`
--

LOCK TABLES `steps` WRITE;
/*!40000 ALTER TABLE `steps` DISABLE KEYS */;
INSERT INTO `steps` VALUES (2,'Step 1','Puppy kitty ipsum dolor sit good dog foot stick canary. Teeth Mittens grooming vaccine walk swimming nest good boy furry tongue heel. ','',0,'2020-02-02 06:04:25',1,'2020-03-01 03:23:30',1),(3,'Step 2','Yawn litter fish yawn toy pet gate throw Buddy kitty wag tail ball.','',0,'2020-02-02 06:27:48',1,'2020-02-18 21:36:23',1),(4,'Step 3','Hairball run catnip eat the grass sniff or shove bum in owner\'s face like camera lens.','',0,'2020-02-02 23:27:22',1,'2020-02-02 23:27:48',1),(5,'Step 1','','',0,'2020-02-02 23:40:46',1,'2020-03-01 02:59:18',1),(7,'Step 2','','',0,'2020-02-03 03:12:58',1,'2020-02-03 03:13:21',1),(8,'Step 1','','',0,'2020-02-04 18:20:17',1,'2020-02-04 18:21:33',1),(9,'Step 1','','',0,'2020-02-06 00:50:01',1,'2020-02-14 21:33:08',1),(10,'Step 3','Cage run fast kitten dinnertime ball run foot park fleas throw house train licks stick dinnertime window.','',0,'2020-02-06 16:22:57',1,'2020-02-16 03:28:58',1),(11,'Step 2','','',0,'2020-02-12 06:43:00',1,'2020-02-14 21:36:04',1);
/*!40000 ALTER TABLE `steps` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `users` VALUES (1,'Allan','ahaggett',1,5,'','allan.haggett@gov.bc.ca','$2y$10$72lxcQm.SiM.dnvK3Ldv4.A9RtIThDwlVnO1slyH./WfW/damMWVC'),(3,'Richard','rilane',1,1,'','richard.lane@gov.bc.ca','$2y$10$nbRaNDAtcQs/tmxgnIi/SOMZ1HIa4YWmKWdarIf6cSguTLU.LEdoy'),(4,'Tamara','tlveil',1,2,'','tamara.leonard.veil@gov.bc.ca','$2y$10$fjK1w1iw9RoULEr26LPugOPIDAtS1by5wUubhUbAO1.uRWN6p4dLe'),(5,'Shannon','shmitch',1,1,'','shannon.mitchell@gov.bc.ca','$2y$10$1ObV6PDhT/FMdp9C1HTIuujhwCLqiaJSxrUICCQVt/PE5E1O4Xl1e'),(6,'Jesus','jejones',1,1,'','jesus.jones@gov.bc.ca','$2y$10$72dnvZ8VjgGwL12Rk/8Uo.1cpP6qXbERg7fZsX7jGyHyj/aZoSgna');
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

-- Dump completed on 2020-03-02 21:18:41
