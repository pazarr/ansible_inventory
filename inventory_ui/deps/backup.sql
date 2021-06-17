-- MySQL dump 10.14  Distrib 5.5.56-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ans_inv
-- ------------------------------------------------------
-- Server version	5.5.56-MariaDB

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
-- Table structure for table `aws_resources`
--

DROP TABLE IF EXISTS `aws_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aws_resources` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `resource_id` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_resources`
--

LOCK TABLES `aws_resources` WRITE;
/*!40000 ALTER TABLE `aws_resources` DISABLE KEYS */;
INSERT INTO `aws_resources` VALUES (1,'euw2-dev-infrastructure','aws_vpc','vpc-00973cb5cfc7ea328'),(2,'euw2-prod-infrastructure','aws_vpc','vpc-059aa5014941434df');
/*!40000 ALTER TABLE `aws_resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupvars`
--

DROP TABLE IF EXISTS `groupvars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupvars` (
  `group_id` smallint(5) unsigned NOT NULL,
  `group_var` varchar(24) DEFAULT NULL,
  `value` varchar(64) DEFAULT NULL,
  KEY `group_id` (`group_id`),
  CONSTRAINT `groupvars_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `hostgroups` (`group_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupvars`
--

LOCK TABLES `groupvars` WRITE;
/*!40000 ALTER TABLE `groupvars` DISABLE KEYS */;
INSERT INTO `groupvars` VALUES (58,'key_name','cicd-automation'),(58,'main_sg_id','sg-0ac36d1278bdda8a8'),(58,'vpc_subnet','subnet-09f256f5ebfd5c109'),(58,'ami_id','ami-08ddfd269f3291e07'),(58,'vol_type','gp2'),(58,'vol_size','20'),(58,'regal_runtime_env','DEV'),(58,'instance_type','t3.xlarge'),(58,'postgres_version','10'),(58,'postgres_port','10810'),(58,'regal_domain','RGL-UK'),(58,'regal_env','dev'),(58,'regal_cluster_id','DEV'),(58,'cassandra_cluster_name','regal_prod'),(58,'asset_url_domain','realistic-dev.com'),(58,'regal_server_type','DEV'),(58,'regal_cluster_id','DEV'),(58,'regal_db_user','regal_rw'),(58,'regal_db_pass','regal_rw'),(58,'regal_db_ro_user','regal_ro'),(58,'regal_db_ro_pass','regal_ro'),(58,'regal_farm_id','D'),(58,'regal_env_id','0'),(58,'coherence_multicast_addr','239.219.219.229'),(58,'coherence_multicast_port','12346'),(58,'games_multicast_address','239.119.119.190'),(58,'bo_multicast_address','239.119.119.110'),(58,'regal_db_host','localhost'),(58,'regal_db_port','10810'),(58,'regal_db_name','regal'),(58,'regal_jboss_version','5.2-nomulticast'),(58,'cassandra_server','localhost'),(58,'deployment_bo_url','devbo.realistic-dev.com'),(58,'deployment_lobby_url','devlobby1.realistic-dev.com'),(58,'domain_name','aws.rgli.uk'),(60,'key_name','cicd-automation'),(60,'main_sg_id','sg-4a941121'),(60,'vpc_subnet','subnet-e7226baa'),(60,'ami_id','ami-060a8a43e3657c526'),(60,'vol_type','gp2'),(60,'vol_size','20'),(60,'regal_runtime_env','DEV'),(60,'instance_type','t2.large'),(60,'postgres_version','10'),(60,'postgres_port','10810'),(60,'regal_domain','RGL-UK'),(60,'regal_env','dev'),(60,'regal_cluster_id','DEV'),(60,'cassandra_cluster_name','regal_prod'),(60,'asset_url_domain','realisticgames.co.uk'),(60,'regal_server_type','DEV'),(60,'regal_cluster_id','DEV'),(60,'regal_db_user','regal_rw'),(60,'regal_db_pass','regal_rw'),(60,'regal_db_ro_user','regal_ro'),(60,'regal_db_ro_pass','regal_ro'),(60,'regal_farm_id','D'),(60,'regal_env_id','0'),(60,'coherence_multicast_addr','239.219.219.229'),(60,'coherence_multicast_port','12346'),(60,'games_multicast_address','239.119.119.190'),(60,'bo_multicast_address','239.119.119.110'),(60,'regal_db_host','localhost'),(60,'regal_db_port','10810'),(60,'regal_db_name','regal'),(60,'regal_jboss_version','5.2-nomulticast'),(60,'cassandra_server','localhost'),(60,'domain_name','aws.rgli.uk'),(58,'sample_data','cicd_data'),(61,'regal_runtime_env','PROD'),(61,'domain_name','aws.rgli.uk'),(58,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(58,'regal_version_folder','2.6.2'),(64,'testvar','testvarvalue123'),(66,'security_group','euw1-production-jboss_sg'),(69,'security_group','euw1-production-dbs_sg'),(66,'instance_type','t3.xlarge'),(66,'vol_size','50'),(66,'ami_id','ami-0f8c8de06f27813a7'),(70,'instance_type','r5.2xlarge'),(70,'vol_size','50'),(70,'ami_id','ami-0f8c8de06f27813a7'),(69,'vol_size','50'),(69,'ami_id','ami-0f8c8de06f27813a7'),(69,'instance_type','r5.2xlarge'),(71,'instance_type','t3.micro'),(71,'vol_size','10'),(71,'security_group','euw1-production-cas_sg'),(71,'ami_id','ami-0f8c8de06f27813a7'),(72,'security_group','euw1-production-cas_sg'),(72,'instance_type','t3.medium'),(72,'vol_size','10'),(72,'ami_id','ami-0f8c8de06f27813a7'),(67,'security_group','euw1-production-och_sg'),(67,'instance_type','t2.large'),(67,'vol_size','50'),(67,'ami_id','ami-0f8c8de06f27813a7'),(68,'security_group','euw1-production-dmz_sg'),(68,'vol_size','50'),(68,'instance_type','t3.small'),(68,'ami_id','ami-0f8c8de06f27813a7'),(70,'security_group','euw1-production-cas_sg'),(66,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(66,'regal_version','2.8.0'),(69,'postgres_version','10'),(69,'postgres_port','10810'),(69,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(70,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(70,'cassandra_dc','euw1'),(70,'jmx_user','cassandra'),(70,'jmx_password','cassandra'),(67,'regal_version','2.8.0'),(67,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(66,'regal_jboss_version','5.2.2'),(68,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(74,'dns_domain','rgli.eu'),(66,'regal_server_type','JBS'),(67,'regal_server_type','OCH'),(76,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(76,'environment-tag','euw2-prod-infrastructure'),(76,'ami_id','ami-0fead72ede408484b'),(76,'domain_name','aws.rgli.uk'),(77,'domain_name','aws.rgli.uk'),(77,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(77,'runtime_environment','dev'),(58,'install_frig','true'),(76,'runtime_environment','prod'),(79,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(79,'environment_tag','euw2-dev-infrastructure'),(79,'domain_name','aws.rgli.uk'),(79,'runtime_environment','dev'),(80,'regal_server_type','JBS'),(82,'regal_server_type','OCH'),(80,'jboss_version','5.2.2'),(82,'jboss_version','5.2.2'),(82,'och_node_num','3'),(88,'security_group','euw1-production-jboss_sg'),(88,'instance_type','t3.xlarge'),(88,'vol_size','50'),(88,'ami_id','ami-0f8c8de06f27813a7'),(88,'activationkey','1-centos7-q219'),(88,'regal_version','2.9.1'),(88,'regal_server_type','JBS'),(89,'security_group','euw1-production-och_sg'),(89,'instance_type','t3.xlarge'),(89,'vol_size','50'),(89,'ami_id','ami-0f8c8de06f27813a7'),(89,'regal_version','2.8.0'),(89,'activationkey','1-centos7-q219'),(89,'regal_server_type','OCH'),(90,'activationkey','1-centos7-q219'),(90,'postgres_port','5555'),(90,'postgres_version','11'),(91,'activationkey','1-centos7-q219'),(92,'activationkey','1-centos7-q219'),(89,'regal_farm_id','C'),(88,'jboss_version','5.2.2'),(88,'regal_farm_id','A'),(91,'first_cassandranode_addr','10.223.220.61'),(91,'regal_server_type','CAS'),(80,'pandora_env','uat'),(80,'pandora_drone_version','1.1.0'),(80,'pandora_namespace','production'),(80,'regal_farm_id','A'),(80,'regal_version','2.9.1'),(93,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(93,'domain_name','aws.rgli.uk'),(93,'runtime_environment','dev'),(94,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(94,'domain_name','aws.rgli.uk'),(94,'runtime_environment','dev'),(80,'pandora_lb_url','http://10.204.30.69:5050'),(95,'activationkey','1-centos7-q219'),(95,'domain_name','aws.rgli.uk'),(95,'runtime_environment','uat'),(58,'progressive_url','euw2-dev-progressives.realistic-dev.com/progressives');
/*!40000 ALTER TABLE `groupvars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostgroups`
--

DROP TABLE IF EXISTS `hostgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostgroups` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostgroups`
--

LOCK TABLES `hostgroups` WRITE;
/*!40000 ALTER TABLE `hostgroups` DISABLE KEYS */;
INSERT INTO `hostgroups` VALUES (58,'cicd-automation','CI/CD automation'),(60,'serverteam-dev','serverteam dev hosts'),(61,'prod-infr','Platform production host'),(64,'jenkins-builds','All jenkins machine'),(66,'euw1-production-jboss','All host eu-west-2 jboss'),(67,'euw1-production-och','Coherence hosts'),(68,'euw1-production-lbm','LoadBalancers'),(69,'euw1-production-dbs','Database hosts'),(70,'euw1-production-cas','Cassandra hosts'),(71,'euw1-production-dns','DNS servers'),(72,'euw1-production-auth','FreeIPA servers'),(74,'euw1-production-mgmt','Management hosts'),(75,'euw1-production-dwh','Data ware house hosts'),(76,'euw2-prod-infrastructure','EUW2 Infrastructure hosts'),(77,'euw2-dev-noc','NOC team development machines'),(79,'euw2-dev-infrastructure','All develop infrastructure'),(80,'euw2-uat-jboss','UAT jboss'),(81,'euw2-uat-cas','UAT Cassandras'),(82,'euw2-uat-och','UAT Coherence '),(83,'euw2-uat-dbs','UAT DB server'),(84,'euw2-uat-lbm','UAT LB servers'),(88,'euw1-prd-globdc-jboss','Late Gib jbs nodes'),(89,'euw1-prd-globdc-och','Late Gib coherence nodes'),(90,'euw1-prd-globdc-dbs','Database servers for globdc'),(91,'euw1-prd-globdc-cas','Cassandra nodes in globDC'),(92,'euw1-prd-globdc-lbm','LoadBalancers for GlobDC'),(93,'euw2-dev-progressive','New progressive servers '),(94,'euw2-dev-dbs','Dev database serves'),(95,'euw2-uat-progressive','Progressive servers and services'),(97,'rdg-win-dc','Office domain controllers');
/*!40000 ALTER TABLE `hostgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts`
--

DROP TABLE IF EXISTS `hosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts` (
  `host_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`host_id`)
) ENGINE=InnoDB AUTO_INCREMENT=571 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts`
--

LOCK TABLES `hosts` WRITE;
/*!40000 ALTER TABLE `hosts` DISABLE KEYS */;
INSERT INTO `hosts` VALUES (3,'peter-dev1'),(327,'rgl-aws-ansible'),(329,'localhost'),(365,'gvs-test-qa'),(366,'gvs-test-uat'),(371,'spacewalk'),(451,'metrics-server1'),(453,'prometheus01'),(457,'auth01'),(458,'auth02'),(472,'euw1-prd-cas02'),(473,'euw1-prd-cas01'),(474,'euw1-prd-cas03'),(475,'euw1-prd-dbs01'),(476,'euw1-prd-dbs02'),(477,'euw1-prd-dns02'),(478,'euw1-prd-dns01'),(479,'euw1-prd-jbs01'),(480,'euw1-prd-jbs02'),(481,'euw1-prd-jbs03'),(482,'euw1-prd-lbm01'),(483,'euw1-prd-lbm02'),(485,'euw1-prd-och01'),(486,'euw1-prd-och02'),(487,'euw1-prd-och03'),(489,'euw1-prd-ansible'),(490,'euw1-prd-nagios01'),(492,'qa-jenkins-master'),(493,'euw1-dev-jbs01-release-test'),(494,'st-jenkins-master'),(498,'euw1-prd-dwh01'),(499,'nektanboapi'),(510,'euw2-prod-nagios01'),(516,'euw2-prod-test1'),(517,'euw2-dev-changereport01'),(526,'euw2-prod-rev-proxy01'),(527,'euw2-prod-rev-proxy02'),(528,'euw2-dev-rev-proxy02'),(529,'euw2-dev-rev-proxy01'),(530,'euw2-dev-elk01'),(531,'reference'),(532,'euw2-prod-cicd-jenkins'),(533,'euw2-uat-jbs01'),(534,'euw2-uat-jbs02'),(535,'euw2-uat-cas01'),(536,'euw2-uat-cas02'),(537,'euw2-uat-och01'),(538,'euw2-uat-och02'),(539,'euw2-uat-lbm01'),(540,'euw2-uat-lbm02'),(541,'hermesrefactor'),(542,'euw2-uat-dbs01'),(543,'unnameable'),(544,'closedsession'),(545,'gamelaunch'),(546,'euw1-prd-globdc-jbs01'),(547,'euw1-prd-globdc-jbs02'),(548,'euw1-prd-globdc-jbs03'),(549,'euw1-prd-globdc-dbs01'),(550,'euw1-prd-globdc-dbs02'),(551,'euw1-prd-globdc-och01'),(552,'euw1-prd-globdc-och02'),(553,'euw1-prd-globdc-och03'),(554,'euw1-prd-globdc-cas01'),(555,'euw1-prd-globdc-cas02'),(556,'euw1-prd-globdc-cas03'),(557,'euw1-prd-globdc-lbm01'),(558,'euw1-prd-globdc-lbm02'),(559,'euw2-dev-regalrelease01'),(560,'euw2-dev-owl01'),(561,'euw2-prod-gvs01'),(562,'euw2-dev-progressive01'),(563,'euw2-dev-progressive02'),(564,'euw2-dev-dbs01'),(565,'user'),(566,'cicd-demo1'),(567,'euw2-dev-integration01'),(568,'euw2-uat-progressive01'),(569,'euw2-uat-progressive02'),(570,'dc01.realistic.local');
/*!40000 ALTER TABLE `hosts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostvars`
--

DROP TABLE IF EXISTS `hostvars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostvars` (
  `host_id` int(10) unsigned NOT NULL,
  `host_var` text NOT NULL,
  `value` text NOT NULL,
  KEY `host_id` (`host_id`),
  CONSTRAINT `hostvars_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `hosts` (`host_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostvars`
--

LOCK TABLES `hostvars` WRITE;
/*!40000 ALTER TABLE `hostvars` DISABLE KEYS */;
INSERT INTO `hostvars` VALUES (3,'ansible_host','10.200.10.47'),(327,'ansible_host','10.200.10.21'),(365,'instance_id','i-0bd814070ba1f68bc'),(365,'ansible_host','10.200.10.22'),(365,'vpc_region','eu-west-2'),(365,'inst_type','t2.large'),(365,'inst_status','2018-11-12T14:00:24.000Z'),(365,'avail_zone','eu-west-2b'),(365,'inst_usage','DEV'),(366,'instance_id','i-098771053d3304647'),(366,'ansible_host','10.200.10.175'),(366,'vpc_region','eu-west-2'),(366,'inst_type','t2.large'),(366,'inst_status','2018-11-12T14:08:13.000Z'),(366,'avail_zone','eu-west-2b'),(366,'inst_usage','DEV'),(371,'ansible_host','10.200.10.139'),(371,'regal_runtime_env','PROD'),(451,'domain_name','aws.rgli.uk'),(451,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(451,'regal_runtime_env','PROD'),(451,'ansible_host','10.200.1.194'),(453,'domain_name','aws.rgli.uk'),(453,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(453,'regal_runtime_env','PROD'),(453,'ansible_host','10.200.10.250'),(489,'ansible_host','localhost'),(479,'subnet_id','subnet-0a397a53531357a12'),(480,'subnet_id','subnet-0597733fc03be948c'),(481,'subnet_id','subnet-05d2b25b22a956b71'),(479,'ansible_host','10.223.200.10'),(480,'ansible_host','10.223.200.110'),(481,'ansible_host','10.223.200.160'),(473,'subnet_id','subnet-0a397a53531357a12'),(473,'ansible_host','10.223.200.40'),(472,'subnet_id','subnet-0597733fc03be948c'),(474,'subnet_id','subnet-05d2b25b22a956b71'),(472,'ansible_host','10.223.200.95'),(474,'ansible_host','10.223.200.150'),(475,'ansible_host','10.223.200.30'),(476,'ansible_host','10.223.200.85'),(475,'subnet_id','subnet-0a397a53531357a12'),(476,'subnet_id','subnet-0597733fc03be948c'),(478,'subnet_id','subnet-03904e30aaa18d2fb'),(478,'ansible_host','10.223.201.5'),(477,'subnet_id','subnet-06b3663a739dab9bb'),(477,'ansible_host','10.223.201.69'),(457,'ansible_host','10.223.201.4'),(458,'ansible_host','10.223.201.68'),(457,'subnet_id','subnet-03904e30aaa18d2fb'),(458,'subnet_id','subnet-06b3663a739dab9bb'),(485,'ansible_host','10.223.200.20'),(486,'ansible_host','10.223.200.75'),(487,'ansible_host','10.223.200.140'),(485,'subnet_id','subnet-0a397a53531357a12'),(486,'subnet_id','subnet-0597733fc03be948c'),(487,'subnet_id','subnet-05d2b25b22a956b71'),(482,'subnet_id','subnet-0dc7549ab32d8e278'),(482,'ansible_host','10.223.76.15'),(483,'subnet_id','subnet-0ba5390b8cb111dff'),(483,'ansible_host','10.223.76.75'),(490,'ansible_host','10.223.201.9'),(490,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(492,'ansible_host','10.203.100.93'),(492,'domain_name','aws.rgli.uk'),(492,'regal_runtime_env','PROD'),(492,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(493,'ansible_host','10.223.200.11'),(494,'ansible_host','10.203.100.171'),(494,'domain_name','aws.rgli.uk'),(494,'regal_runtime_env','PROD'),(494,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(494,'dns_domain','aws.rgli.uk'),(498,'ansible_host','10.223.200.162'),(499,'instance_id','i-0a880624b94882304'),(499,'ansible_host','10.203.20.42'),(499,'vpc_region','eu-west-2'),(499,'inst_type','t3.xlarge'),(499,'inst_status','2019-04-02T09:48:51.000Z'),(499,'avail_zone','eu-west-2b'),(499,'inst_usage','DEV'),(499,'regal_installed','true'),(510,'ansible_host','10.202.30.150'),(510,'main_sg_id','sg-0cffd194f712325a9'),(510,'vpc_subnet','subnet-0cddda9c173866113'),(510,'intance_type','t3.small'),(510,'vol_type','gp2'),(510,'vol_size','15'),(516,'instance_id','i-07fcd658fc623c096'),(516,'ansible_host','10.202.30.59'),(516,'vpc_region','eu-west-2'),(516,'inst_type','t3.small'),(516,'inst_status','2019-03-27T17:00:48.000Z'),(516,'avail_zone','eu-west-2c'),(516,'inst_usage','DEV'),(516,'regal_installed','false'),(517,'ansible_host','10.203.30.21'),(526,'ansible_host','10.202.100.173'),(527,'ansible_host','10.202.200.127'),(529,'ansible_host','10.203.100.94'),(528,'ansible_host','10.203.200.238'),(530,'ansible_host','10.203.50.128'),(531,'instance_id','i-0dbce5b2ef4e6078a'),(531,'ansible_host','10.203.20.201'),(531,'vpc_region','eu-west-2'),(531,'inst_type','t3.xlarge'),(531,'inst_status','2019-04-05T14:40:40.000Z'),(531,'avail_zone','eu-west-2b'),(531,'inst_usage','DEV'),(531,'regal_installed','true'),(532,'ansible_host','10.202.30.44'),(540,'ansible_host','10.204.200.29'),(533,'ansible_host','10.204.10.245'),(534,'ansible_host','10.204.20.17'),(535,'ansible_host','10.204.10.120'),(536,'ansible_host','10.204.20.101'),(537,'ansible_host','10.204.10.52'),(538,'ansible_host','10.204.20.203'),(539,'ansible_host','10.204.100.234'),(541,'instance_id','i-0d692416614bc1cc7'),(541,'ansible_host','10.203.20.222'),(541,'vpc_region','eu-west-2'),(541,'inst_type','t3.xlarge'),(541,'inst_status','2019-04-09T12:40:21.000Z'),(541,'avail_zone','eu-west-2b'),(541,'inst_usage','DEV'),(541,'regal_installed','true'),(542,'ansible_host','10.204.30.147'),(543,'instance_id','i-06c4d72a878b3c683'),(543,'ansible_host','10.203.20.113'),(543,'vpc_region','eu-west-2'),(543,'inst_type','t3.xlarge'),(543,'inst_status','2019-04-10T17:52:29.000Z'),(543,'avail_zone','eu-west-2b'),(543,'inst_usage','DEV'),(543,'regal_installed','true'),(544,'instance_id','i-0ab963865e71d00e4'),(544,'ansible_host','10.203.20.124'),(544,'vpc_region','eu-west-2'),(544,'inst_type','t3.xlarge'),(544,'inst_status','2019-04-12T08:42:59.000Z'),(544,'avail_zone','eu-west-2b'),(544,'inst_usage','DEV'),(544,'regal_installed','true'),(545,'instance_id','i-02adb2bb3f6c2120b'),(545,'ansible_host','10.203.20.248'),(545,'vpc_region','eu-west-2'),(545,'inst_type','t3.xlarge'),(545,'inst_status','2019-04-23T10:59:41.000Z'),(545,'avail_zone','eu-west-2b'),(545,'inst_usage','DEV'),(545,'regal_installed','true'),(546,'ansible_host','10.223.220.35'),(547,'ansible_host','10.223.220.85'),(548,'ansible_host','10.223.220.132'),(549,'ansible_host','10.223.220.91'),(550,'ansible_host','10.223.220.177'),(551,'ansible_host','10.223.220.7'),(552,'ansible_host','10.223.220.107'),(553,'ansible_host','10.223.220.165'),(554,'ansible_host','10.223.220.61'),(555,'ansible_host','10.223.220.69'),(556,'ansible_host','10.223.220.142'),(557,'ansible_host','10.223.176.47'),(558,'ansible_host','10.223.176.80'),(559,'instance_id','i-04a6570b4437e534b'),(559,'ansible_host','10.203.20.138'),(559,'vpc_region','eu-west-2'),(559,'inst_type','t3.xlarge'),(559,'inst_status','2019-04-29T13:21:54.000Z'),(559,'avail_zone','eu-west-2b'),(559,'inst_usage','DEV'),(559,'regal_installed','true'),(560,'instance_id','i-0f781cb3655884886'),(560,'ansible_host','10.203.30.175'),(560,'vpc_region','eu-west-2'),(560,'inst_type','t3.xlarge'),(560,'inst_status','2019-04-29T14:28:15.000Z'),(560,'avail_zone','eu-west-2c'),(560,'inst_usage','DEV'),(560,'regal_installed','true'),(561,'ansible_host','10.202.60.127'),(561,'nagios_ip','10.202.30.150'),(561,'postgres_version','11'),(561,'postgres_port','5432'),(562,'ansible_host','10.203.30.195'),(563,'ansible_host','10.203.20.101'),(564,'ansible_host','10.203.20.77'),(565,'instance_id','i-0b110c7a077536fee'),(565,'ansible_host','10.203.20.99'),(565,'vpc_region','eu-west-2'),(565,'inst_type','t3.xlarge'),(565,'inst_status','2019-05-17T11:29:03.000Z'),(565,'avail_zone','eu-west-2b'),(565,'inst_usage','DEV'),(565,'regal_installed','true'),(566,'ansible_host','10.203.20.100'),(566,'regal_installed','true'),(566,'inst_usage','DEV'),(566,'instance_id','i-068bc3cb0dc247af9'),(567,'ansible_host','10.203.20.150'),(567,'instance_id','i-0f3ccebf29b5e2518'),(567,'vpc_region','eu-west-2'),(567,'inst_type','t3.xlarge'),(567,'avail_zone','eu-west-2b'),(567,'inst_usage','DEV'),(567,'inst_status','2019-05-28T15:18:50.000Z'),(567,'regal_installed','true'),(567,'gn_alias','integration.realistic-dev.com,nektan.realistic-dev.com,skillonnet.realistic-dev.com,sunbingo.realistic-dev.com,kindred.realistic-dev.com,betconstruct.realistic-dev.com,isoftbet.realistic-dev.com,oryx.realistic-dev.com,nyx.realistic-dev.com,fsb.realistic-dev.com,playtech.realistic-dev.com,bet365.realistic-dev.com,bede.realistic-dev.com,betfred.realistic-dev.com,boylesports.realistic-dev.com,everymatrix.realistic-dev.com,daub.realistic-dev.com,gvc.realistic-dev.com,gr.realistic-dev.com,iforium.realistic-dev.com,optima.realistic-dev.com,rank.realistic-dev.com,vc.realistic-dev.com,vf.realistic-dev.com,rgi.realistic-dev.com,888.realistic-dev.com,solidgames.realisticgames.co.uk,solid.realistic-dev.com,realisticapi.realistic-dev.com'),(559,'gn_alias','release2.realistic-dev.com,sunbingo-release.realistic-dev.com,kindred-release.realistic-dev.com,betconstruct-release.realistic-dev.com,isoftbet-release.realistic-dev.com,oryx-release.realistic-dev.com,nyx-release.realistic-dev.com,fsb-release.realistic-dev.com,skillonnet-release.realistic-dev.com,playtech-release.realistic-dev.com,bet365-release.realistic-dev.com,bede-release.realistic-dev.com,betfred-release.realistic-dev.com,boylesports-release.realistic-dev.com,everymatrix-release.realistic-dev.com,daub-release.realistic-dev.com,gvc-release.realistic-dev.com,gr-release.realistic-dev.com,nektan-release.realistic-dev.com,optima-release.realistic-dev.com,rank-release.realistic-dev.com,vc-release.realistic-dev.com,vf-release.realistic-dev.com,888-release.realistic-dev.com,regalrelease.realistic-dev.com'),(568,'ansible_host','10.204.10.49'),(569,'ansible_host','10.204.20.35'),(559,'bo_alias','bo-regalrelease.realistic-dev.com'),(570,'ansible_host','10.12.10.4'),(570,'ansible_user','backup@REALISTIC.LOCAL'),(570,'ansible_connection','winrm'),(570,'ansible_port','5986'),(570,'ansible_winrm_transport','kerberos'),(570,'ansible_winrm_server_cert_validation','ignore'),(570,'ansible_pass','StationPlace01$$');
/*!40000 ALTER TABLE `hostvars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memberships`
--

DROP TABLE IF EXISTS `memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memberships` (
  `group_id` smallint(5) unsigned NOT NULL,
  `host_id` int(10) unsigned NOT NULL,
  KEY `group_id` (`group_id`),
  KEY `host_id` (`host_id`),
  CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `hostgroups` (`group_id`) ON DELETE CASCADE,
  CONSTRAINT `memberships_ibfk_2` FOREIGN KEY (`host_id`) REFERENCES `hosts` (`host_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memberships`
--

LOCK TABLES `memberships` WRITE;
/*!40000 ALTER TABLE `memberships` DISABLE KEYS */;
INSERT INTO `memberships` VALUES (60,365),(60,366),(58,329),(61,371),(61,451),(61,453),(72,457),(72,458),(68,482),(68,483),(67,485),(67,486),(67,487),(71,477),(71,478),(69,475),(69,476),(70,472),(70,473),(70,474),(74,490),(61,492),(66,479),(66,480),(66,481),(66,493),(61,494),(75,498),(58,499),(76,510),(76,516),(76,526),(76,527),(79,528),(79,529),(79,530),(58,531),(76,532),(80,533),(80,534),(81,535),(81,536),(82,537),(82,538),(84,539),(84,540),(58,541),(83,542),(58,543),(58,544),(58,545),(88,546),(88,547),(88,548),(90,549),(90,550),(89,551),(89,552),(89,553),(91,554),(91,555),(91,556),(92,557),(92,558),(58,559),(58,560),(76,561),(93,562),(93,563),(77,517),(94,564),(58,565),(58,566),(58,567),(95,568),(95,569),(97,570);
/*!40000 ALTER TABLE `memberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_child`
--

DROP TABLE IF EXISTS `parent_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_child` (
  `parent_id` smallint(5) unsigned NOT NULL,
  `group_id` smallint(5) unsigned NOT NULL,
  KEY `parent_id` (`parent_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `parent_child_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parentgroups` (`parent_id`) ON DELETE CASCADE,
  CONSTRAINT `parent_child_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `hostgroups` (`group_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_child`
--

LOCK TABLES `parent_child` WRITE;
/*!40000 ALTER TABLE `parent_child` DISABLE KEYS */;
INSERT INTO `parent_child` VALUES (5,58),(5,60),(5,61),(5,64),(7,66),(7,67),(7,68),(7,69),(7,70),(9,76),(10,77),(10,79),(12,88),(12,89),(12,90),(12,91),(12,92),(11,80),(11,81),(11,82),(11,83),(11,84),(11,95);
/*!40000 ALTER TABLE `parent_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parentgroups`
--

DROP TABLE IF EXISTS `parentgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parentgroups` (
  `parent_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parentgroups`
--

LOCK TABLES `parentgroups` WRITE;
/*!40000 ALTER TABLE `parentgroups` DISABLE KEYS */;
INSERT INTO `parentgroups` VALUES (5,'rgl-aws-infr','VPC in eu-west-2'),(7,'euw1-production','EU-WEST-1 rgl production'),(9,'euw2-production','EU-West-2 Produc VPC'),(10,'euw2-dev','DEvelopment environment'),(11,'euw2-uat','UAT environment'),(12,'euw1-globdc','Global DC in Ireland(late Gib)'),(13,'euw2-dev','All development host'),(15,'rdg-win','Office windows servers');
/*!40000 ALTER TABLE `parentgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parentvars`
--

DROP TABLE IF EXISTS `parentvars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parentvars` (
  `parent_id` smallint(5) unsigned NOT NULL,
  `parent_var` varchar(24) DEFAULT NULL,
  `value` varchar(64) DEFAULT NULL,
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `parentvars_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parentgroups` (`parent_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parentvars`
--

LOCK TABLES `parentvars` WRITE;
/*!40000 ALTER TABLE `parentvars` DISABLE KEYS */;
INSERT INTO `parentvars` VALUES (5,'aws_region','eu-west-2'),(7,'rgl_env','prod'),(7,'vpc_name','euw1-production'),(7,'aws_region','eu-west-1'),(7,'aws_cidr_block','10.223.0.0/16'),(7,'dns01','10.223.201.4'),(7,'dns02','10.223.201.68'),(7,'ntp01','10.223.201.4'),(7,'ntp02','10.223.201.68'),(7,'dns_domain','rgli.eu'),(7,'dmz_subnet_a_cidr','10.223.76.0/26'),(7,'dmz_subnet_b_cidr','10.223.76.64/26'),(7,'dmz_subnet_c_cidr','10.223.76.128/26'),(7,'dmz_network_cidr','10.223.76.0/24'),(7,'app_subnet_a_cidr','10.223.200.0/26'),(7,'app_subnet_b_cidr','10.223.200.64/26'),(7,'app_subnet_c_cidr','10.223.200.128/26'),(7,'app_network_cidr','10.223.200.0/24'),(7,'mgmt_subnet_a_cidr','10.223.201.0/26'),(7,'mgmt_subnet_b_cidr','10.223.201.64/26'),(7,'mgmt_subnet_c_cidr','10.223.201.128/26'),(7,'mgmt_network_cidr','10.223.201.0/24'),(7,'nat_gw_cidr','10.223.1.0/24'),(7,'gib_lan','192.168.119.0/24'),(7,'gb3_app_net','10.146.200.0/24'),(7,'support_subnet_cidr','10.12.17.0/24'),(7,'qa_subnet_cidr','10.12.16.0/24'),(7,'noc_subnet_cidr','10.12.12.0/24'),(7,'public_subnet_cidr','10.223.76.0/26'),(7,'aws_az_b','eu-west-1b'),(7,'aws_az_c','eu-west-1c'),(7,'vpn_name','euw1-rdg-vpn'),(7,'rgl_gateway_ip','62.252.145.62'),(7,'rgl_cgw_name','Reading Office VirginMedia'),(7,'gib_vpn_name','euw1-gib-vpn'),(7,'rgl_gateway_gib_ip','195.244.222.164'),(7,'gib_cgw_name','Gib DC fw'),(7,'gb3_vpn_name','euw1-gb3-vpn'),(7,'gb3_cgw_name','GB3 DC fw'),(7,'rgl_gateway_gb3_ip','206.142.225.198'),(7,'aws_az_a','eu-west-1a'),(7,'eip_address','63.33.182.107'),(7,'regal_db_port','10810'),(7,'regal_db_name','regal'),(7,'regal_db_user','regal_rw'),(7,'regal_db_pass','regal_rw'),(7,'regal_env','prod'),(7,'asset_url_domain','realisticgames.co.uk'),(7,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(7,'regal_runtime_env','PROD'),(7,'regal_domain','RGL-UK'),(7,'regal_cluster_id','PROD'),(7,'rgl_db_node','10.223.200.30'),(7,'rgl_db_port','5444'),(7,'rgl_db_name','regal_prod'),(7,'regal_farm_id','A'),(7,'rgl_db_host','10.223.200.30'),(7,'regal_env_id','\"5\"'),(7,'regal_id_generator','\"RUID\"'),(9,'region','eu-west-2'),(11,'activationkey','1-centos7-q219'),(12,'vpc_name','euw1-production'),(12,'aws_region','eu-west-1'),(12,'aws_cidr_block','10.223.0.0/16'),(12,'dns01','10.223.201.4'),(12,'dns02','10.223.201.68'),(12,'ntp01','10.223.201.4'),(12,'ntp02','10.223.201.68'),(12,'dns_domain','rgli.eu'),(12,'dmz_subnet_a_cidr','10.223.176.0/26'),(12,'dmz_subnet_b_cidr','10.223.176.64/26'),(12,'dmz_subnet_c_cidr','10.223.176.128/26'),(12,'dmz_network_cidr','10.223.176.0/24'),(12,'app_subnet_a_cidr','10.223.220.0/26'),(12,'app_subnet_b_cidr','10.223.220.64/26'),(12,'app_subnet_c_cidr','10.223.220.128/26'),(12,'app_network_cidr','10.223.220.0/24'),(12,'mgmt_subnet_a_cidr','10.223.201.0/26'),(12,'mgmt_subnet_b_cidr','10.223.201.64/26'),(12,'mgmt_subnet_c_cidr','10.223.201.128/26'),(12,'mgmt_network_cidr','10.223.201.0/24'),(12,'support_subnet_cidr','10.12.13.0/24'),(12,'qa_subnet_cidr','10.12.13.0/24'),(12,'noc_subnet_cidr','10.12.12.0/24'),(12,'public_subnet_cidr','10.223.176.0/26'),(12,'aws_az_b','eu-west-1b'),(12,'aws_az_c','eu-west-1c'),(12,'rgl_cgw_name','Reading Office VirginMedia'),(12,'aws_az_a','eu-west-1a'),(12,'eip_address','63.34.238.52'),(12,'regal_env','prod'),(12,'domain_name','rgli.net'),(12,'rgl_environment','globdc'),(12,'nagios_ip','10.223.201.9'),(11,'rgl_environment','uat');
/*!40000 ALTER TABLE `parentvars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pubkeys`
--

DROP TABLE IF EXISTS `pubkeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pubkeys` (
  `name` varchar(24) NOT NULL,
  `access_group` varchar(24) NOT NULL,
  `pubkey` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pubkeys`
--

LOCK TABLES `pubkeys` WRITE;
/*!40000 ALTER TABLE `pubkeys` DISABLE KEYS */;
INSERT INTO `pubkeys` VALUES ('pbihacsi','noc','ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD3qR98PY65t6yUfxqvJiZWTFbNQyUErse2Ia6FOwfp3yRCnT9w5SzrPkDFSp1rW8gGen9sSwpLPmZW0zw0oHOYq7t1+iRr68uSksLbWRdaCCAUxYUj8tZOrsIKHyca+oA3r3Bzoji4xsJ32ppfVXZweqisfY+iFGQVL5YRmlPAdHKssDhXlC+68mhmSvkSDyDHyvlbLg0Y8CgmZgjZAO3weh3Gud4ICeVfhpIOsgg8suZIqMPdUM02qfHZe6wp+lzMK/DH7bLyUVkqXO5FCFdHAcjlmfLXFHu7z2ly/Qb/NU27SeifkymN94msrkDV8VeMIlpitR3isqYBIDXSbw9H peter@pbvb-laptop'),('cicd-auto','automation','ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCrnkt9ohiCB80aGXch8vssRQanzpyIahRohiHaSpA4FftOPw/J7eD9r3hrQsOzaYVnSSuAP2Ilr07EST7mmg2rsea+puV4Wl2VtgAMp1G4SrJyth3KN4X1wxdihjBtiXhiisbAV7VCKCOBWF5Tb3lr8wr1Cwt6pvG5qrse2Pm2laIShhaXB5t0GzKmSYi93/ztj54lvZ1jk3lkMA/NK4ihK7tWgia0xWEQ5icOJ6xK6qdbQVZj7umUgSYoQZH2mfQFuKVCGlN8No/rx5Tao32MTdyq0ocZwZl/x25k0KHT1pysDBYbb11FBwZpD3hhAXfL9Xd5AlaqhSz89sSDxjo7 packer_5b63170b-703a-b0b8-4223-647a7f3fdb8d');
/*!40000 ALTER TABLE `pubkeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ui_vars`
--

DROP TABLE IF EXISTS `ui_vars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ui_vars` (
  `ui_var` varchar(64) NOT NULL,
  `value` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ui_vars`
--

LOCK TABLES `ui_vars` WRITE;
/*!40000 ALTER TABLE `ui_vars` DISABLE KEYS */;
/*!40000 ALTER TABLE `ui_vars` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-31  9:44:22
