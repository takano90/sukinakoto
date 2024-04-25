CREATE DATABASE IF NOT EXISTS sample CHARACTER SET utf8;

USE sample;

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投稿番号',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '投稿者名',
  `contents` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '投稿内容',
  `created_at` datetime DEFAULT NULL COMMENT '登録日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT = '投稿情報';
