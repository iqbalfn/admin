DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150),
    `slug` VARCHAR(150),
    `cover` VARCHAR(150),
    `content` TEXT,
    `address` TEXT,
    `location` VARCHAR(250),
    `date` DATETIME,
    
    `seo_schema` VARCHAR(25),
    `seo_title` VARCHAR(160),
    `seo_description` TEXT,
    `seo_keywords` TEXT,
    
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `name` VARCHAR(50),
    `media` VARCHAR(150),
    `code` TEXT,
    `link` VARCHAR(150),
    `expired` DATETIME,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `name` VARCHAR(50),
    `cover` VARCHAR(150),
    `description` TEXT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `gallery_media`;
CREATE TABLE `gallery_media` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `gallery` BIGINT,
    `media` VARCHAR(150),
    `media_label` VARCHAR(150),
    `title` VARCHAR(150),
    `description` TEXT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `original_name` VARCHAR(150),
    `name` VARCHAR(50),
    `path` VARCHAR(75),
    `type` VARCHAR(100),
    `object` BIGINT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150),
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `content` TEXT,
    
    `seo_schema` VARCHAR(25),
    `seo_title` VARCHAR(160),
    `seo_description` TEXT,
    `seo_keywords` TEXT,
    
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- POST --
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `publisher` BIGINT,
    `title` VARCHAR(150),
    `slug` VARCHAR(150),
    `cover` VARCHAR(150),
    `cover_label` VARCHAR(200),
    `embed` TEXT,
    `gallery` BIGINT,
    `content` TEXT,
    `instant_content` TEXT,
    `location` VARCHAR(200),
    `status` TINYINT DEFAULT 1,
    `featured` BOOLEAN DEFAULT FALSE,
    `editor_pick` BOOLEAN DEFAULT FALSE,
    `sources` TEXT,
    
    `seo_title` VARCHAR(150),
    `seo_schema` VARCHAR(25),
    `seo_description` TEXT,
    `seo_keywords` TEXT,
    `ga_group` VARCHAR(50),
    
    `updated` DATETIME,
    `published` DATETIME,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_category`;
CREATE TABLE `post_category` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(25),
    `slug` VARCHAR(25) NOT NULL UNIQUE,
    `parent` INTEGER DEFAULT 0,
    `user` BIGINT NOT NULL,
    `description` TEXT,
    
    `seo_schema` VARCHAR(25),
    `seo_title` VARCHAR(150),
    `seo_description` TEXT,
    `seo_keywords` TEXT,
    
    `posts` INTEGER DEFAULT 0,
    
    `updated` DATETIME,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_category_chain`;
CREATE TABLE `post_category_chain` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post_category` INTEGER NOT NULL,
    `post` BIGINT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_schedule`;
CREATE TABLE `post_schedule` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post` BIGINT NOT NULL,
    `published` DATETIME NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_selection`;
CREATE TABLE `post_selection` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `group` VARCHAR(50),
    `post` BIGINT NOT NULL,
    `index` TINYINT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_statistic`;
CREATE TABLE `post_statistic` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post` BIGINT NOT NULL UNIQUE,
    `pageviews` INTEGER DEFAULT 0,
    `sessions` INTEGER DEFAULT 0,
    `users` INTEGER DEFAULT 0,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_suggestion`;
CREATE TABLE `post_suggestion` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150),
    `source` VARCHAR(250),
    `local` VARCHAR(250),
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_tag`;
CREATE TABLE `post_tag` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50),
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `user` BIGINT NOT NULL,
    `description` TEXT,
    
    `seo_schema` VARCHAR(25),
    `seo_title` VARCHAR(150),
    `seo_description` TEXT,
    `seo_keywords` TEXT,
    
    `posts` INTEGER DEFAULT 0,
    
    `updated` DATETIME,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_tag_chain`;
CREATE TABLE `post_tag_chain` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post_tag` INTEGER NOT NULL,
    `post` BIGINT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `post_trending`;
CREATE TABLE `post_trending` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post` BIGINT NOT NULL,
    `tag` INTEGER,
    `category` INTEGER,
    `view` INTEGER DEFAULT 0,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SITE SYSTEM --
DROP TABLE IF EXISTS `site_menu`;
CREATE TABLE `site_menu` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `group` VARCHAR(25),
    `label` VARCHAR(50),
    `url` VARCHAR(200),
    `parent` INTEGER,
    `index` TINYINT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `site_params`;
CREATE TABLE `site_params` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `value` TEXT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `site_ranks`;
CREATE TABLE `site_ranks` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `vendor` VARCHAR(50),
    `rank_international` INTEGER DEFAULT 0,
    `rank_local` INTEGER DEFAULT 0,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `site_enum`;
CREATE TABLE `site_enum` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `group` VARCHAR(50),
    `value` VARCHAR(50),
    `label` VARCHAR(25),
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- OTHERWISE --
DROP TABLE IF EXISTS `slideshow`;
CREATE TABLE `slideshow` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `group` VARCHAR(50),
    `index` SMALLINT,
    `image` VARCHAR(125),
    `title` VARCHAR(100),
    `link` VARCHAR(120),
    `description` TEXT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `url_redirection`;
CREATE TABLE `url_redirection` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `source` VARCHAR(250),
    `target` VARCHAR(250),
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SYSTEM USER --
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(25) NOT NULL UNIQUE,
    `fullname` VARCHAR(50),
    `password` VARCHAR(125),
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `avatar` VARCHAR(100),
    `about` TEXT,
    `website` VARCHAR(125),
    `status` TINYINT DEFAULT 2,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `user_perms`;
CREATE TABLE `user_perms` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `perms` VARCHAR(50),
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `user_session`;
CREATE TABLE `user_session` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `hash` VARCHAR(150) NOT NULL UNIQUE,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `perms`;
CREATE TABLE `perms` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `worker` VARCHAR(150),
    `group` VARCHAR(25),
    `name` VARCHAR(50),
    `label` VARCHAR(50),
    `description` TEXT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);