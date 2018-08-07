    -- phpMyAdmin SQL Dump
    -- version 4.7.9
    -- https://www.phpmyadmin.net/

    SET FOREIGN_KEY_CHECKS=0;
    SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
    SET AUTOCOMMIT = 0;
    START TRANSACTION;
    SET time_zone = "+00:00";
    
    CREATE DATABASE IF NOT EXISTS `calestor1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
    USE `calestor1`;

    DROP TABLE IF EXISTS `businessunit`;
    CREATE TABLE IF NOT EXISTS `businessunit` (
      `bu_id` int(11) NOT NULL AUTO_INCREMENT,
      `bu_name` varchar(50) NOT NULL,
      PRIMARY KEY (`bu_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    DROP TABLE IF EXISTS `categories`;
    CREATE TABLE IF NOT EXISTS `categories` (
      `category_id` int(11) NOT NULL AUTO_INCREMENT,
      `category_name` varchar(50) NOT NULL,
      `category_designation` varchar(200) NOT NULL,
      PRIMARY KEY (`category_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    DROP TABLE IF EXISTS `forms`;
    CREATE TABLE IF NOT EXISTS `forms` (
      `form_id` int(11) NOT NULL AUTO_INCREMENT,
      `form_bu` int(11) NOT NULL,
      `form_category` int(11) NOT NULL,
      `form_name` varchar(50) NOT NULL,
      `form_designation` varchar(100) NOT NULL,
      `form_searchtype` int(11) NOT NULL,
      `form_validated` tinyint(1) NOT NULL,
      `form_user_create` int(11) NOT NULL,
      PRIMARY KEY (`form_id`),
      UNIQUE KEY `FORM_BU_NAME_IDX` (`form_bu`,`form_name`),
      KEY `FORM_BU_IDX` (`form_bu`) USING BTREE,
      KEY `FORM_CATEGORY_IDX` (`form_category`),
      KEY `FORM_SEARCHTYPE_IDX` (`form_searchtype`),
      KEY `FORM_USER_CREATE_IDX` (`form_user_create`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `headers`;
CREATE TABLE IF NOT EXISTS `headers` (
  `header_id` int(11) NOT NULL AUTO_INCREMENT,
  `header_bu` int(11) NOT NULL,
  `header_form` int(11) NOT NULL,
  `header_position` tinyint(2) NOT NULL,
  `header_designation` varchar(50) NOT NULL,
  `header_name` varchar(25) NOT NULL,
  PRIMARY KEY (`header_id`),
  KEY `HEADER_BU_IDX` (`header_bu`) USING BTREE,
  KEY `HEADER_FORM_IDX` (`header_form`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `headers`:
--   `header_form`
--       `forms` -> `form_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_ean` varchar(13) NOT NULL,
  `product_ref` varchar(50) NOT NULL,
  `product_builder_ref` varchar(50) NOT NULL,
  `product_bu` int(11) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_builder` varchar(50) NOT NULL,
  `product_model` varchar(50) NOT NULL,
  `product_designation` varchar(200) NOT NULL,
  `product_user_create` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `PRODUCT_CATEGORY_IDX` (`product_category`),
  KEY `PRODUCT_BU_IDX` (`product_bu`),
  KEY `PRODUCT_EAN_IDX` (`product_ean`) USING BTREE,
  KEY `product_user_create` (`product_user_create`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `products`:
--   `product_bu`
--       `businessunit` -> `bu_id`
--   `product_user_create`
--       `users` -> `user_id`
--   `product_category`
--       `categories` -> `category_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `products_import`
--

DROP TABLE IF EXISTS `products_import`;
CREATE TABLE IF NOT EXISTS `products_import` (
  `product_imp_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_imp_builder_ref` varchar(50) NOT NULL,
  `product_imp_ref` varchar(25) NOT NULL,
  `product_imp_four` varchar(50) NOT NULL,
  `product_imp_ean` varchar(13) NOT NULL,
  `product_imp_builder` varchar(50) NOT NULL,
  `product_imp_model` varchar(50) NOT NULL,
  `product_imp_designation` varchar(200) NOT NULL,
  `product_imp_category` varchar(10) NOT NULL,
  `product_imp_bu` int(11) NOT NULL,
  PRIMARY KEY (`product_imp_id`),
  UNIQUE KEY `PRODUCT_REF_BUILDER_IDX` (`product_imp_builder_ref`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `products_import`:
--

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

DROP TABLE IF EXISTS `product_tags`;
CREATE TABLE IF NOT EXISTS `product_tags` (
  `product_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `product_tag_value` varchar(20) DEFAULT NULL,
  `product_tag_numeric` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_tag_id`),
  UNIQUE KEY `product_tag_idx` (`product_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `product_tags`:
--   `product_id`
--       `products` -> `product_id`
--   `tag_id`
--       `tags` -> `tag_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_header` int(11) NOT NULL,
  `request_order` tinyint(2) NOT NULL,
  `request_name` varchar(50) NOT NULL,
  `request_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `request_header_idx` (`request_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `request`:
--   `request_header`
--       `headers` -> `header_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `request_tags`
--

DROP TABLE IF EXISTS `request_tags`;
CREATE TABLE IF NOT EXISTS `request_tags` (
  `request_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `request_tag_sign` char(3) NOT NULL,
  `request_tag_value` varchar(50) DEFAULT NULL,
  `request_tag_numeric` int(11) DEFAULT NULL,
  PRIMARY KEY (`request_tag_id`),
  UNIQUE KEY `REQUEST_TAG_ID` (`request_id`,`tag_id`) USING BTREE,
  KEY `REQUEST_TAG_SIGN_IDX` (`request_tag_sign`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `request_tags`:
--   `request_tag_sign`
--       `signs` -> `sign`
--   `request_id`
--       `request` -> `request_id`
--   `tag_id`
--       `tags` -> `tag_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_type` varchar(10) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `roles`:
--

-- --------------------------------------------------------

--
-- Table structure for table `searchtypes`
--

DROP TABLE IF EXISTS `searchtypes`;
CREATE TABLE IF NOT EXISTS `searchtypes` (
  `searchtype_id` int(11) NOT NULL AUTO_INCREMENT,
  `searchtype_name` varchar(50) NOT NULL,
  `searchtype_description` varchar(200) NOT NULL,
  PRIMARY KEY (`searchtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `searchtypes`:
--

-- --------------------------------------------------------

--
-- Table structure for table `signs`
--

DROP TABLE IF EXISTS `signs`;
CREATE TABLE IF NOT EXISTS `signs` (
  `sign` char(3) NOT NULL,
  `sign_ESC` varchar(5) NOT NULL,
  PRIMARY KEY (`sign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `signs`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_bu` int(11) NOT NULL,
  `tag_name` varchar(25) NOT NULL,
  `tag_designation` varchar(50) NOT NULL,
  PRIMARY KEY (`tag_id`),
  KEY `TAG_BU_IDX` (`tag_bu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tags`:
--   `tag_bu`
--       `businessunit` -> `bu_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_pseudo` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(145) NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_default_bu` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `PSEUDO_IDX` (`user_pseudo`) USING BTREE,
  KEY `USER_ROLE_IDX` (`user_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `users`:
--   `user_role`
--       `roles` -> `role_id`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_2` FOREIGN KEY (`form_category`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `forms_ibfk_3` FOREIGN KEY (`form_searchtype`) REFERENCES `searchtypes` (`searchtype_id`),
  ADD CONSTRAINT `forms_ibfk_4` FOREIGN KEY (`form_user_create`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `forms_ibfk_5` FOREIGN KEY (`form_bu`) REFERENCES `businessunit` (`bu_id`);

--
-- Constraints for table `headers`
--
ALTER TABLE `headers`
  ADD CONSTRAINT `headers_ibfk_1` FOREIGN KEY (`header_form`) REFERENCES `forms` (`form_id`) ON DELETE CASCADE;

--
    -- Constraints for table `products`

    ALTER TABLE `products`
      ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_bu`) 
                REFERENCES `businessunit` (`bu_id`),
      ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`product_user_create`) 
                REFERENCES `users` (`user_id`),
      ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`product_category`) 
                REFERENCES `categories` (`category_id`);
    
    -- Constraints for table `tags`
   
    ALTER TABLE `tags`
          ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`tag_bu`) 
                REFERENCES `businessunit` (`bu_id`);
          
    -- Constraints for table `product_tags`
   
    ALTER TABLE `product_tags`
      ADD CONSTRAINT `product_tags_ibfk_3` FOREIGN KEY (`product_id`) 
                REFERENCES `products` (`product_id`) ON DELETE CASCADE,
      ADD CONSTRAINT `product_tags_ibfk_4` FOREIGN KEY (`tag_id`) 
                REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

    --
    -- Constraints for table `request`
    --
    ALTER TABLE `request`
      ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`request_header`) REFERENCES `headers` (`header_id`) ON DELETE CASCADE;

    --
    -- Constraints for table `request_tags`
    --
    ALTER TABLE `request_tags`
      ADD CONSTRAINT `request_tags_ibfk_2` FOREIGN KEY (`request_tag_sign`) REFERENCES `signs` (`sign`),
      ADD CONSTRAINT `request_tags_ibfk_5` FOREIGN KEY (`request_id`) REFERENCES `request` (`request_id`) ON DELETE CASCADE,
      ADD CONSTRAINT `request_tags_ibfk_6` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

    --
-- Constraints for table `tags`
--
    ALTER TABLE `tags`
      ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`tag_bu`) REFERENCES `businessunit` (`bu_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role`) REFERENCES `roles` (`role_id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;


    DELIMITER $$
    CREATE DEFINER=`155227`@`%` PROCEDURE `DeleteProductImport`(IN `id` INT(11))
        MODIFIES SQL DATA
    DELETE FROM products_import WHERE product_imp_id =id$$
    DELIMITER ;

    DELIMITER $$
    CREATE DEFINER=`155227`@`%` PROCEDURE `SelectAllProductTagFromProduct`(IN `id` INT(11))
        READS SQL DATA
    SELECT * FROM product_tags where product_tags.product_id = id$$
    DELIMITER ;

    DELIMITER $$
    CREATE DEFINER=`155227`@`%` PROCEDURE `isExistBuilderRef`(IN `id` INT(11))
        MODIFIES SQL DATA
    SELECT * FROM products WHERE product_builder_ref = id$$
    DELIMITER ;

    DELIMITER $$
    CREATE DEFINER=`155227`@`%` PROCEDURE `InsertProductImp`(IN `p_product_imp_builder_ref` 
    VARCHAR(50),
    IN `p_product_imp_ref` VARCHAR(25), IN `p_product_imp_four` VARCHAR(50), 
    IN `p_product_imp_ean` CHAR(13), IN `p_product_imp_builder` VARCHAR(50), 
    IN `p_product_imp_model` VARCHAR(50), IN `p_product_imp_designation` VARCHAR(200), 
    IN `p_product_imp_category` INT(11), IN `p_product_imp_bu` INT(11))
        MODIFIES SQL DATA
    INSERT INTO products_import (product_imp_builder_ref, product_imp_ref, 
    product_imp_four, product_imp_ean, product_imp_builder, product_imp_model, 
    product_imp_designation, product_imp_category, product_imp_bu) 
    VALUES(p_product_imp_builder_ref, p_product_imp_ref, p_product_imp_four, 
    p_product_imp_ean, p_product_imp_builder, p_product_imp_model, 
    p_product_imp_designation, p_product_imp_category, p_product_imp_bu)$$
    DELIMITER ;

    DELIMITER $$
    CREATE DEFINER=`155227`@`%` PROCEDURE `SelectAllRequestTagFromRequest`(IN `id` INT)
        READS SQL DATA
    SELECT * FROM request_tags left outer join tags on request_tags.tag_id=tags.tag_id 
    WHERE request_id = id$$
    DELIMITER ;

    DELIMITER $$
    CREATE DEFINER=`155227`@`%` PROCEDURE `isExistBuilderRefImp`(IN `id` INT(11))
        MODIFIES SQL DATA
    SELECT * FROM products_import WHERE product_imp_builder_ref = id$$
    DELIMITER ;
