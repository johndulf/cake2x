-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2023 at 09:41 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getAllDeletedUsers` (IN `p_user_id` INT)   BEGIN
	if p_user_id = 0 THEN
    	SELECT * FROM deleted_users;
    ELSE
    	SELECT * FROM deleted_users WHERE userid = p_user_id;
    end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getAllUser` (IN `p_user_id` INT)   BEGIN
	if p_user_id = 0 THEN
    	SELECT * FROM tbl_users;
    ELSE
    	SELECT * FROM tbl_users WHERE userid = p_user_id;
    end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getCart` (IN `p_user_id` INT)   BEGIN
    SELECT c.cart_id, c.user_id, c.product_id, c.quantity, c.price, p.productname, p.description
    FROM tbl_cart c
    JOIN tbl_products p ON c.product_id = p.productid
    WHERE c.user_id = p_user_id;
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

DECLARE ret INT;
DECLARE stat INT;
DECLARE c_lock INT;

IF EXISTS(SELECT * FROM tbl_users WHERE username = pusername AND password = ppassword) THEN

    SET stat = (SELECT user_status FROM tbl_users WHERE username = pusername AND password = password);
    SET c_lock = (SELECT counterlock FROM tbl_users WHERE username = pusername AND password = password);
    
    IF stat = 1 THEN
        IF c_lock >= 3 THEN
            SET ret = 4;
            SELECT ret;
        ELSE
            SET ret = 1;
            SELECT *, ret FROM tbl_users WHERE username = pusername AND password = ppassword;
            -- Reset the counterlock to 0
            UPDATE tbl_users SET counterlock = 0 WHERE username = pusername;
        END IF;
    ELSE
        SET ret = 2; 
        SELECT ret;
    END IF;

ELSE

    UPDATE tbl_users SET counterlock = counterlock + 1 WHERE username = pusername;
    SET ret = 3;
    
    SELECT ret;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_save` (IN `p_userid` INT, IN `p_fullname` TEXT, IN `p_username` TEXT, IN `p_password` TEXT, IN `p_address` TEXT, IN `p_mobile` VARCHAR(11), IN `p_email` TEXT)   BEGIN
    DECLARE existing_user_count INT;
    
    IF p_userid = 0 THEN
        SELECT COUNT(*) INTO existing_user_count FROM tbl_users WHERE username = p_username AND password = p_password;
        
        IF existing_user_count = 0 THEN
            INSERT INTO tbl_users (fullname, username, password, address, mobile, email, user_role, user_status, date_created)
            VALUES (p_fullname, p_username, p_password, p_address, p_mobile, p_email, 1, 1, NOW());
        ELSE
            SELECT 'These details are already used by another user.' AS error_message;
        END IF;
    ELSE
        UPDATE tbl_users
        SET fullname = p_fullname, username = p_username, address = p_address, mobile = p_mobile, email = p_email
        WHERE userid = p_userid;
    END IF;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveUpdateCart` (IN `p_cart_id` INT, IN `p_user_id` INT, IN `p_product_id` INT, IN `p_quantity` INT, IN `p_price` INT)   BEGIN
    IF p_cart_id = 0 THEN
        INSERT INTO tbl_cart (user_id, product_id, quantity, price)
        VALUES (p_user_id, p_product_id, p_quantity, p_price);
    ELSE 
        UPDATE tbl_cart
        SET quantity = p_quantity,
            price = p_price
        WHERE cart_id = p_cart_id;
    END IF;
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
        price = p_price
        where productid = p_productid;
       
    end if;
    
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveUpdateReserved` (IN `p_product_id` INT, IN `p_user_id` INT, IN `p_size` TEXT, IN `p_price` INT, IN `p_quantity` INT, IN `p_total` INT, IN `p_status` INT, IN `p_reserved_id` INT)   BEGIN
    IF p_reserved_id = 0 THEN
        IF p_quantity > 0 THEN
            INSERT INTO tbl_reserved (product_id, user_id, size, price, quantity, total, status, date_inserted)
            VALUES (p_product_id, p_user_id, p_size, p_price, p_quantity, p_total, p_status, NOW());
            
            UPDATE tbl_products
            SET quantity = quantity - p_quantity
            WHERE productid = p_product_id;
            
            SELECT 1 AS result;
        ELSE
            SELECT 0 AS result; -- Quantity is zero, indicating out of stock
        END IF;
    ELSE
        UPDATE tbl_reserved
        SET user_id = p_user_id,
            size = p_size,
            price = p_price,
            quantity = p_quantity,
            total = p_total,
            status = p_status
        WHERE reserved_id = p_reserved_id;
        
        UPDATE tbl_products
        SET quantity = quantity - (p_quantity - old_quantity) -- Deduct the difference in quantity
        WHERE productid = p_product_id;
        
        SELECT 1 AS result;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Update` (IN `p_userid` INT, IN `p_fullname` TEXT, IN `p_username` TEXT, IN `p_password` TEXT, IN `p_address` TEXT, IN `p_mobile` TEXT, IN `p_email` TEXT)   BEGIN
    UPDATE tbl_users
    SET
        fullname = p_fullname,
        username = p_username,
        password = p_password,
        address = p_address,
        mobile = p_mobile,
        email = p_email
    WHERE
        userid = p_userid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateCustomize` (IN `p_reserveid` INT, IN `p_userid` INT, IN `p_fullname` TEXT, IN `p_suggestion` TEXT, IN `p_message` TEXT, IN `p_flavor` TEXT, IN `p_size` TEXT, IN `p_mobile` VARCHAR(11), IN `p_image` TEXT, IN `p_quantity` INT, IN `p_date_created` DATE)   BEGIN
	if p_reserveid = 0 THEN
    INSERT INTO tbl_customize(userid,suggestion,message,flavor,size,mobile,quantity,image,date_created,status)
  VALUES(p_userid,p_suggestion,p_message,p_flavor,p_size,p_mobile,p_quantity,p_image,p_date_created,0);
     else 
     	if p_image != "" THEN
     		update tbl_customize SET 
        		userid = p_userid,
            	suggestion = p_suggestion,
            	message = p_message,
            	flavor = p_flavor,
            	size = p_size,
                mobile = p_mobile,
            	image = p_image,
            	quantity = p_quantity,
                date_created = p_date_created,
            	status = 1 WHERE p_reserveid = p_reserveid;
         else 
         update tbl_customize SET 
        		userid = p_userid,
            	suggestion = p_suggestion,
            	message = p_message,
            	flavor = p_flavor,
            	size = p_size,
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
-- Table structure for table `deleted_users`
--

CREATE TABLE `deleted_users` (
  `userid` int(10) UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `fullname` text NOT NULL,
  `address` text NOT NULL,
  `mobile` text NOT NULL,
  `email` text NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 167, 'asdadada', '550', 'Chocolate', 'small', 2333, 550, 128150, 'bg_4.jpg', 1, '2023-05-02'),
(3, 167, 'asdsad', 'asdasd', 'Chocolate', 'small', 12, 250, 3000, 'b1.jpg', 0, '2023-05-01'),
(4, 168, 'awaw', 'dfd', 'Banana', 'medium', 22, 400, 8800, 'b3.jpg', 0, '2023-05-18'),
(5, 161, 'asd', 'asdas', 'Banana', 'medium', 5, 400, 2000, 'cake.jpg', 0, '2023-05-20'),
(6, 161, 'sdfsd', 'sdfsd', 'Banana', 'large', 2, 550, 1100, 'bdcake.webp', 0, '2023-05-25'),
(7, 167, 'fdfd', 'dfdfd', 'StrawBerry', 'large', 22, 550, 12100, 'menu7.jpg', 0, '2023-05-17'),
(8, 170, 'sfsd', 'fsdfsd', 'StrawBerry', 'large', 43, 550, 23650, 'cake2.png', 0, '2023-06-30');

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
(56, 'caramels', 'sweet', 173, '200', 'dish4.jpg', '2023-06-14'),
(59, 'donut', 'sweet', 99, '222', 'b4.jpg', '2023-06-15'),
(62, 'ice cream', 'sweet', 0, '25', 'b1.jpg', '2023-06-15'),
(63, 'White Cake', 'Wedding Cake', 0, '500', 'bg_2.jpg', '2023-06-15'),
(64, 'Cup Cake', 'Chocolate Cake', 199, '15', 'b3.jpg', '2023-06-15'),
(65, 'Birthday Cake', 'celebration ', 35, '500', 'blog-img2.png', '2023-06-15'),
(66, 'fsdf', 'sdf', 110, '220', 'dish5.jpg', '2023-06-15'),
(67, 'asfds', '22', 231, '400', 'menu2.jpg', '2023-06-15'),
(68, 'caramel', '232', 317, '232', 'dish6.jpg', '2023-06-15'),
(69, 'ice cream', '232', 119, '323', 'menu8.jpg', '2023-06-15'),
(70, 'asdfsd', '323', 212, '222', 'cake3.png', '2023-06-15');

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
(90, 64, 161, 'small', 15, 1, 15, 0, '2023-06-17'),
(91, 59, 194, 'small', 222, 1, 222, 0, '2023-06-18');

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
(161, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'f', '21312', 'admin@gmail.com', '2', 1, '2023-05-26 13:04:08', 0),
(163, 'asd sadas', 'atay', 'fc9fdf084e290f26a270390dc49061a2', 'f', '21312', 'asdasd@gmail.com', '1', 1, '2023-05-26 13:04:27', 0),
(164, 'johndulf', 'johndulf', 'e9e6309b77f45e307395481a89658440', 'fsd', '09302381116', 'aw@gmail.com', '1', 1, '2023-05-26 13:19:38', 0),
(179, 'aw aw aw', 'plpl', '0ad7769f602705d0703a3685f5768c7b', 'aw', '09302381116', 'aw@gmail.com', '1', 1, '2023-06-17 12:26:34', 0),
(180, 'aw aw aw', 'plpls', '0ad7769f602705d0703a3685f5768c7b', 'aw', '09302381116', 'aw@gmail.com', '1', 1, '2023-06-17 12:28:22', 0),
(183, 'aw aw aw', 'atay', 'e7d7ca730e5dabd9b10aa096cd736428', 'aw', '09302381116', 'aw@gmail.com', '1', 0, '2023-06-17 12:56:04', 0),
(192, 'sdfsdfsd', 'ffdfdf', '9830e1f81f623b33106acc186b93374e', 'sdfsd', '21312', 'sdfsdfsd@gmail.com', '1', 1, '2023-06-17 21:13:14', 0),
(193, 'asd sadas', 'fd', '36eba1e1e343279857ea7f69a597324e', 'f', '21312', 'asdasd@gmail.com', '1', 1, '2023-06-18 13:18:48', 0),
(198, 'asd sadas', 'pl', '288404204e3d452229308317344a285d', 'f', '21312', 'asdasd@gmail.com', '1', 1, '2023-06-18 15:07:42', 0),
(199, 'asd sadas', 'amaw', '7c9a123b4e7fd5b3c0cb9d647da87e70', 'f', '21312', 'asdasd@gmail.com', '1', 1, '2023-06-18 15:07:59', 0),
(201, 'asd sadas', 'aw', 'b787d22d9cb06342658bf546039117bc', 'f', '21312', 'asdasd@gmail.com', '1', 1, '2023-06-18 15:18:54', 0),
(204, 'asd sadas', 'pq', '382da15dfcfa571b3973cb5ae2223f76', 'f', '21312', 'asdasd@gmail.com', '1', 1, '2023-06-18 15:32:18', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deleted_users`
--
ALTER TABLE `deleted_users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`);

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
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customize`
--
ALTER TABLE `tbl_customize`
  MODIFY `reserveid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `tbl_reserved`
--
ALTER TABLE `tbl_reserved`
  MODIFY `reserved_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
