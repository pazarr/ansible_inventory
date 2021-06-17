-- MariaDB dump 10.19  Distrib 10.4.18-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ans_inv
-- ------------------------------------------------------
-- Server version	10.4.18-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
  `value` text NOT NULL,
  KEY `group_id` (`group_id`),
  CONSTRAINT `groupvars_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `hostgroups` (`group_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupvars`
--

LOCK TABLES `groupvars` WRITE;
/*!40000 ALTER TABLE `groupvars` DISABLE KEYS */;
INSERT INTO `groupvars` VALUES (58,'key_name','cicd-automation'),(58,'main_sg_id','sg-0ac36d1278bdda8a8'),(58,'vpc_subnet','subnet-09f256f5ebfd5c109'),(58,'ami_id','ami-00019d7d71561663c'),(58,'vol_type','gp2'),(58,'vol_size','20'),(58,'regal_runtime_env','DEV'),(58,'instance_type','t3.xlarge'),(58,'postgres_version','12'),(58,'regal_domain','RGL-UK'),(58,'regal_env','dev'),(58,'regal_cluster_id','DEV'),(58,'cassandra_cluster_name','Test Cluster'),(58,'asset_url_domain','realistic-dev.com'),(58,'regal_server_type','DEV'),(58,'regal_cluster_id','DEV'),(58,'regal_db_user','regal_rw'),(58,'regal_db_pass','regal_rw'),(58,'regal_db_ro_user','regal_ro'),(58,'regal_db_ro_pass','regal_ro'),(58,'regal_farm_id','D'),(58,'regal_env_id','0'),(58,'coherence_multicast_addr','239.219.219.229'),(58,'coherence_multicast_port','12346'),(58,'games_multicast_address','239.119.119.190'),(58,'bo_multicast_address','239.119.119.110'),(58,'regal_db_host','localhost'),(58,'regal_db_port','10810'),(58,'regal_db_name','regal'),(58,'regal_jboss_version','5.2-secure'),(58,'cassandra_server','localhost'),(58,'deployment_bo_url','devbo.realistic-dev.com'),(58,'deployment_lobby_url','devlobby1.realistic-dev.com'),(58,'domain_name','aws.rgli.uk'),(60,'key_name','cicd-automation'),(60,'main_sg_id','sg-4a941121'),(60,'vpc_subnet','subnet-e7226baa'),(60,'ami_id','ami-060a8a43e3657c526'),(60,'vol_type','gp2'),(60,'vol_size','20'),(60,'regal_runtime_env','DEV'),(60,'instance_type','t2.large'),(60,'postgres_version','10'),(60,'postgres_port','10810'),(60,'regal_domain','RGL-UK'),(60,'regal_env','dev'),(60,'regal_cluster_id','DEV'),(60,'cassandra_cluster_name','regal_prod'),(60,'asset_url_domain','realisticgames.co.uk'),(60,'regal_server_type','DEV'),(60,'regal_cluster_id','DEV'),(60,'regal_db_user','regal_rw'),(60,'regal_db_pass','regal_rw'),(60,'regal_db_ro_user','regal_ro'),(60,'regal_db_ro_pass','regal_ro'),(60,'regal_farm_id','D'),(60,'regal_env_id','0'),(60,'coherence_multicast_addr','239.219.219.229'),(60,'coherence_multicast_port','12346'),(60,'games_multicast_address','239.119.119.190'),(60,'bo_multicast_address','239.119.119.110'),(60,'regal_db_host','localhost'),(60,'regal_db_port','10810'),(60,'regal_db_name','regal'),(60,'regal_jboss_version','5.2-nomulticast'),(60,'cassandra_server','localhost'),(60,'domain_name','aws.rgli.uk'),(58,'sample_data','cicd_data_hermes'),(61,'regal_runtime_env','PROD'),(61,'domain_name','aws.rgli.uk'),(58,'activationkey','1-feature-envs'),(58,'regal_version_folder','2.6.2'),(66,'security_group','euw1-production-jboss_sg'),(69,'security_group','euw1-production-dbs_sg'),(66,'instance_type','t3.xlarge'),(66,'vol_size','50'),(66,'ami_id','ami-0f8c8de06f27813a7'),(70,'instance_type','r5.2xlarge'),(70,'vol_size','50'),(70,'ami_id','ami-0f8c8de06f27813a7'),(69,'vol_size','50'),(69,'ami_id','ami-0f8c8de06f27813a7'),(69,'instance_type','r5.2xlarge'),(71,'instance_type','t3.micro'),(71,'vol_size','10'),(71,'security_group','euw1-production-cas_sg'),(71,'ami_id','ami-0f8c8de06f27813a7'),(72,'security_group','euw1-production-cas_sg'),(72,'instance_type','t3.medium'),(72,'vol_size','10'),(72,'ami_id','ami-0f8c8de06f27813a7'),(67,'security_group','euw1-production-och_sg'),(67,'instance_type','t2.large'),(67,'vol_size','50'),(67,'ami_id','ami-0f8c8de06f27813a7'),(68,'security_group','euw1-production-dmz_sg'),(68,'vol_size','50'),(68,'instance_type','t3.small'),(68,'ami_id','ami-0f8c8de06f27813a7'),(70,'security_group','euw1-production-cas_sg'),(66,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(66,'regal_version','4.0.0'),(69,'postgres_version','10'),(69,'postgres_port','10810'),(69,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(70,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(70,'cassandra_dc','euw1'),(70,'jmx_user','cassandra'),(70,'jmx_password','cassandra'),(67,'regal_version','3.10.0'),(67,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(66,'regal_jboss_version','5.2-secure'),(68,'activationkey','1-centos7-q320'),(74,'dns_domain','rgli.eu'),(66,'regal_server_type','JBS'),(67,'regal_server_type','OCH'),(76,'activationkey','1-infrastructure'),(76,'ami_id','ami-0fead72ede408484b'),(76,'domain_name','aws.rgli.uk'),(77,'domain_name','aws.rgli.uk'),(77,'activationkey','1-centos7-q320'),(77,'runtime_environment','dev'),(58,'install_frig','true'),(76,'runtime_environment','prod'),(79,'activationkey','1-infrastructure'),(79,'environment_tag','euw2-dev-infrastructure'),(79,'domain_name','aws.rgli.uk'),(79,'runtime_environment','dev'),(80,'regal_server_type','JBS'),(82,'regal_server_type','OCH'),(80,'jboss_version','5.2-secure'),(82,'jboss_version','5.2-secure'),(82,'och_node_num','1-5'),(80,'pandora_env','uat'),(80,'pandora_drone_version','1.1.0'),(80,'pandora_namespace','production'),(80,'regal_farm_id','A'),(93,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(93,'domain_name','aws.rgli.uk'),(93,'runtime_environment','dev'),(94,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(94,'domain_name','aws.rgli.uk'),(94,'runtime_environment','dev'),(95,'activationkey','1-centos7-q219'),(95,'domain_name','aws.rgli.uk'),(95,'runtime_environment','uat'),(58,'progressive_url','euw2-dev-progressives.realistic-dev.com/progressives'),(93,'elb_target_group','euw2-dev-progressive'),(93,'db_host','10.203.20.77'),(93,'db_port','5432'),(93,'db_name','progressive'),(93,'appmode','DEV'),(76,'nagios_ip','10.202.30.150'),(82,'regal_version','3.10.0'),(82,'regal_farm_id','A'),(95,'db_host','10.204.20.175'),(95,'db_port','5432'),(95,'db_name','progressive'),(95,'appmode','DEV'),(95,'elb_target_group','euw2-uat-progressives'),(95,'artifact_url','http://intranet.rgli.uk/nexus/service/local/repositories/releases/content/co/uk/realistic/progressives/progressives-service/1.0.0/progressives-service-1.0.0.jar'),(76,'environment_tag','euw2-prod-infrastructure'),(98,'activationkey','1-centos7-q219'),(98,'elb_target_group','euw1-prod-progressive'),(98,'runtime_environment','prod'),(98,'db_host','10.223.200.6'),(98,'db_port','5432'),(98,'db_name','progressive'),(98,'appmode','PROD'),(98,'domain_name','rgli.net'),(98,'vpc_region','eu-west-1'),(66,'jboss_version','5.2-secure'),(66,'och_node_num','0'),(67,'och_node_num','1-5'),(80,'start_gamenodes','GAMES01,GAMES02,GAMES03,GAMES04,GAMES05'),(58,'access_groups','noc,dba,dev_vm_ssh_access,jenkins'),(101,'domain_name','aws.rgli.uk'),(101,'activationkey','1-centos7-q219'),(101,'nagios_ip','10.202.30.150'),(101,'runtime_environment','prod'),(58,'pandora_url','http://euw2-prod-gvs01.aws.rgli.uk:5050'),(84,'nagios_ip','10.202.30.150'),(80,'och_node_num','0'),(79,'nagios_ip','10.202.30.150'),(66,'pandora_drone_version','1.1.0'),(66,'pandora_env','prod'),(66,'pandora_namespace','production'),(58,'splunk_host','euw2-dev-splunk01.aws.rgli.uk'),(58,'splunk_port','9997'),(80,'splunk_host','euw2-dev-splunk01.aws.rgli.uk'),(80,'splunk_port','9997'),(80,'install_frig','true'),(106,'activationkey','1-centos7-k8-q120'),(107,'nagios_ip','10.202.30.150'),(107,'runtime_environment','uat'),(107,'domain_name','aws.rgli.uk'),(107,'environment_tag','euw2-uat-infrastructure'),(107,'activationkey','1-centos7-q219'),(110,'activationkey','1-centos7-q219'),(58,'hermes_api','https://hermes.realistic-dev.com/hermes/api/'),(58,'jenkins_master','10.203.50.124'),(58,'server_update','true'),(80,'regal_version','4.0.0');
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
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostgroups`
--

LOCK TABLES `hostgroups` WRITE;
/*!40000 ALTER TABLE `hostgroups` DISABLE KEYS */;
INSERT INTO `hostgroups` VALUES (58,'cicd-automation','CI/CD automation'),(60,'serverteam-dev','serverteam dev hosts'),(61,'prod-infr','Platform production host'),(66,'euw1-production-jboss','All host eu-west-2 jboss'),(67,'euw1-production-och','Coherence hosts'),(68,'euw1-production-lbm','LoadBalancers'),(69,'euw1-production-dbs','Database hosts'),(70,'euw1-production-cas','Cassandra hosts'),(71,'euw1-production-dns','DNS servers'),(72,'euw1-production-auth','FreeIPA servers'),(74,'euw1-production-mgmt','Management hosts'),(75,'euw1-production-dwh','Data ware house hosts'),(76,'euw2-prod-infrastructure','EUW2 Infrastructure hosts'),(77,'euw2-dev-noc','NOC team development machines'),(79,'euw2-dev-infrastructure','All develop infrastructure'),(80,'euw2-uat-jboss','UAT jboss'),(81,'euw2-uat-cas','UAT Cassandras'),(82,'euw2-uat-och','UAT Coherence '),(83,'euw2-uat-dbs','UAT DB server'),(84,'euw2-uat-lbm','UAT LB servers'),(93,'euw2-dev-progressive','New progressive servers '),(94,'euw2-dev-dbs','Dev database serves'),(95,'euw2-uat-progressive','Progressive servers and services'),(97,'rdg-win-dc','Office domain controllers'),(98,'euw1-prod-progressive','Production progressive services'),(99,'euw1-prod-progressive-db','Progressives DB servers'),(100,'euw2-uat-progressives-db','Databaservers for progressives service'),(101,'euw2-prod-mq','All EUW2 MQ host'),(102,'euw1-prd-revproxy','Revesere proxy'),(104,'euw2-jenkins-masters','All jenkins master'),(106,'euw2-dev-k8','All K8 hosts from euw2 dev'),(107,'euw2-uat-gcs','GCS servers on UAT'),(110,'euw1-prod-gcs','Game Configuration Service'),(111,'euw2-dev-proxies','CICD proxies for dev'),(113,'patching_q221','Server to patch');
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
) ENGINE=InnoDB AUTO_INCREMENT=751 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts`
--

LOCK TABLES `hosts` WRITE;
/*!40000 ALTER TABLE `hosts` DISABLE KEYS */;
INSERT INTO `hosts` VALUES (457,'auth01'),(458,'auth02'),(472,'euw1-prd-cas02'),(473,'euw1-prd-cas01'),(474,'euw1-prd-cas03'),(475,'euw1-prd-dbs01'),(476,'euw1-prd-dbs02'),(477,'euw1-prd-dns02'),(478,'euw1-prd-dns01'),(479,'euw1-prd-jbs01'),(480,'euw1-prd-jbs02'),(481,'euw1-prd-jbs03'),(482,'euw1-prd-lbm01'),(483,'euw1-prd-lbm02'),(485,'euw1-prd-och01'),(486,'euw1-prd-och02'),(487,'euw1-prd-och03'),(489,'euw1-prd-ansible'),(490,'euw1-prd-nagios01'),(492,'qa-jenkins-master'),(510,'euw2-prod-nagios01'),(526,'euw2-prod-rev-proxy01'),(527,'euw2-prod-rev-proxy02'),(528,'euw2-dev-rev-proxy02'),(529,'euw2-dev-rev-proxy01'),(533,'euw2-uat-jbs01'),(534,'euw2-uat-jbs02'),(535,'euw2-uat-cas01'),(536,'euw2-uat-cas02'),(537,'euw2-uat-och01'),(538,'euw2-uat-och02'),(542,'euw2-uat-dbs01'),(559,'euw2-dev-regalrelease01'),(562,'euw2-dev-progressive01'),(563,'euw2-dev-progressive02'),(564,'euw2-dev-dbs01'),(567,'euw2-dev-integration01'),(568,'euw2-uat-progressive01'),(569,'euw2-uat-progressive02'),(570,'dc01.realistic.local'),(575,'euw2-prod-automation01'),(576,'euw2-prod-splunk01'),(579,'euw2-prod-artifactory01'),(581,'euw1-prod-progressive01'),(582,'euw1-prod-progressive02'),(591,'freeroundapi'),(600,'euw2-prod-mq01'),(601,'euw2-prod-mq02'),(602,'euw2-uat-bet365-proxy'),(604,'euw2-prod-bitbucket01'),(607,'euw2-prod-prometheus01'),(610,'euw2-prod-confluence01'),(621,'euw2-prd-bet365-proxy01'),(629,'clientmove'),(641,'euw2-dev-splunk01'),(652,'copysite'),(654,'euw2-prd-eudc-dbr01'),(655,'euw2-prd-customerjira01'),(657,'multi-promotions'),(658,'euw2-prod-fileshare'),(662,'euw2-prod-mailrelay01'),(664,'paymentprocessor'),(667,'solidrelease'),(670,'euw1-prd-jbs04'),(672,'euw2-uat-lbm03'),(673,'euw2-uat-lbm04'),(675,'euw2-dev-commercial01'),(676,'euw2-dev-alpha01'),(678,'euw2-dev-st-jenkins01'),(680,'euw2-prod-auth01'),(683,'euw2-dev-gamerelease01'),(684,'euw2-dev-k8-master01'),(685,'euw2-dev-k8-node01'),(687,'euw2-prod-qaproxy'),(690,'euw2-dev-k8-node02'),(693,'euw2-uat-gcs01'),(697,'euw1-prd-gcs01'),(698,'euw1-prd-gcs02'),(702,'euw2-prod-jira01'),(703,'euw2-prod-crowd01'),(708,'euw1-prd-lbm03'),(710,'euw1-prd-lbm04'),(711,'gameisolation'),(712,'euw1-prd-lbm05'),(713,'euw1-prd-dwh02'),(723,'asset-test'),(726,'buyin'),(728,'database-size-test'),(730,'playtypes'),(731,'euw2-dev-k8-node03'),(735,'euw2-dev-k8s-cpn01'),(736,'euw2-dev-dns01'),(737,'euw2-prod-atlassiandb01'),(738,'euw2-dev-k8s-cpn02'),(739,'euw2-prod-confluence02'),(745,'euw2-prod-jira02'),(747,'progressive-db-migration');
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
INSERT INTO `hostvars` VALUES (489,'ansible_host','localhost'),(479,'subnet_id','subnet-0a397a53531357a12'),(480,'subnet_id','subnet-0597733fc03be948c'),(481,'subnet_id','subnet-05d2b25b22a956b71'),(479,'ansible_host','10.223.200.10'),(480,'ansible_host','10.223.200.110'),(481,'ansible_host','10.223.200.160'),(473,'subnet_id','subnet-0a397a53531357a12'),(473,'ansible_host','10.223.200.40'),(472,'subnet_id','subnet-0597733fc03be948c'),(474,'subnet_id','subnet-05d2b25b22a956b71'),(472,'ansible_host','10.223.200.95'),(474,'ansible_host','10.223.200.150'),(475,'ansible_host','10.223.200.30'),(476,'ansible_host','10.223.200.85'),(475,'subnet_id','subnet-0a397a53531357a12'),(476,'subnet_id','subnet-0597733fc03be948c'),(478,'subnet_id','subnet-03904e30aaa18d2fb'),(478,'ansible_host','10.223.201.5'),(477,'subnet_id','subnet-06b3663a739dab9bb'),(477,'ansible_host','10.223.201.69'),(457,'ansible_host','10.223.201.4'),(458,'ansible_host','10.223.201.68'),(457,'subnet_id','subnet-03904e30aaa18d2fb'),(458,'subnet_id','subnet-06b3663a739dab9bb'),(485,'ansible_host','10.223.200.20'),(486,'ansible_host','10.223.200.75'),(487,'ansible_host','10.223.200.140'),(485,'subnet_id','subnet-0a397a53531357a12'),(486,'subnet_id','subnet-0597733fc03be948c'),(487,'subnet_id','subnet-05d2b25b22a956b71'),(482,'subnet_id','subnet-0dc7549ab32d8e278'),(482,'ansible_host','10.223.76.15'),(483,'subnet_id','subnet-0ba5390b8cb111dff'),(483,'ansible_host','10.223.76.75'),(490,'ansible_host','10.223.201.9'),(490,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(492,'ansible_host','10.203.100.93'),(492,'domain_name','aws.rgli.uk'),(492,'regal_runtime_env','PROD'),(492,'activationkey','1-2131253b4f8e08ef9bc18fbafcfe1216'),(510,'ansible_host','10.202.30.150'),(510,'main_sg_id','sg-0cffd194f712325a9'),(510,'vpc_subnet','subnet-0cddda9c173866113'),(510,'intance_type','t3.small'),(510,'vol_type','gp2'),(510,'vol_size','15'),(526,'ansible_host','10.202.100.173'),(527,'ansible_host','10.202.200.127'),(529,'ansible_host','10.203.100.94'),(528,'ansible_host','10.203.200.238'),(533,'ansible_host','10.204.10.245'),(534,'ansible_host','10.204.20.17'),(535,'ansible_host','10.204.10.120'),(536,'ansible_host','10.204.20.101'),(537,'ansible_host','10.204.10.52'),(538,'ansible_host','10.204.20.203'),(542,'ansible_host','10.204.30.147'),(559,'instance_id','i-04a6570b4437e534b'),(559,'ansible_host','10.203.20.138'),(559,'vpc_region','eu-west-2'),(559,'inst_type','t3.xlarge'),(559,'inst_status','2019-04-29T13:21:54.000Z'),(559,'avail_zone','eu-west-2b'),(559,'inst_usage','DEV'),(559,'regal_installed','true'),(562,'ansible_host','10.203.30.195'),(563,'ansible_host','10.203.20.101'),(564,'ansible_host','10.203.20.77'),(567,'ansible_host','10.203.20.150'),(567,'instance_id','i-0f3ccebf29b5e2518'),(567,'vpc_region','eu-west-2'),(567,'inst_type','t3.xlarge'),(567,'avail_zone','eu-west-2b'),(567,'inst_usage','DEV'),(567,'inst_status','2019-05-28T15:18:50.000Z'),(567,'regal_installed','true'),(567,'gn_alias','integration.realistic-dev.com,nektan.realistic-dev.com,skillonnet.realistic-dev.com,sunbingo.realistic-dev.com,kindred.realistic-dev.com,betconstruct.realistic-dev.com,isoftbet.realistic-dev.com,oryx.realistic-dev.com,nyx.realistic-dev.com,fsb.realistic-dev.com,playtech.realistic-dev.com,bet365.realistic-dev.com,bede.realistic-dev.com,betfred.realistic-dev.com,boylesports.realistic-dev.com,everymatrix.realistic-dev.com,daub.realistic-dev.com,gvc.realistic-dev.com,gr.realistic-dev.com,iforium.realistic-dev.com,optima.realistic-dev.com,rank.realistic-dev.com,vc.realistic-dev.com,vf.realistic-dev.com,rgi.realistic-dev.com,888.realistic-dev.com,solidgames.realisticgames.co.uk,solid.realistic-dev.com,realisticapi.realistic-dev.com,sharp.realistic-dev.com,tws.realistic-dev.com'),(559,'gn_alias','release2.realistic-dev.com,sunbingo-release.realistic-dev.com,kindred-release.realistic-dev.com,betconstruct-release.realistic-dev.com,isoftbet-release.realistic-dev.com,oryx-release.realistic-dev.com,nyx-release.realistic-dev.com,fsb-release.realistic-dev.com,skillonnet-release.realistic-dev.com,playtech-release.realistic-dev.com,bet365-release.realistic-dev.com,bede-release.realistic-dev.com,betfred-release.realistic-dev.com,boylesports-release.realistic-dev.com,everymatrix-release.realistic-dev.com,daub-release.realistic-dev.com,gvc-release.realistic-dev.com,gr-release.realistic-dev.com,nektan-release.realistic-dev.com,optima-release.realistic-dev.com,rank-release.realistic-dev.com,vc-release.realistic-dev.com,vf-release.realistic-dev.com,888-release.realistic-dev.com,regalrelease.realistic-dev.com'),(568,'ansible_host','10.204.10.49'),(569,'ansible_host','10.204.20.35'),(559,'bo_alias','bo-regalrelease.realistic-dev.com'),(570,'ansible_host','euw2-prod-ansible01.aws.rgli.uk'),(570,'ansible_user','backup@REALISTIC.LOCAL'),(570,'ansible_connection','winrm'),(570,'ansible_port','5985'),(570,'ansible_winrm_transport','ntlm'),(570,'ansible_winrm_server_cert_validation','ignore'),(570,'ansible_pass','StationPlace01$$'),(568,'instance_id','i-051c625c046831268'),(568,'vpc_region','eu-west-2'),(562,'instance_id','i-061884f28a77b32f6'),(562,'vpc_region','eu-west-2'),(563,'instance_id','i-036d40176f34cba06'),(563,'vpc_region','eu-west-2'),(559,'cassandra_cluster_name','Test Cluster'),(575,'ansible_host','10.202.30.206'),(575,'runtime_env','prod'),(569,'instance_id','i-034ab18243f3f4fef'),(569,'vpc_region','eu-west-2'),(576,'ansible_host','10.202.30.250'),(576,'runtime_env','prod'),(576,'dns_domain','aws.rgli.uk'),(579,'ansible_host','10.202.50.221'),(579,'runtime_env','prod'),(581,'ansible_host','10.223.200.22'),(581,'runtime_env','prod'),(582,'ansible_host','10.223.200.133'),(582,'runtime_env','prod'),(581,'instance_id','i-05428db8b4909935a'),(582,'instance_id','i-0a269a513c316d644'),(591,'instance_id','i-0b9fd0c39df120323'),(591,'ansible_host','10.203.20.234'),(591,'vpc_region','eu-west-2'),(591,'inst_type','t3.xlarge'),(591,'inst_status','2019-09-27T13:17:23.000Z'),(591,'avail_zone','eu-west-2b'),(591,'inst_usage','DEV'),(591,'regal_installed','true'),(591,'jiraticket','SOL-34'),(591,'bo_alias','freeround-bo-api.realistic-dev.com'),(600,'ansible_host','10.202.40.177'),(600,'runtime_env','prod'),(601,'ansible_host','10.202.50.34'),(601,'runtime_env','prod'),(602,'ansible_host','10.204.200.227'),(602,'runtime_env','uat'),(602,'activationkey','1-centos7-q219'),(602,'domain_name','aws.rgli.uk'),(602,'runtime_environment','uat'),(604,'ansible_host','10.202.40.5'),(604,'runtime_env','prod'),(604,'runtime_environment','prod'),(607,'ansible_host','10.202.60.40'),(607,'runtime_env','prod'),(610,'ansible_host','10.202.50.149'),(610,'runtime_env','prod'),(621,'ansible_host','10.202.100.234'),(621,'runtime_env','prod'),(621,'activationkey','1-centos7-q219'),(621,'domain_name','aws.rgli.uk'),(621,'runtime_environment','prod'),(629,'instance_id','i-070dad54202561466'),(629,'ansible_host','10.203.20.62'),(629,'vpc_region','eu-west-2'),(629,'inst_type','t3.xlarge'),(629,'inst_status','2019-08-08T15:24:36.000Z'),(629,'avail_zone','eu-west-2b'),(629,'inst_usage','DEV'),(629,'regal_installed','true'),(629,'jiraticket','CS-77'),(570,'ansible_password','StationPlace01$$'),(559,'regal_jboss_version','5.2-secure'),(591,'regal_jboss_version','5.2-secure'),(641,'ansible_host','10.202.50.58'),(641,'runtime_env','prod'),(652,'instance_id','i-0ec71dc564fd3ed5c'),(652,'ansible_host','10.203.20.189'),(652,'vpc_region','eu-west-2'),(652,'inst_type','t3.xlarge'),(652,'inst_status','2019-11-07T12:49:21.000Z'),(652,'avail_zone','eu-west-2b'),(652,'inst_usage','DEV'),(652,'regal_installed','true'),(652,'jiraticket','RGLSRV-5367'),(652,'regal_jboss_version','5.2-secure'),(652,'jboss_version','5.2-secure'),(654,'ansible_host','10.202.20.204'),(654,'runtime_env','prod'),(655,'ansible_host','10.202.50.224'),(655,'runtime_env','prod'),(559,'regal_id_generator','RUID'),(657,'instance_id','i-0832afb3f736ee15b'),(657,'ansible_host','10.203.20.252'),(657,'vpc_region','eu-west-2'),(657,'inst_type','t3.xlarge'),(657,'inst_status','2019-12-10T12:35:00.000Z'),(657,'avail_zone','eu-west-2b'),(657,'inst_usage','DEV'),(657,'regal_installed','true'),(657,'jiraticket','PRMSRV-948'),(658,'ansible_host','10.202.50.16'),(658,'runtime_env','prod'),(662,'ansible_host','10.202.10.44'),(662,'runtime_env','prod'),(664,'instance_id','i-04b8facef366b5ae6'),(664,'ansible_host','10.203.20.182'),(664,'vpc_region','eu-west-2'),(664,'inst_type','t3.xlarge'),(664,'inst_status','2020-01-15T11:54:38.000Z'),(664,'avail_zone','eu-west-2b'),(664,'inst_usage','DEV'),(664,'regal_installed','true'),(664,'jiraticket','PRMSRV-955'),(667,'instance_id','i-01618290bcb821be3'),(667,'ansible_host','10.203.20.112'),(667,'vpc_region','eu-west-2'),(667,'inst_type','t3.xlarge'),(667,'inst_status','2020-01-27T13:24:07.000Z'),(667,'avail_zone','eu-west-2b'),(667,'inst_usage','DEV'),(667,'regal_installed','true'),(667,'jiraticket','SOL-31'),(670,'ansible_host','10.223.200.117'),(670,'runtime_env','prod'),(670,'subnet_id','subnet-0597733fc03be948c'),(672,'ansible_host','10.204.40.137'),(672,'runtime_env','uat'),(673,'ansible_host','10.204.20.228'),(673,'runtime_env','uat'),(672,'jiraticket','NOC-798'),(675,'instance_id','i-0fd5c8d5232954906'),(675,'ansible_host','10.203.20.243'),(675,'vpc_region','eu-west-2'),(675,'inst_type','t3.xlarge'),(675,'inst_status','2020-03-03T14:44:24.000Z'),(675,'avail_zone','eu-west-2b'),(675,'inst_usage','DEV'),(675,'regal_installed','true'),(675,'jiraticket','RGLSRV-5467'),(675,'gn_alias','commercial-lobby.realistic-dev.com,sam.realistic-dev.com,lauren.realistic-dev.com,rob.realistic-dev.com'),(675,'bo_alias','bo-commercial.realistic-dev.com'),(676,'instance_id','i-00cfab1894505515f'),(676,'ansible_host','10.203.20.4'),(676,'vpc_region','eu-west-2'),(676,'inst_type','t3a.2xlarge'),(676,'inst_status','2020-03-03T16:07:22.000Z'),(676,'avail_zone','eu-west-2b'),(676,'inst_usage','DEV'),(676,'regal_installed','true'),(676,'jiraticket','RGLSRV-5468'),(678,'ansible_host','10.203.50.124'),(678,'runtime_env','dev'),(680,'ansible_host','10.202.60.28'),(680,'runtime_env','prod'),(680,'activationkey','1-db882d34ea0ecad3b844c33c63a200c6'),(683,'instance_id','i-01bf6e8c211373818'),(683,'ansible_host','10.203.20.119'),(683,'vpc_region','eu-west-2'),(683,'inst_type','t3.xlarge'),(683,'inst_status','2020-05-19T20:27:28.000Z'),(683,'avail_zone','eu-west-2b'),(683,'inst_usage','DEV'),(683,'regal_installed','true'),(683,'jiraticket','NA'),(683,'external_access','true'),(683,'regal_id_generator','RUID'),(683,'regal_jboss_version','5.2-secure'),(683,'cassandra_cluster_name','Test Cluster'),(683,'htaccess_file','euw2-dev-gamerelease01.htpasswd'),(683,'aws_elb','euw2-dev-public-lb-785889443.eu-west-2.elb.amazonaws.com.'),(683,'gn_alias','devgames04.realistic-dev.com,es.realistic-dev.com,dk.realistic-dev.com,release.realistic-dev.com,beta.realisticgames.co.uk,glies.realistic-dev.com,glidk.realistic-dev.com,gligb.realistic-dev.com,regal.realisticgames.co.uk,bvgames.realistic-dev.com,sv.realistic-dev.com,glisv.realistic-dev.com,nektan.realistic-dev.com,testes.realistic-dev.com,testgb.realistic-dev.com,testsv.realistic-dev.com,testpartner.realistic-dev.com,buzzbingo2.realistic-dev.com,electrocoin.realistic-dev.com,de.realistic-dev.com,gr.realistic-dev.com,betfredrelease.realistic-dev.com'),(683,'bo_alias','devgames04-bo.realistic-dev.com,mdg-bo.realistic-dev.com'),(684,'ansible_host','10.203.40.247'),(684,'runtime_env','dev'),(684,'activationkey','1-centos7-k8-q120'),(685,'ansible_host','10.203.50.112'),(685,'runtime_env','dev'),(685,'activationkey','1-centos7-k8-q120'),(687,'ansible_host','10.202.20.50'),(687,'runtime_env','prod'),(690,'ansible_host','10.203.40.218'),(690,'alert_priority','dev'),(690,'runtime_env','dev'),(693,'ansible_host','10.204.20.7'),(693,'alert_priority','uat'),(693,'runtime_env','uat'),(629,'gcs_api','http://localhost:6060/api/'),(697,'ansible_host','10.223.200.8'),(697,'alert_priority','p1'),(697,'runtime_env','prod'),(698,'ansible_host','10.223.200.70'),(698,'alert_priority','p1'),(698,'runtime_env','prod'),(683,'install_frig','true'),(702,'ansible_host','10.202.60.223'),(702,'alert_priority','p2'),(702,'runtime_env','prod'),(703,'ansible_host','10.202.50.157'),(703,'alert_priority','p2'),(703,'runtime_env','prod'),(629,'gcs_model','Real'),(629,'gcs_overriden_version','develop'),(629,'gcs_logging_debug','false'),(708,'ansible_host','10.223.200.158'),(708,'alert_priority','p1'),(708,'runtime_env','prod'),(710,'ansible_host','10.223.200.97'),(710,'alert_priority','p1'),(710,'runtime_env','prod'),(711,'instance_id','i-0fc60492ea8bd8dde'),(711,'ansible_host','10.203.20.132'),(711,'vpc_region','eu-west-2'),(711,'inst_type','t3.xlarge'),(711,'inst_status','2020-11-12T14:15:07.000Z'),(711,'avail_zone','eu-west-2b'),(711,'inst_usage','DEV'),(711,'regal_installed','true'),(711,'jiraticket','HERMES-764'),(712,'ansible_host','10.223.200.12'),(712,'alert_priority','p1'),(712,'runtime_env','prod'),(713,'ansible_host','10.223.200.186'),(713,'alert_priority','p1'),(713,'runtime_env','prod'),(723,'instance_id','i-09b4802e98552a6b2'),(723,'ansible_host','10.203.20.20'),(723,'vpc_region','eu-west-2'),(723,'inst_type','t3.xlarge'),(723,'inst_status','2021-02-05T10:00:17.000Z'),(723,'avail_zone','eu-west-2b'),(723,'inst_usage','DEV'),(723,'regal_installed','true'),(723,'jiraticket','RGLSRV-5606'),(726,'instance_id','i-050d7770bebcdcbb9'),(726,'ansible_host','10.203.20.102'),(726,'vpc_region','eu-west-2'),(726,'inst_type','t3.xlarge'),(726,'inst_status','2021-02-09T10:57:34.000Z'),(726,'avail_zone','eu-west-2b'),(726,'inst_usage','DEV'),(726,'regal_installed','true'),(726,'jiraticket','BUYIN-17'),(676,'gn_alias','new-alpha01.realistic-dev.com,alpha.realistic-dev.com,veronica.realistic-dev.com,sbff.realistic-dev.com,bvalpha.realistic-dev.com,beta.realistic-dev.com,alpha.realisticgames.co.uk'),(676,'bo_alias','bo-alpha.realistic-dev.com'),(676,'announcement','600'),(676,'aws_elb','euw2-dev-public-lb-785889443.eu-west-2.elb.amazonaws.com.'),(676,'htaccess_file','euw2-dev-alpha01.htpasswd'),(676,'external_access','true'),(676,'bo_alias','devbo.realisticgames.co.uk'),(676,'gcs_overriden_version','develop'),(629,'gcs_promotion_disable_date','23/02/2021'),(728,'instance_id','i-078c2a198a16d1263'),(728,'ansible_host','10.203.20.149'),(728,'vpc_region','eu-west-2'),(728,'inst_type','t3.xlarge'),(728,'inst_status','2021-03-04T12:55:47.000Z'),(728,'avail_zone','eu-west-2b'),(728,'inst_usage','DEV'),(728,'regal_installed','true'),(728,'jiraticket','RGLSRV-5614'),(730,'instance_id','i-01d7b99cba126e054'),(730,'ansible_host','10.203.20.221'),(730,'vpc_region','eu-west-2'),(730,'inst_type','t3.xlarge'),(730,'inst_status','2021-03-30T10:43:53.000Z'),(730,'avail_zone','eu-west-2b'),(730,'inst_usage','DEV'),(730,'regal_installed','true'),(730,'jiraticket','RGLSRV-5589'),(730,'gcs_overriden_version','develop'),(731,'ansible_host','10.203.30.43'),(731,'alert_priority','dev'),(731,'runtime_env','dev'),(731,'activationkey','1-centos7-k8-q120'),(731,'domain_name','aws.rgli.uk'),(735,'ansible_host','10.203.40.125'),(735,'alert_priority','dev'),(735,'runtime_env','dev'),(735,'domain_name','eu-west-2.compute.internal'),(735,'activationkey','1-centos7-k8-q120'),(736,'ansible_host','10.203.40.120'),(736,'alert_priority','dev'),(736,'runtime_env','dev'),(737,'ansible_host','10.202.60.125'),(737,'alert_priority','p2'),(737,'runtime_env','prod'),(738,'ansible_host','10.203.30.45'),(738,'alert_priority','dev'),(738,'runtime_env','dev'),(738,'activationkey','1-centos7-k8-q120'),(738,'domain_name','eu-west-2.compute.internal'),(739,'ansible_host','10.202.60.41'),(739,'alert_priority','p2'),(739,'runtime_env','prod'),(711,'hermes_api','https://hermes.realistic-dev.com/hermes/api'),(559,'hermes_api','https://hermes-release-force.realistic-dev.com/hermes/api'),(676,'hermes_api','https://hermes.realistic-dev.com/hermes/api'),(745,'ansible_host','10.202.50.101'),(745,'alert_priority','p2'),(745,'runtime_env','prod'),(747,'instance_id','i-06b5d0f9faf5ce903'),(747,'ansible_host','10.203.20.52'),(747,'vpc_region','eu-west-2'),(747,'inst_type','t3.xlarge'),(747,'inst_status','2021-05-25T13:29:41.000Z'),(747,'avail_zone','eu-west-2b'),(747,'inst_usage','DEV'),(747,'regal_installed','true'),(747,'jiraticket','NA');
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
INSERT INTO `memberships` VALUES (72,457),(72,458),(68,482),(68,483),(67,485),(67,486),(67,487),(71,477),(71,478),(69,475),(69,476),(70,472),(70,473),(70,474),(74,490),(61,492),(66,479),(66,480),(66,481),(76,510),(76,526),(76,527),(79,528),(79,529),(80,533),(80,534),(81,535),(81,536),(82,537),(82,538),(83,542),(58,559),(93,562),(93,563),(94,564),(58,567),(95,568),(95,569),(97,570),(76,575),(76,576),(76,579),(98,581),(98,582),(58,591),(101,600),(101,601),(84,602),(76,604),(76,607),(76,610),(76,621),(58,629),(76,641),(58,652),(76,654),(76,655),(58,657),(76,658),(76,662),(58,664),(58,667),(66,670),(84,672),(84,673),(58,675),(58,676),(79,678),(61,680),(58,683),(77,684),(77,685),(76,687),(77,690),(106,684),(106,685),(106,690),(107,693),(110,697),(110,698),(111,528),(111,529),(76,702),(76,703),(68,708),(68,710),(58,711),(68,712),(75,713),(58,723),(58,726),(58,728),(58,730),(106,731),(79,735),(106,735),(79,736),(76,737),(79,738),(106,738),(76,739),(113,591),(113,629),(113,652),(113,657),(113,664),(113,667),(113,711),(113,723),(113,726),(113,728),(113,730),(76,745),(58,747);
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
INSERT INTO `parent_child` VALUES (5,58),(5,60),(5,61),(9,76),(16,93),(16,95),(16,98),(11,80),(11,81),(11,82),(11,83),(11,84),(11,95),(11,100),(10,77),(10,79),(7,66),(7,67),(7,68),(7,69),(7,70),(7,71),(7,72),(7,74),(7,75),(7,98),(7,99),(7,110);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parentgroups`
--

LOCK TABLES `parentgroups` WRITE;
/*!40000 ALTER TABLE `parentgroups` DISABLE KEYS */;
INSERT INTO `parentgroups` VALUES (5,'rgl-aws-infr','VPC in eu-west-2'),(7,'euw1-production','EU-WEST-1 rgl production'),(9,'euw2-production','EU-West-2 Produc VPC'),(10,'euw2-dev','DEvelopment environment'),(11,'euw2-uat','UAT environment'),(16,'rgl-progressives','All progresive hostgroup');
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
INSERT INTO `parentvars` VALUES (5,'aws_region','eu-west-2'),(7,'rgl_env','prod'),(7,'vpc_name','euw1-production'),(7,'aws_region','eu-west-1'),(7,'aws_cidr_block','10.223.0.0/16'),(7,'dns01','10.223.201.4'),(7,'dns02','10.223.201.68'),(7,'ntp01','10.223.201.4'),(7,'ntp02','10.223.201.68'),(7,'dns_domain','rgli.eu'),(7,'dmz_subnet_a_cidr','10.223.76.0/26'),(7,'dmz_subnet_b_cidr','10.223.76.64/26'),(7,'dmz_subnet_c_cidr','10.223.76.128/26'),(7,'dmz_network_cidr','10.223.76.0/24'),(7,'app_subnet_a_cidr','10.223.200.0/26'),(7,'app_subnet_b_cidr','10.223.200.64/26'),(7,'app_subnet_c_cidr','10.223.200.128/26'),(7,'app_network_cidr','10.223.200.0/24'),(7,'mgmt_subnet_a_cidr','10.223.201.0/26'),(7,'mgmt_subnet_b_cidr','10.223.201.64/26'),(7,'mgmt_subnet_c_cidr','10.223.201.128/26'),(7,'mgmt_network_cidr','10.223.201.0/24'),(7,'nat_gw_cidr','10.223.1.0/24'),(7,'gib_lan','192.168.119.0/24'),(7,'gb3_app_net','10.146.200.0/24'),(7,'support_subnet_cidr','10.12.17.0/24'),(7,'qa_subnet_cidr','10.12.16.0/24'),(7,'noc_subnet_cidr','10.12.12.0/24'),(7,'public_subnet_cidr','10.223.76.0/26'),(7,'aws_az_b','eu-west-1b'),(7,'aws_az_c','eu-west-1c'),(7,'vpn_name','euw1-rdg-vpn'),(7,'rgl_gateway_ip','62.252.145.62'),(7,'rgl_cgw_name','Reading Office VirginMedia'),(7,'gib_vpn_name','euw1-gib-vpn'),(7,'rgl_gateway_gib_ip','195.244.222.164'),(7,'gib_cgw_name','Gib DC fw'),(7,'gb3_vpn_name','euw1-gb3-vpn'),(7,'gb3_cgw_name','GB3 DC fw'),(7,'rgl_gateway_gb3_ip','206.142.225.198'),(7,'aws_az_a','eu-west-1a'),(7,'eip_address','63.33.182.107'),(7,'regal_db_port','10810'),(7,'regal_db_name','regal'),(7,'regal_db_user','regal_rw'),(7,'regal_db_pass','regal_rw'),(7,'regal_env','prod'),(7,'asset_url_domain','realisticgames.co.uk'),(7,'activationkey','1-centos7-q320'),(7,'regal_runtime_env','PROD'),(7,'regal_domain','RGL-UK'),(7,'regal_cluster_id','PROD'),(7,'rgl_db_node','10.223.200.30'),(7,'rgl_db_port','5444'),(7,'rgl_db_name','regal_prod'),(7,'regal_farm_id','A'),(7,'rgl_db_host','regaldb.euw1.rgli.net'),(7,'regal_env_id','\"5\"'),(7,'regal_id_generator','\"RUID\"'),(9,'region','eu-west-2'),(11,'activationkey','1-centos7-q320'),(11,'rgl_environment','uat'),(7,'rgl_environment','eudc'),(11,'pandora_lb_url','http://euw2-uat-gvslb.realistic-uat.com'),(11,'splunk_host','euw2-dev-splunk01.aws.rgli.uk'),(11,'splunk_port','9997'),(7,'splunk_host','splunk01.aws.rgli.uk'),(7,'splunk_port','9997'),(11,'domain_name','aws.rgli.uk'),(11,'runtime_environment','DEV'),(11,'rgl_db_host','regaldb.realistic-uat.com'),(11,'rgl_db_port','10810'),(11,'rgl_db_name','regal_uat'),(11,'regal_runtime_env','DEV'),(7,'install_frig','false'),(9,'activationkey','1-infrastructure');
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
INSERT INTO `ui_vars` VALUES ('alert_priority','p1'),('alert_priority','p2'),('alert_priority','uat'),('alert_priority','dev');
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

-- Dump completed on 2021-06-17  9:32:40
