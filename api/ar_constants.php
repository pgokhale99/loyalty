<?php 
define('CLIENTSETUPFOLDER',   "clientsetup");
define('CLIENTCHECK_INI', "clientsetup/ar_config_auth.ini");
define('FUNCTIONS', 'CLIENTSETUP'."/functions"); 

define('DBHOST',   "localhost:3306");
define('DBUSER',   "applogin");
define('DBPASS',   "applogin");
define('DBNAME',   "test");

define('APIHOST',   "https://qa.api.aviva.ca/insurance/PL/NBRating/rest");
define('APIUSER',   "t_brokerlift");
define('APIPASS',   "Aviva123!");

/*
//SANDBOX
    $dbhost = "sandbox.cqafvtxmefqm.ca-central-1.rds.amazonaws.com";
    $dbuser = "brokerlift";
    $dbpass = "hSRBfJamDJaRh3PU";
    $dbname = "sandbox-ebdb";

//STAGING
	define('DBHOST',   "aaitscfbcg23ce.cqafvtxmefqm.ca-central-1.rds.amazonaws.com");
	define('DBUSER',   "brokerlift");
	define('DBPASS',   "QxpAaDRw8P");
	define('DBNAME',   "ebdb");

//AVIVA STAGING
	define('AVIVAHOST',   "https://qa.api.aviva.ca/insurance/PL/NBRating/rest");
	define('AVIVAUSER',   "t_brokerlift");
	define('AVIVAPASS',   "Aviva123!");

*/
?> 