-- phpMyAdmin SQL Dump

--
-- Database: `calestor1`
--
CREATE DATABASE IF NOT EXISTS `calestor1` DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;
USE `calestor1`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `SelectAllProductTagFromProduct`$$
CREATE DEFINER=`155227`@`%` PROCEDURE `SelectAllProductTagFromProduct` 
(IN `id` INT(11))  READS SQL DATA
SELECT * FROM product_tags where product_tags.product_id = id$$

DROP PROCEDURE IF EXISTS `SelectAllRequestTagFromRequest`$$
CREATE DEFINER=`155227`@`%` PROCEDURE `SelectAllRequestTagFromRequest` 
(IN `id` INT(11))  READS SQL DATA
SELECT * FROM request_tags left outer join tags 
on request_tags.tag_id=tags.tag_id where request_id = id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `businessunit`
--

DROP TABLE IF EXISTS `businessunit`;
CREATE TABLE `businessunit` (
  `bu_id` int(11) NOT NULL,
  `bu_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_designation` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE `forms` (
  `form_id` int(11) NOT NULL,
  `form_bu` int(11) NOT NULL,
  `form_category` int(11) NOT NULL,
  `form_name` varchar(50) NOT NULL,
  `form_designation` varchar(100) NOT NULL,
  `form_searchtype` int(11) NOT NULL,
  `form_validated` tinyint(1) NOT NULL,
  `form_user_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `headers`
--

DROP TABLE IF EXISTS `headers`;
CREATE TABLE `headers` (
  `header_id` int(11) NOT NULL,
  `header_bu` int(11) NOT NULL,
  `header_form` int(11) NOT NULL,
  `header_position` tinyint(2) NOT NULL,
  `header_designation` varchar(50) NOT NULL,
  `header_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_ean` varchar(13) NOT NULL,
  `product_ref` varchar(50) NOT NULL,
  `product_builder_ref` varchar(50) NOT NULL,
  `product_bu` int(11) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_builder` varchar(50) NOT NULL,
  `product_model` varchar(50) NOT NULL,
  `product_designation` varchar(200) NOT NULL,
  `product_user_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products_import`
--

DROP TABLE IF EXISTS `products_import`;
CREATE TABLE `products_import` (
  `product_imp_id` int(11) NOT NULL,
  `product_imp_builder_ref` varchar(50) NOT NULL,
  `product_imp_ref` varchar(25) NOT NULL,
  `product_imp_four` varchar(50) NOT NULL,
  `product_imp_ean` varchar(13) NOT NULL,
  `product_imp_builder` varchar(50) NOT NULL,
  `product_imp_model` varchar(50) NOT NULL,
  `product_imp_designation` varchar(200) NOT NULL,
  `product_imp_category` varchar(10) NOT NULL,
  `product_imp_bu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

DROP TABLE IF EXISTS `product_tags`;
CREATE TABLE `product_tags` (
  `product_tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `product_tag_value` varchar(20) DEFAULT NULL,
  `product_tag_numeric` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `request_header` int(11) NOT NULL,
  `request_order` tinyint(2) NOT NULL,
  `request_name` varchar(50) NOT NULL,
  `request_libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_tags`
--

DROP TABLE IF EXISTS `request_tags`;
CREATE TABLE `request_tags` (
  `request_tag_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `request_tag_sign` char(3) NOT NULL,
  `request_tag_value` varchar(50) DEFAULT NULL,
  `request_tag_numeric` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `searchtypes`
--

DROP TABLE IF EXISTS `searchtypes`;
CREATE TABLE `searchtypes` (
  `searchtype_id` int(11) NOT NULL,
  `searchtype_name` varchar(50) NOT NULL,
  `searchtype_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `signs`
--

DROP TABLE IF EXISTS `signs`;
CREATE TABLE `signs` (
  `sign` char(3) NOT NULL,
  `sign_ESC` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_bu` int(11) NOT NULL,
  `tag_name` varchar(25) NOT NULL,
  `tag_designation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_pseudo` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(145) NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_default_bu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `businessunit`
--
ALTER TABLE `businessunit`
  ADD PRIMARY KEY (`bu_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`form_id`),
  ADD UNIQUE KEY `FORM_BU_NAME_IDX` (`form_bu`,`form_name`),
  ADD KEY `FORM_BU_IDX` (`form_bu`) USING BTREE,
  ADD KEY `FORM_CATEGORY_IDX` (`form_category`),
  ADD KEY `FORM_SEARCHTYPE_IDX` (`form_searchtype`),
  ADD KEY `FORM_USER_CREATE_IDX` (`form_user_create`) USING BTREE;

--
-- Indexes for table `headers`
--
ALTER TABLE `headers`
  ADD PRIMARY KEY (`header_id`),
  ADD KEY `HEADER_BU_IDX` (`header_bu`) USING BTREE,
  ADD KEY `HEADER_FORM_IDX` (`header_form`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `PRODUCT_CATEGORY_IDX` (`product_category`),
  ADD KEY `PRODUCT_BU_IDX` (`product_bu`),
  ADD KEY `PRODUCT_EAN_IDX` (`product_ean`) USING BTREE,
  ADD KEY `product_user_create` (`product_user_create`);

--
-- Indexes for table `products_import`
--
ALTER TABLE `products_import`
  ADD PRIMARY KEY (`product_imp_id`),
  ADD UNIQUE KEY `PRODUCT_REF_BUILDER_IDX` (`product_imp_builder_ref`) 
USING BTREE;

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`product_tag_id`),
  ADD UNIQUE KEY `product_tag_idx` (`product_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `request_header_idx` (`request_header`);

--
-- Indexes for table `request_tags`
--
ALTER TABLE `request_tags`
  ADD PRIMARY KEY (`request_tag_id`),
  ADD UNIQUE KEY `REQUEST_TAG_ID` (`request_id`,`tag_id`) USING BTREE,
  ADD KEY `REQUEST_TAG_SIGN_IDX` (`request_tag_sign`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `searchtypes`
--
ALTER TABLE `searchtypes`
  ADD PRIMARY KEY (`searchtype_id`);

--
-- Indexes for table `signs`
--
ALTER TABLE `signs`
  ADD PRIMARY KEY (`sign`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `TAG_BU_IDX` (`tag_bu`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `PSEUDO_IDX` (`user_pseudo`) USING BTREE,
  ADD KEY `USER_ROLE_IDX` (`user_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `businessunit`
--
ALTER TABLE `businessunit`
  MODIFY `bu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `headers`
--
ALTER TABLE `headers`
  MODIFY `header_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_import`
--
ALTER TABLE `products_import`
  MODIFY `product_imp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `product_tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_tags`
--
ALTER TABLE `request_tags`
  MODIFY `request_tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `searchtypes`
--
ALTER TABLE `searchtypes`
  MODIFY `searchtype_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_2` FOREIGN KEY (`form_category`) 
REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `forms_ibfk_3` FOREIGN KEY (`form_searchtype`) 
REFERENCES `searchtypes` (`searchtype_id`),
  ADD CONSTRAINT `forms_ibfk_4` FOREIGN KEY (`form_user_create`) 
REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `forms_ibfk_5` FOREIGN KEY (`form_bu`) 
REFERENCES `businessunit` (`bu_id`);

--
-- Constraints for table `headers`
--
ALTER TABLE `headers`
  ADD CONSTRAINT `headers_ibfk_1` FOREIGN KEY (`header_form`) 
REFERENCES `forms` (`form_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_bu`) 
REFERENCES `businessunit` (`bu_id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`product_user_create`) 
REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`product_category`) 
REFERENCES `categories` (`category_id`);

--
-- Constraints for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_3` FOREIGN KEY (`product_id`) 
REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_4` FOREIGN KEY (`tag_id`) 
REFERENCES `tags` (`tag_id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`request_header`) 
REFERENCES `headers` (`header_id`) ON DELETE CASCADE;

--
-- Constraints for table `request_tags`
--
ALTER TABLE `request_tags`
  ADD CONSTRAINT `request_tags_ibfk_2` FOREIGN KEY (`request_tag_sign`) 
REFERENCES `signs` (`sign`),
  ADD CONSTRAINT `request_tags_ibfk_4` FOREIGN KEY (`tag_id`) 
REFERENCES `tags` (`tag_id`),
  ADD CONSTRAINT `request_tags_ibfk_5` FOREIGN KEY (`request_id`) 
REFERENCES `request` (`request_id`) ON DELETE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`tag_bu`) 
REFERENCES `businessunit` (`bu_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role`) 
REFERENCES `roles` (`role_id`);
COMMIT;
