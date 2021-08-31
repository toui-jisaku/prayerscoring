-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2021 年 8 月 31 日 06:47
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: ` scoring`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `goods`
--

CREATE TABLE `goods` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `photo_id` int(32) NOT NULL COMMENT 'フォトID',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `goods`
--

INSERT INTO `goods` (`id`, `user_id`, `photo_id`, `created_at`, `updated_at`) VALUES
(53, 10, 24, '2021-07-29 09:59:14', '2021-07-29 09:59:14'),
(54, 17, 25, '2021-07-29 14:09:22', '2021-07-29 14:09:22'),
(56, 18, 25, '2021-08-05 16:32:32', '2021-08-05 16:32:32');

-- --------------------------------------------------------

--
-- テーブルの構造 `photos`
--

CREATE TABLE `photos` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `genre` varchar(32) NOT NULL COMMENT 'ジャンル',
  `comment` varchar(512) DEFAULT NULL COMMENT 'コメント',
  `file_name` varchar(255) NOT NULL COMMENT 'ファイル名',
  `file_path` varchar(255) NOT NULL COMMENT 'ファイルパス',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `photos`
--

INSERT INTO `photos` (`id`, `genre`, `comment`, `file_name`, `file_path`, `created_at`, `updated_at`) VALUES
(24, '選手', 'イケメン', 'イニエスタ.jpeg', 'img2/20210726135433イニエスタ.jpeg', '2021-07-26 22:54:48', '2021-07-26 22:54:48'),
(25, '監督', 'かっこいい', 'ロナウジーニョ.jpeg', 'img2/20210729041716ロナウジーニョ.jpeg', '2021-07-29 13:17:19', '2021-07-29 13:23:07'),
(27, 'その他', '胸筋最高', 'ゴリラ.jpeg', 'img2/20210805043813ゴリラ.jpeg', '2021-08-05 13:38:15', '2021-08-05 13:38:15');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'ユーザーネーム',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `role` int(32) NOT NULL DEFAULT '0' COMMENT '権限',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `update_at`) VALUES
(10, 'ちょび', 'test@test', '$2y$10$nv3D3h/LWgM4allPlzFxvOyw3HkAYqi1TCsCBSDVQm1Esm5TAwI8O', 1, '2021-07-26 13:57:01', '2021-07-29 10:31:38'),
(12, 'ホリエモン', 'aaa@aaa', '$2y$10$xV1pHEMV63duG9.4v1gvfOeHwVLpwIURYY5td6F3lrNzs1k/Wd8.q', 0, '2021-07-26 21:47:58', '2021-07-26 21:47:58'),
(17, '山田', 'sss@sss', '$2y$10$Otmd8L9ZWyV4kVgrkvhs1egGLEgnDKnru4gtxLkeR9sQ7DyWfO50.', 0, '2021-07-29 13:23:41', '2021-07-29 13:23:41'),
(18, 'たかし', 'ddd@ddd', '$2y$10$8TsBoFuUYhVZuegI0MVgAOR2sDd/chK5CNotacF5j7w7SzP508tJi', 0, '2021-08-05 13:36:01', '2021-08-05 13:36:01');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_photos`
--

CREATE TABLE `users_photos` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `photo_id` int(32) NOT NULL COMMENT 'フォトID',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users_photos`
--

INSERT INTO `users_photos` (`id`, `user_id`, `photo_id`, `created_at`, `updated_at`) VALUES
(29, 12, 24, '2021-07-26 22:54:48', '2021-07-26 22:54:48'),
(30, 12, 25, '2021-07-29 13:17:19', '2021-07-29 13:17:19'),
(31, 12, 0, '2021-07-29 13:18:19', '2021-07-29 13:18:19'),
(32, 12, 0, '2021-07-29 13:23:07', '2021-07-29 13:23:07'),
(34, 17, 0, '2021-07-29 14:06:18', '2021-07-29 14:06:18'),
(35, 17, 0, '2021-07-29 14:31:09', '2021-07-29 14:31:09'),
(36, 18, 27, '2021-08-05 13:38:15', '2021-08-05 13:38:15');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users_photos`
--
ALTER TABLE `users_photos`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=57;

--
-- テーブルの AUTO_INCREMENT `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `users_photos`
--
ALTER TABLE `users_photos`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
