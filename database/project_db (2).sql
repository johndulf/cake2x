-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2023 at 12:20 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getProducts` (IN `p_productid` INT)   BEGIN

if p_productid = 0 then
   select * from tbl_products;
else
   select * from tbl_products where productid = p_productid;

end if;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getReserved` (IN `p_productid` INT)   BEGIN

if p_productid = 0 then
   select * from tbl_reserved;
else
   select * from tbl_reserved where productid = p_productid;

end if;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `pusername` TEXT, IN `ppassword` TEXT)   BEGIN

declare ret int;
declare stat int;
declare c_lock int;
if exists(select * from tbl_users where username = pusername and password = ppassword) THEN

	set stat = (select status from tbl_users where username = pusername and password = password);
    set c_lock = (select counterlock from tbl_users where username = pusername and password = password);
    if stat = 1 THEN
        if c_lock >= 3 THEN
            set ret = 4;
            select ret;
        ELSE
          	set ret = 1;
    		select *,ret from tbl_users where username = pusername and password = ppassword;
        end if;
    	
    else
    	set ret = 2; 
        select ret;
    end if;

ELSE

	update tbl_users set counterlock = counterlock + 1 where username = pusername;
	set ret = 3;
    
	select ret;

end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_loginSeller` (IN `pusername` TEXT, IN `ppassword` TEXT)   BEGIN

declare ret int;
declare stat int;
declare c_lock int;
if exists(select * from tbl_sellers where username = pusername and password = ppassword) THEN

	set stat = (select status from tbl_sellers where username = pusername and password = password);
    set c_lock = (select counterlock from tbl_sellers where username = pusername and password = password);
    if stat = 1 THEN
        if c_lock >= 3 THEN
            set ret = 4;
            select ret;
        ELSE
          	set ret = 1;
    		select *,ret from tbl_sellers where username = pusername and password = ppassword;
        end if;
    	
    else
    	set ret = 2; 
        select ret;
    end if;

ELSE

	update tbl_sellers set counterlock = counterlock + 1 where username = pusername;
	set ret = 3;
    
	select ret;

end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_save` (IN `p_userid` INT, IN `p_fullname` TEXT, IN `p_username` TEXT, IN `p_password` TEXT, IN `p_address` TEXT, IN `p_mobile` INT, IN `p_email` TEXT)   BEGIN

if p_userid = 0 THEN
insert into tbl_users(fullname,username,password,address,mobile,email,user_role,date_created,status) values(p_fullname,p_username,p_password,p_address,p_mobile,p_email,2,now(),1);
ELSE
update tbl_users set fullname = p_fullname,username = p_username,password = p_password,address = p_address,mobile = p_mobile,email = p_email where userid = p_userid;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveSeller` (IN `p_sellerid` INT, IN `p_fullname` TEXT, IN `p_username` TEXT, IN `p_password` TEXT, IN `p_address` TEXT, IN `p_mobile` INT, IN `p_email` TEXT)   BEGIN

if p_sellerid = 0 THEN
insert into tbl_sellers(fullname,username,password,address,mobile,email,user_role,date_created,status) values(p_fullname,p_username,p_password,p_address,p_mobile,p_email,3,now(),1);
ELSE
update tbl_sellers set fullname = p_fullname,username = p_username,password = p_password,address = p_address,mobile = p_mobile,email = p_email where sellerid = p_sellerid;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveUpdateProduct` (IN `p_productname` TEXT, IN `p_description` TEXT, IN `p_quantity` INT, IN `p_price` TEXT, IN `p_image` TEXT, IN `p_productid` INT)   BEGIN

	if p_productid = 0 THEN
    	insert into tbl_products(productname,description,quantity,price,image,date_inserted)
        values(p_productname,p_description,p_quantity,p_price,p_image,now());
    else
    	update tbl_products set 
        productname = p_productname,
        description = p_description,
        quantity = p_quantity,
        price = p_price,
        image = p_image
        where productid = p_productid;
       
    end if;
        

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveUpdateReserved` (IN `p_productname` TEXT, IN `p_description` TEXT, IN `p_flavor` TEXT, IN `p_price` INT, IN `p_image` TEXT, IN `p_date` DATE, IN `p_productid` INT)   BEGIN

	if p_productid = 0 THEN
    	insert into tbl_reserved(productname,description,flavor,price,image,date_inserted)
        values(p_productname,p_description,p_flavor,p_price,p_image,now());
    else
    	update tbl_reserved set 
        productname = p_productname,
        description = p_description,
        flavor = p_flavor,
        price = p_price,
        image = p_image
        where productid = p_productid;
       
    end if;
        

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `productid` int(11) NOT NULL,
  `productname` text NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` text NOT NULL,
  `image` text NOT NULL,
  `date_inserted` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`productid`, `productname`, `description`, `quantity`, `price`, `image`, `date_inserted`) VALUES
(26, 'strawberry cake', 'asad', 123, '400', 'sample.jpg', '2023-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reserved`
--

CREATE TABLE `tbl_reserved` (
  `productid` int(11) NOT NULL,
  `productname` text NOT NULL,
  `description` text NOT NULL,
  `flavor` text NOT NULL,
  `price` int(11) NOT NULL,
  `image` text NOT NULL,
  `date_inserted` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sellers`
--

CREATE TABLE `tbl_sellers` (
  `sellerid` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL,
  `mobile` int(11) NOT NULL,
  `email` text NOT NULL,
  `user_role` text NOT NULL,
  `status` text NOT NULL,
  `date_created` datetime NOT NULL,
  `counterlock` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sellers`
--

INSERT INTO `tbl_sellers` (`sellerid`, `fullname`, `username`, `password`, `address`, `mobile`, `email`, `user_role`, `status`, `date_created`, `counterlock`) VALUES
(0, 'asd sadas', 'atay', 'e7d7ca730e5dabd9b10aa096cd736428', 'f', 21312, 'asdasd@gmail.com', '3', '1', '2023-05-08 13:05:46', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userid` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL,
  `mobile` int(11) NOT NULL,
  `email` text NOT NULL,
  `user_role` text NOT NULL,
  `date_created` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `counterlock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userid`, `fullname`, `username`, `password`, `address`, `mobile`, `email`, `user_role`, `date_created`, `status`, `counterlock`) VALUES
(129, 'asd sadas', 'we', '19b96d4db8d031bafadcd7ab403513f7', 'lapu lapu', 21312, 'asdasd@gmail.com', '2', '2023-05-09 07:39:51', 1, 2),
(130, 'asd sadas', 'qa', '36ffec09404cc77a186f9731a58d3210', 'f', 21312, 'asdasd@gmail.com', '2', '2023-05-09 07:47:52', 1, 2),
(135, 'qwe', 'qwe', '76d80224611fc919a5d54f0ff9fba446', 'qwe', 21312, 'wa@gmail.com', '1', '2023-05-09 08:15:53', 1, 0),
(138, 'wet', 'tobol', 'a65a1a114bdbf2612b9f0ecf16db7932', 'f', 21312, 'asdasd@gmail.com', '2', '2023-05-09 08:20:27', 1, 1),
(142, 'piste', 'ytyt', 'c24756cbd6aa7525d865880186c8a501', 'f', 21312, 'asdasd@gmail.com', '2', '2023-05-09 19:23:16', 1, 0),
(143, 'awts', 'awts', '7b664c0a58675c42e33b371b87f7ff0a', 'f', 21312, 'asdasd@gmail.com', '2', '2023-05-10 12:22:37', 1, 0),
(144, 'tr', 'tr', 'e7d707a26e7f7b6ff52c489c60e429b1', 'tn', 21312, 'wa@gmail.com', '2', '2023-05-10 12:23:33', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `tbl_reserved`
--
ALTER TABLE `tbl_reserved`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `tbl_sellers`
--
ALTER TABLE `tbl_sellers`
  ADD PRIMARY KEY (`sellerid`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_reserved`
--
ALTER TABLE `tbl_reserved`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
