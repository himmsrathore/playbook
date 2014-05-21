Author: himmsrathore@gmail.com
Website: http://php999.blogspot.in/
		

PHP Login Script Version 2.2

* at first you have to create a new database in your http://localhost/phpmyadmin/ and then change the database name in connectvars.php  file 

* here the sql code to create new table. 


	CREATE TABLE IF NOT EXISTS `contactinfo` (
	  `user_id` int(11) NOT NULL AUTO_INCREMENT,
	  `username` varchar(32) DEFAULT NULL,
	  `password` varchar(40) DEFAULT NULL,
	  `join_date` datetime DEFAULT NULL,
	  `ipadd` float DEFAULT NULL,
	  `first_name` varchar(32) DEFAULT NULL,
	  `last_name` varchar(32) DEFAULT NULL,
	  `gender` varchar(1) DEFAULT NULL,
	  `birthdate` date DEFAULT NULL,
	  `city` varchar(32) DEFAULT NULL,
	  `occupation` varchar(30) DEFAULT NULL,
	  `company` varchar(30) DEFAULT NULL,
	  `email` varchar(45) DEFAULT NULL,
	  `picture` varchar(100) DEFAULT NULL,
	  PRIMARY KEY (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

INSERT INTO `contactinfo` (`user_id`, `username`, `password`, `join_date`, `ipadd`, `first_name`, `last_name`, `gender`, `birthdate`, `city`, `occupation`, `company`, `email`, `picture`) VALUES
(1, 'vijayanand', 'vijayanand', '2010-07-02 04:28:01', '0', 'Vijay', 'Anand', 'M', '1987-04-08', 'kumbakonam', NULL, NULL, 'anand.8487@gmail.com', 'vijay-profile.jpg');



* now you are ready to signup from your login script page