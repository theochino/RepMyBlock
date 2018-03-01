-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: NYSVoters
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Table structure for table `Candidate`
--

DROP TABLE IF EXISTS `Candidate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Candidate` (
  `Candidate_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Raw_Voter_ID` int(10) unsigned DEFAULT NULL,
  `Raw_Voter_Dates_ID` int(10) unsigned DEFAULT NULL,
  `Candidate_DispName` varchar(256) DEFAULT NULL,
  `Candidate_DispPosition` varchar(256) DEFAULT NULL,
  `Candidate_DispResidence` varchar(256) DEFAULT NULL,
  `CandidateAptment_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Candidate_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CandidateAptment`
--

DROP TABLE IF EXISTS `CandidateAptment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CandidateAptment` (
  `CandidateAptment_ID` int(10) unsigned DEFAULT NULL,
  `Raw_Voter_ID` int(10) unsigned DEFAULT NULL,
  `Raw_Voter_Dates_ID` int(10) unsigned DEFAULT NULL,
  `CandidateAptment_Label` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CandidatePetition`
--

DROP TABLE IF EXISTS `CandidatePetition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CandidatePetition` (
  `CandidatePetition_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Candidate_ID` int(10) unsigned DEFAULT NULL,
  `FollowUp_ID` int(10) unsigned DEFAULT NULL,
  `CandidatePetition_Order` int(11) unsigned DEFAULT NULL,
  `Raw_Voter_ID` int(10) unsigned DEFAULT NULL,
  `Raw_Voter_Dates_ID` int(11) unsigned DEFAULT NULL,
  `VotersIndexes_ID` int(10) unsigned DEFAULT NULL,
  `CandidatePetition_VoterFullName` varchar(100) DEFAULT NULL,
  `CandidatePetition_VoterResidenceLine1` varchar(100) DEFAULT NULL,
  `CandidatePetition_VoterResidenceLine2` varchar(100) DEFAULT NULL,
  `CandidatePetition_VoterResidenceLine3` varchar(100) DEFAULT NULL,
  `CandidatePetition_VoterCounty` varchar(100) DEFAULT NULL,
  `CandidatePetition_SignedDate` date DEFAULT NULL,
  PRIMARY KEY (`CandidatePetition_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CandidateWitness`
--

DROP TABLE IF EXISTS `CandidateWitness`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CandidateWitness` (
  `CandidateWitness_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CandidateWitness_FullName` varchar(256) DEFAULT NULL,
  `CandidateWitness_Party` varchar(50) DEFAULT NULL,
  `CandidateWitness_Residence` varchar(256) DEFAULT NULL,
  `CandidateWitness_City` varchar(256) DEFAULT NULL,
  `CandidateWitness_County` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CandidateWitness_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CityCentric_NYC`
--

DROP TABLE IF EXISTS `CityCentric_NYC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CityCentric_NYC` (
  `CityCentric_NYC_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CityCentric_NYC_DOBBIN` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`CityCentric_NYC_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Cordinate`
--

DROP TABLE IF EXISTS `Cordinate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cordinate` (
  `Cordinate_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Cordinate_Latitude` decimal(20,15) DEFAULT NULL,
  `Cordinate_Longitude` decimal(20,15) DEFAULT NULL,
  PRIMARY KEY (`Cordinate_ID`),
  KEY `Cordinate_LatLong_IDX` (`Cordinate_Latitude`,`Cordinate_Longitude`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CordinateBox`
--

DROP TABLE IF EXISTS `CordinateBox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CordinateBox` (
  `CordinateBox_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CordinateBox_ShapeArea` varchar(100) DEFAULT NULL,
  `CordinateBox_ElectDist` varchar(100) DEFAULT NULL,
  `CordinateBox_ShapeLeng` varchar(100) DEFAULT NULL,
  `CordinateBox_Shape` varchar(100) DEFAULT NULL,
  `CordinateBox_ValidStartDate` date DEFAULT NULL,
  `CordinateBox_ValidEndDate` date DEFAULT NULL,
  PRIMARY KEY (`CordinateBox_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CordinateGroup`
--

DROP TABLE IF EXISTS `CordinateGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CordinateGroup` (
  `CordinateGroup_Segment` int(10) unsigned DEFAULT NULL,
  `CordinateGroup_Order` int(10) unsigned DEFAULT NULL,
  `Cordinate_ID` int(10) unsigned DEFAULT NULL,
  `CordinateBox_ID` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DataAddress`
--

DROP TABLE IF EXISTS `DataAddress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DataAddress` (
  `DataAddress_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataAddress_HouseNumber` varchar(100) DEFAULT NULL,
  `DataAddress_FracAddress` varchar(100) DEFAULT NULL,
  `DataAddress_PreStreet` varchar(100) DEFAULT NULL,
  `DataStreet_ID` int(10) unsigned DEFAULT NULL,
  `DataAddress_PostStreet` varchar(100) DEFAULT NULL,
  `DataCity_ID` int(10) unsigned DEFAULT NULL,
  `DataState_ID` int(10) unsigned DEFAULT NULL,
  `DataAddress_zipcode` varchar(30) DEFAULT NULL,
  `DataAddress_zip4` varchar(10) DEFAULT NULL,
  `Cordinate_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DataAddress_ID`),
  KEY `DataAddressAll_IDX` (`DataAddress_HouseNumber`,`DataAddress_FracAddress`,`DataAddress_PreStreet`,`DataStreet_ID`,`DataAddress_PostStreet`,`DataCity_ID`,`DataState_ID`,`DataAddress_zipcode`,`DataAddress_zip4`),
  KEY `DataAddressZipcodes_IDX` (`DataAddress_zipcode`),
  KEY `DataAddressMost` (`DataAddress_HouseNumber`,`DataAddress_FracAddress`,`DataAddress_PreStreet`,`DataStreet_ID`,`DataAddress_PostStreet`,`DataCity_ID`,`DataState_ID`,`DataAddress_zipcode`),
  KEY `DataAddressCordinate_IDX` (`Cordinate_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DataCity`
--

DROP TABLE IF EXISTS `DataCity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DataCity` (
  `DataCity_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataCity_Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`DataCity_ID`),
  KEY `DataCityName_IDX` (`DataCity_Name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DataHouse`
--

DROP TABLE IF EXISTS `DataHouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DataHouse` (
  `DataHouse_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataAddress_ID` int(10) unsigned DEFAULT NULL,
  `DataHouse_Apt` varchar(100) DEFAULT NULL,
  `DataHouse_BIN` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DataHouse_ID`),
  KEY `DataHouseDataAddress_IDX` (`DataAddress_ID`),
  KEY `DataHouseDataAddressApt_IDX` (`DataAddress_ID`,`DataHouse_Apt`),
  KEY `DataHouse_BIN_IDX` (`DataHouse_BIN`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DataState`
--

DROP TABLE IF EXISTS `DataState`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DataState` (
  `DataState_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataState_Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`DataState_ID`),
  KEY `DataStateName_IDX` (`DataState_Name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DataStreet`
--

DROP TABLE IF EXISTS `DataStreet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DataStreet` (
  `DataStreet_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataStreet_Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`DataStreet_ID`),
  KEY `DataStreetName_IDX` (`DataStreet_Name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Elections`
--

DROP TABLE IF EXISTS `Elections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Elections` (
  `Elections_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Elections_Text` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`Elections_ID`),
  KEY `Elections_ID_IDX` (`Elections_Text`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ElectionsVoted`
--

DROP TABLE IF EXISTS `ElectionsVoted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ElectionsVoted` (
  `VotersIndexes_ID` int(10) unsigned DEFAULT NULL,
  `Elections_ID` int(10) unsigned DEFAULT NULL,
  KEY `ElectionsVoted_ID_IDX` (`Elections_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `FacebookMessaging`
--

DROP TABLE IF EXISTS `FacebookMessaging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FacebookMessaging` (
  `FacebookMessaging_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FacebookMessaging_Sender` varchar(20) DEFAULT NULL,
  `FacebookMessaging_Recipient` varchar(20) DEFAULT NULL,
  `FacebookMessaging_TimeStampRcvFck` datetime DEFAULT NULL,
  `FacebookMessaging_TimeStampReplyFck` datetime DEFAULT NULL,
  `FacebookMessaging_MID` varchar(40) DEFAULT NULL,
  `FacebookMessaging_Seq` int(10) unsigned DEFAULT NULL,
  `FaceBookMessaging_Text` text,
  `FaceBookMessaging_Tampon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`FacebookMessaging_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GeoCord`
--

DROP TABLE IF EXISTS `GeoCord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeoCord` (
  `GeoCord_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GeoCord_Lat` decimal(18,14) DEFAULT NULL,
  `GeoCord_Long` decimal(18,14) DEFAULT NULL,
  PRIMARY KEY (`GeoCord_ID`),
  KEY `GeoCord_LatLong_IDX` (`GeoCord_Lat`,`GeoCord_Long`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GeoDesc`
--

DROP TABLE IF EXISTS `GeoDesc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeoDesc` (
  `GeoDesc_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GeoGroup_ID` int(11) DEFAULT NULL,
  `GeoDesc_Name` varchar(255) DEFAULT NULL,
  `GeoDesc_Abbrev` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`GeoDesc_ID`),
  KEY `GeoDesc_Abbrev_IDX` (`GeoDesc_Abbrev`),
  KEY `GeoDesc_Name_IDX` (`GeoDesc_Name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GeoDescCords`
--

DROP TABLE IF EXISTS `GeoDescCords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeoDescCords` (
  `GeoDesc_ID` int(10) unsigned DEFAULT NULL,
  `GeoCord_ID` int(10) unsigned DEFAULT NULL,
  `GeoDescCordsMajOrd` int(10) unsigned DEFAULT NULL,
  `GeoDescCordsMinOrd` int(10) unsigned DEFAULT NULL,
  KEY `GeoDescCords_GeoDesc_IDX` (`GeoDesc_ID`),
  KEY `GeoDescCords_GeoCord_IDX` (`GeoCord_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GeoDistrict`
--

DROP TABLE IF EXISTS `GeoDistrict`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeoDistrict` (
  `GeoDistrict_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GeoDesc_ID` int(10) unsigned DEFAULT NULL,
  `GeoDistrict_Name` varchar(255) DEFAULT NULL,
  `GeoDistrict_Abbrev` varchar(255) DEFAULT NULL,
  `GeoDistrict_ValidFrom` date DEFAULT NULL,
  `GeoDistrict_ValidTo` date DEFAULT NULL,
  PRIMARY KEY (`GeoDistrict_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GeoDistrictDesc`
--

DROP TABLE IF EXISTS `GeoDistrictDesc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeoDistrictDesc` (
  `GeoDistrict_ID` int(10) unsigned DEFAULT NULL,
  `GeoDesc_ID` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GeoGroup`
--

DROP TABLE IF EXISTS `GeoGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeoGroup` (
  `GeoGroup_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GeoGroup_ShortName` varchar(30) DEFAULT NULL,
  `GeoGroup_Name` varchar(255) DEFAULT NULL,
  `GeoGroup_Desc` text,
  `GeoGroup_ValidFrom` date DEFAULT NULL,
  `GeoGroup_ValidTo` date DEFAULT NULL,
  PRIMARY KEY (`GeoGroup_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Raw_Voter`
--

DROP TABLE IF EXISTS `Raw_Voter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Raw_Voter` (
  `Raw_Voter_ID` int(10) unsigned NOT NULL,
  `Raw_Voter_Dates_ID` int(10) unsigned NOT NULL,
  `Raw_Voter_TableDate_ID` int(10) unsigned NOT NULL,
  `Raw_Voter_UniqNYSVoterID` varchar(50) DEFAULT NULL,
  KEY `Raw_Voter_UniqNYSVoterID_IDX` (`Raw_Voter_UniqNYSVoterID`),
  KEY `Raw_Voter_Raw_Voter_ID_IDX` (`Raw_Voter_ID`),
  KEY `Raw_Voter_RawVoter_DateID` (`Raw_Voter_TableDate_ID`,`Raw_Voter_Dates_ID`),
  KEY `Raw_Voter_RawVoter_UniqDatedID` (`Raw_Voter_TableDate_ID`,`Raw_Voter_UniqNYSVoterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Raw_Voter_20151215`
--

DROP TABLE IF EXISTS `Raw_Voter_20151215`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Raw_Voter_20151215` (
  `Raw_Voter_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Raw_Voter_LastName` varchar(50) DEFAULT NULL,
  `Raw_Voter_FirstName` varchar(50) DEFAULT NULL,
  `Raw_Voter_MiddleName` varchar(50) DEFAULT NULL,
  `Raw_Voter_Suffix` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResHouseNumber` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResFracAddress` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResApartment` varchar(15) DEFAULT NULL,
  `Raw_Voter_ResPreStreet` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResStreetName` varchar(70) DEFAULT NULL,
  `Raw_Voter_ResPostStDir` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResCity` varchar(50) DEFAULT NULL,
  `Raw_Voter_ResZip` char(5) DEFAULT NULL,
  `Raw_Voter_ResZip4` char(4) DEFAULT NULL,
  `Raw_Voter_ResMail1` varchar(100) DEFAULT NULL,
  `Raw_Voter_ResMail2` varchar(100) DEFAULT NULL,
  `Raw_Voter_ResMail3` varchar(100) DEFAULT NULL,
  `Raw_Voter_ResMail4` varchar(100) DEFAULT NULL,
  `Raw_Voter_DOB` char(8) DEFAULT NULL,
  `Raw_Voter_Gender` char(1) DEFAULT NULL,
  `Raw_Voter_EnrollPolParty` char(3) DEFAULT NULL,
  `Raw_Voter_OtherParty` varchar(30) DEFAULT NULL,
  `Raw_Voter_CountyCode` char(2) DEFAULT NULL,
  `Raw_Voter_ElectDistr` char(3) DEFAULT NULL,
  `Raw_Voter_LegisDistr` char(3) DEFAULT NULL,
  `Raw_Voter_TownCity` varchar(30) DEFAULT NULL,
  `Raw_Voter_Ward` char(3) DEFAULT NULL,
  `Raw_Voter_CongressDistr` char(3) DEFAULT NULL,
  `Raw_Voter_SenateDistr` char(3) DEFAULT NULL,
  `Raw_Voter_AssemblyDistr` char(3) DEFAULT NULL,
  `Raw_Voter_LastDateVoted` char(8) DEFAULT NULL,
  `Raw_Voter_PrevYearVoted` varchar(4) DEFAULT NULL,
  `Raw_Voter_PrevCounty` char(2) DEFAULT NULL,
  `Raw_Voter_PrevAddress` varchar(100) DEFAULT NULL,
  `Raw_Voter_PrevName` varchar(150) DEFAULT NULL,
  `Raw_Voter_CountyVoterNumber` varchar(50) DEFAULT NULL,
  `Raw_Voter_RegistrationCharacter` char(8) DEFAULT NULL,
  `Raw_Voter_ApplicationSource` varchar(10) DEFAULT NULL,
  `Raw_Voter_IDRequired` char(1) DEFAULT NULL,
  `Raw_Voter_IDMet` char(1) DEFAULT NULL,
  `Raw_Voter_Status` varchar(10) DEFAULT NULL,
  `Raw_Voter_ReasonCode` varchar(15) DEFAULT NULL,
  `Raw_Voter_VoterMadeInactive` char(8) DEFAULT NULL,
  `Raw_Voter_VoterPurged` char(8) DEFAULT NULL,
  `Raw_Voter_UniqNYSVoterID` varchar(50) DEFAULT NULL,
  `Raw_Voter_VoterHistory` text,
  PRIMARY KEY (`Raw_Voter_ID`),
  KEY `Raw_Voter_20151215_LastName_IDX` (`Raw_Voter_LastName`),
  KEY `Raw_Voter_20151215_UniqNYSVoterID_IDX` (`Raw_Voter_UniqNYSVoterID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Raw_Voter_20170515`
--

DROP TABLE IF EXISTS `Raw_Voter_20170515`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Raw_Voter_20170515` (
  `Raw_Voter_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Raw_Voter_LastName` varchar(50) DEFAULT NULL,
  `Raw_Voter_FirstName` varchar(50) DEFAULT NULL,
  `Raw_Voter_MiddleName` varchar(50) DEFAULT NULL,
  `Raw_Voter_Suffix` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResHouseNumber` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResFracAddress` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResApartment` varchar(15) DEFAULT NULL,
  `Raw_Voter_ResPreStreet` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResStreetName` varchar(70) DEFAULT NULL,
  `Raw_Voter_ResPostStDir` varchar(10) DEFAULT NULL,
  `Raw_Voter_ResCity` varchar(50) DEFAULT NULL,
  `Raw_Voter_ResZip` char(5) DEFAULT NULL,
  `Raw_Voter_ResZip4` char(4) DEFAULT NULL,
  `Raw_Voter_ResMail1` varchar(100) DEFAULT NULL,
  `Raw_Voter_ResMail2` varchar(100) DEFAULT NULL,
  `Raw_Voter_ResMail3` varchar(100) DEFAULT NULL,
  `Raw_Voter_ResMail4` varchar(100) DEFAULT NULL,
  `Raw_Voter_DOB` char(8) DEFAULT NULL,
  `Raw_Voter_Gender` char(1) DEFAULT NULL,
  `Raw_Voter_EnrollPolParty` char(3) DEFAULT NULL,
  `Raw_Voter_OtherParty` varchar(30) DEFAULT NULL,
  `Raw_Voter_CountyCode` char(2) DEFAULT NULL,
  `Raw_Voter_ElectDistr` char(3) DEFAULT NULL,
  `Raw_Voter_LegisDistr` char(3) DEFAULT NULL,
  `Raw_Voter_TownCity` varchar(30) DEFAULT NULL,
  `Raw_Voter_Ward` char(3) DEFAULT NULL,
  `Raw_Voter_CongressDistr` char(3) DEFAULT NULL,
  `Raw_Voter_SenateDistr` char(3) DEFAULT NULL,
  `Raw_Voter_AssemblyDistr` char(3) DEFAULT NULL,
  `Raw_Voter_LastDateVoted` char(8) DEFAULT NULL,
  `Raw_Voter_PrevYearVoted` varchar(4) DEFAULT NULL,
  `Raw_Voter_PrevCounty` char(2) DEFAULT NULL,
  `Raw_Voter_PrevAddress` varchar(100) DEFAULT NULL,
  `Raw_Voter_PrevName` varchar(150) DEFAULT NULL,
  `Raw_Voter_CountyVoterNumber` varchar(50) DEFAULT NULL,
  `Raw_Voter_RegistrationCharacter` char(8) DEFAULT NULL,
  `Raw_Voter_ApplicationSource` varchar(10) DEFAULT NULL,
  `Raw_Voter_IDRequired` char(1) DEFAULT NULL,
  `Raw_Voter_IDMet` char(1) DEFAULT NULL,
  `Raw_Voter_Status` varchar(10) DEFAULT NULL,
  `Raw_Voter_ReasonCode` varchar(15) DEFAULT NULL,
  `Raw_Voter_VoterMadeInactive` char(8) DEFAULT NULL,
  `Raw_Voter_VoterPurged` char(8) DEFAULT NULL,
  `Raw_Voter_UniqNYSVoterID` varchar(50) DEFAULT NULL,
  `Raw_Voter_VoterHistory` text,
  PRIMARY KEY (`Raw_Voter_ID`),
  KEY `Raw_Voter_20170515_LastName_IDX` (`Raw_Voter_LastName`),
  KEY `Raw_Voter_20170515_UniqNYSVoterID_IDX` (`Raw_Voter_UniqNYSVoterID`),
  KEY `Raw_Voter_20170515_ADED_IDX` (`Raw_Voter_AssemblyDistr`,`Raw_Voter_ElectDistr`),
  KEY `Raw_Voter_20170515_Zipcode_IDX` (`Raw_Voter_ResZip`),
  KEY `Raw_Voter_20170515_Party_Status` (`Raw_Voter_Status`,`Raw_Voter_EnrollPolParty`),
  KEY `Raw_Voter_20170515_Party_Status_Assembly_Election` (`Raw_Voter_Status`,`Raw_Voter_EnrollPolParty`,`Raw_Voter_ElectDistr`),
  KEY `Raw_Voter_20170515_Party_Status_ADED_IDX` (`Raw_Voter_Status`,`Raw_Voter_EnrollPolParty`,`Raw_Voter_ElectDistr`,`Raw_Voter_AssemblyDistr`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Raw_Voter_Dates`
--

DROP TABLE IF EXISTS `Raw_Voter_Dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Raw_Voter_Dates` (
  `Raw_Voter_Dates_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Raw_Voter_Dates_Date` char(8) DEFAULT NULL,
  PRIMARY KEY (`Raw_Voter_Dates_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UserBinding`
--

DROP TABLE IF EXISTS `UserBinding`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserBinding` (
  `UserBinding_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FacebookMessaging_UserID` varchar(20) DEFAULT NULL,
  `UserProgress_ID` int(10) unsigned DEFAULT NULL,
  `UserDecisionTree` int(10) unsigned DEFAULT NULL,
  `VotersIndexes_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`UserBinding_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UserDecisionTree`
--

DROP TABLE IF EXISTS `UserDecisionTree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserDecisionTree` (
  `UserDecisionTree_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserDecisionTree_NextQuestion` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`UserDecisionTree_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UserProgress`
--

DROP TABLE IF EXISTS `UserProgress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserProgress` (
  `UserProgress_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserProgress_FirstName` varchar(256) DEFAULT NULL,
  `UserProgress_LastName` varchar(256) DEFAULT NULL,
  `UserProgress_MiddleName` varchar(256) DEFAULT NULL,
  `UserProgress_Address_Line1` varchar(256) DEFAULT NULL,
  `UserProgress_Address_Line2` varchar(256) DEFAULT NULL,
  `UserProgress_Address_Line3` varchar(256) DEFAULT NULL,
  `UserProgress_Address_Line4` varchar(256) DEFAULT NULL,
  `UserProgress_LastInteraction` datetime DEFAULT NULL,
  PRIMARY KEY (`UserProgress_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `VoterAddress`
--

DROP TABLE IF EXISTS `VoterAddress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VoterAddress` (
  `DataHouse_ID` int(10) unsigned DEFAULT NULL,
  `Raw_Voter_ID` int(10) unsigned DEFAULT NULL,
  `Raw_Voter_Dates_ID` int(10) unsigned DEFAULT NULL,
  KEY `idx_VoterAddress_Raw_Voter_Dates_ID` (`Raw_Voter_Dates_ID`),
  KEY `VoterAddress_ALL_IDX` (`DataHouse_ID`,`Raw_Voter_ID`,`Raw_Voter_Dates_ID`),
  KEY `VoterAddress_Raw_Voter_ID_IDX` (`Raw_Voter_ID`),
  KEY `VoterAddress_RawVoter_RawDates_IDX` (`Raw_Voter_ID`,`Raw_Voter_Dates_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `VotersFirstName`
--

DROP TABLE IF EXISTS `VotersFirstName`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VotersFirstName` (
  `VotersFirstName_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VotersFirstName_Text` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`VotersFirstName_ID`),
  KEY `VotersFirstName_Text_IDX` (`VotersFirstName_Text`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `VotersIndexes`
--

DROP TABLE IF EXISTS `VotersIndexes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VotersIndexes` (
  `VotersIndexes_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Raw_Voter_ID` int(10) unsigned DEFAULT NULL,
  `VotersLastName_ID` int(10) unsigned DEFAULT NULL,
  `VotersFirstName_ID` int(10) unsigned DEFAULT NULL,
  `VotersMiddleName_ID` int(10) unsigned DEFAULT NULL,
  `VotersIndexes_UniqNYSVoterID` char(20) DEFAULT NULL,
  PRIMARY KEY (`VotersIndexes_ID`),
  KEY `VotersIndexes_UniqNYSVoterID_IDX` (`VotersIndexes_UniqNYSVoterID`),
  KEY `VotersIndexes_VotersFirstName_IDX` (`VotersFirstName_ID`),
  KEY `VotersIndexes_VotersMiddleName_IDX` (`VotersMiddleName_ID`),
  KEY `VotersIndexes_VotersLastName_IDX` (`VotersLastName_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `VotersLastName`
--

DROP TABLE IF EXISTS `VotersLastName`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VotersLastName` (
  `VotersLastName_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VotersLastName_Text` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`VotersLastName_ID`),
  KEY `VotersLastName_Text_IDX` (`VotersLastName_Text`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `VotersMiddleName`
--

DROP TABLE IF EXISTS `VotersMiddleName`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VotersMiddleName` (
  `VotersMiddleName_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VotersMiddleName_Text` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`VotersMiddleName_ID`),
  KEY `VotersMiddleName_Text_IDX` (`VotersMiddleName_Text`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-01  1:43:25
