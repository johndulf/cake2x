-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2023 at 05:46 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getAllUser` (IN `p_user_id` INT)   BEGIN
	if p_user_id = 0 THEN
    	SELECT * FROM tbl_users;
    ELSE
    	SELECT * FROM tbl_users WHERE userid = p_user_id;
    end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getCustomize` (IN `p_reserveid` INT)   BEGIN

if p_reserveid = 0 then
   select * from tbl_customize;
else
   select * from tbl_customize where reserveid = p_reserveid;

end if;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getProducts` (IN `p_productid` INT)   BEGIN

if p_productid = 0 then
   select * from tbl_products;
else
   select * from tbl_products where productid = p_productid;

end if;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getReserveList` (IN `p_reserved_id` INT)   BEGIN

	if p_reserved_id = 0 THEN
    	SELECT *,tbl_reserved.quantity AS rq FROM tbl_reserved LEFT JOIN tbl_users ON tbl_reserved.user_id = tbl_users.userid LEFT JOIN tbl_products ON tbl_reserved.product_id = tbl_products.productid ;
    else
    	SELECT * FROM tbl_reserved WHERE reserved_id = p_reserved_id;
    end if;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `pusername` TEXT, IN `ppassword` TEXT)   BEGIN

declare ret int;
declare stat int;
declare c_lock int;
if exists(select * from tbl_users where username = pusername and password = ppassword) THEN

	set stat = (select user_status from tbl_users where username = pusername and password = password);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_save` (IN `p_userid` INT, IN `p_fullname` TEXT, IN `p_username` TEXT, IN `p_password` TEXT, IN `p_address` TEXT, IN `p_mobile` VARCHAR(11), IN `p_email` TEXT)   BEGIN

if p_userid = 0 THEN
insert into tbl_users(fullname,username,password,address,mobile,email,user_role,user_status,date_created) values(p_fullname,p_username,p_password,p_address,p_mobile,p_email,1,1,now());
ELSE
update tbl_users set fullname = p_fullname,username = p_username,address = p_address,mobile = p_mobile,email = p_email where userid = p_userid;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveCustomize` (IN `p_reserveid` INT, IN `p_userid` INT, IN `p_suggestion` TEXT, IN `p_message` TEXT, IN `p_flavor` TEXT, IN `p_size` TEXT, IN `p_quantity` INT, IN `p_price` INT, IN `p_total` INT, IN `p_image` TEXT, IN `p_date_created` TEXT)   BEGIN
	if p_reserveid = 0 THEN
    	INSERT INTO tbl_customize(userid,suggestion,message,flavor,size,quantity,price,total,image,status,date_created)
  		VALUES(p_userid,p_suggestion,p_message,p_flavor,p_size,p_quantity,p_price,p_total,p_image,0,p_date_created);
     else 
     	if p_image != "" THEN
     		update tbl_customize SET 
        		userid = p_userid,
            	suggestion = p_suggestion,
            	message = p_message,
            	flavor = p_flavor,
            	size = p_size,
            	quantity = p_quantity,
                price = p_price,
                total = p_total,
                image = p_image,
                date_created = p_date_created,
            	status = 1 WHERE p_reserveid = p_reserveid;
         else 
         update tbl_customize SET 
        		userid = p_userid,
            	suggestion = p_suggestion,
            	message = p_message,
            	flavor = p_flavor,
            	size = p_size,
            	quantity = p_quantity,
                date_created = p_date_created,
            	status = 1 WHERE p_reserveid = p_reserveid;
         end if;
      end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveSeller` (IN `p_sellerid` INT, IN `p_fullname` TEXT, IN `p_username` TEXT, IN `p_password` TEXT, IN `p_address` TEXT, IN `p_mobile` INT, IN `p_email` TEXT)   BEGIN

if p_sellerid = 0 THEN
insert into tbl_sellers(fullname,username,password,address,mobile,email,user_role,date_created,user_status) values(p_fullname,p_username,p_password,p_address,p_mobile,p_email,3,now(),1);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveUpdateReserved` (IN `p_product_id` INT, IN `p_user_id` INT, IN `p_size` TEXT, IN `p_price` INT, IN `p_quantity` INT, IN `p_total` INT, IN `p_status` INT, IN `p_reserved_id` INT)   BEGIN

	if p_reserved_id = 0 THEN
    	insert into tbl_reserved(product_id,user_id,size,price,quantity,total,status,date_inserted)
        				VALUES(p_product_id,p_user_id,p_size,p_price,p_quantity,p_total,p_status,now());
    else
    	update tbl_reserved set 
        user_id = p_user_id,
        size = p_size,
        price = p_price,
        quantity = p_quantity,
        total = p_total,
        status = p_status
        where reserved_id = p_reserved_id;
       
    end if;
        

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateCustomize` (IN `p_reserveid` INT, IN `p_userid` INT, IN `p_fullname` TEXT, IN `p_suggestion` TEXT, IN `p_message` TEXT, IN `p_flavor` TEXT, IN `p_size` TEXT, IN `p_address` TEXT, IN `p_mobile` VARCHAR(11), IN `p_image` TEXT, IN `p_quantity` INT, IN `p_date_created` DATE)   BEGIN
	if p_reserveid = 0 THEN
    INSERT INTO tbl_customize(userid,fullname,suggestion,message,flavor,size,address,mobile,quantity,image,date_created,status)
  VALUES(p_userid,p_fullname,p_suggestion,p_message,p_flavor,p_size,p_image,p_quantity,p_date_created,0);
     else 
     	if p_image != "" THEN
     		update tbl_customize SET 
        		userid = p_userid,
            	fullname = p_fullname,
            	suggestion = p_suggestion,
            	message = p_message,
            	flavor = p_flavor,
            	size = p_size,
                address = p_address,
                mobile = p_mobile,
            	image = p_image,
            	quantity = p_quantity,
                date_created = p_date_created,
            	status = 1 WHERE p_reserveid = p_reserveid;
         else 
         update tbl_customize SET 
        		userid = p_userid,
            	fullname = p_fullname,
            	suggestion = p_suggestion,
            	message = p_message,
            	flavor = p_flavor,
            	size = p_size,
                address = p_address,
                mobile = p_mobile,
            	quantity = p_quantity,
                date_created = p_date_created,
            	status = 1 WHERE p_reserveid = p_reserveid;
         end if;
      end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateStatusReserve` (IN `p_reserved_id` INT, IN `p_status` INT)   BEGIN
	UPDATE tbl_reserved SET
    status = p_status WHERE reserved_id = p_reserved_id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customize`
--

CREATE TABLE `tbl_customize` (
  `reserveid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `suggestion` text NOT NULL,
  `message` text NOT NULL,
  `flavor` text NOT NULL,
  `size` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `image` text NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customize`
--

INSERT INTO `tbl_customize` (`reserveid`, `userid`, `suggestion`, `message`, `flavor`, `size`, `quantity`, `price`, `total`, `image`, `status`, `date_created`) VALUES
(2, 158, 'asdasd', 'asd', 'Cookies', 'medium', 2, 400, 800, 'c.jpg', 0, '2023-05-02');

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
(31, 'caramels', 'asdasd', 32, '300', 'blog-img2.png', '2023-05-18'),
(32, 'strawberry cake', 'asd', 2, '220', 'menu9.jpg', '2023-05-19'),
(35, 'strawberry cake', '4', 5, '500', 'b1.jpg', '2023-05-20'),
(36, 'caramels', 'ad', 21, '20', 'b1.jpg', '2023-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reserved`
--

CREATE TABLE `tbl_reserved` (
  `reserved_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `size` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_inserted` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reserved`
--

INSERT INTO `tbl_reserved` (`reserved_id`, `product_id`, `user_id`, `size`, `price`, `quantity`, `total`, `status`, `date_inserted`) VALUES
(1, 31, 158, 'small', 300, 1, 300, 0, '2023-05-22'),
(2, 32, 158, 'small', 220, 1, 220, 0, '2023-05-22'),
(3, 35, 158, 'small', 500, 1, 500, 0, '2023-05-22'),
(4, 36, 158, 'small', 20, 1, 20, 1, '2023-05-22');

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
  `mobile` varchar(11) NOT NULL,
  `email` text NOT NULL,
  `user_role` text NOT NULL,
  `user_status` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `counterlock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userid`, `fullname`, `username`, `password`, `address`, `mobile`, `email`, `user_role`, `user_status`, `date_created`, `counterlock`) VALUES
(151, 'awwa', 'lk', 'd0fa06cd93335c8cae357ffe5cd1c4e9', 'qwe', '0922236451', 'wa@gmail.com', '2', 1, '2023-05-18 17:35:25', 0),
(154, 'asd sadas', 'qa', '8264ee52f589f4c0191aa94f87aa1aeb', 'f', '090909', 'asdasd@gmail.com', '2', 1, '2023-05-18 17:41:54', 0),
(155, 'asd sadas', 'qwq', 'a078b88157431887516448c823118d83', 'f', '21312', 'asdasd@gmail.com', '2', 1, '2023-05-18 18:46:51', 0),
(157, 'asd sadas', 'fd', '36eba1e1e343279857ea7f69a597324e', 'f', '21312', 'asdasd@gmail.com', '1', 1, '2023-05-19 16:29:07', 1),
(158, 'testtest', 'test', '202cb962ac59075b964b07152d234b70', 'asdasad', '123123123', 'test@123', '2', 1, '2023-05-20 19:06:44', 0),
(159, 'test1', 'test1', '202cb962ac59075b964b07152d234b70', 'test1', '131231', 'test1@asdasd', '2', 1, '2023-05-26 09:29:19', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_customize`
--
ALTER TABLE `tbl_customize`
  ADD PRIMARY KEY (`reserveid`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `tbl_reserved`
--
ALTER TABLE `tbl_reserved`
  ADD PRIMARY KEY (`reserved_id`);

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
-- AUTO_INCREMENT for table `tbl_customize`
--
ALTER TABLE `tbl_customize`
  MODIFY `reserveid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_reserved`
--
ALTER TABLE `tbl_reserved`
  MODIFY `reserved_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
