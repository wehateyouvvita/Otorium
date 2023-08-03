-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2018 at 10:33 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `otorium`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `action` varchar(128) NOT NULL,
  `ip` varchar(1024) NOT NULL,
  `user_agent` varchar(1024) NOT NULL,
  `action_time` int(16) NOT NULL,
  `account_uid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `content` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `colour` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_owned`
--

CREATE TABLE `assets_owned` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `serial` int(11) NOT NULL,
  `whenbought` int(16) NOT NULL,
  `from_user` int(11) DEFAULT NULL,
  `price_brought_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asset_items`
--

CREATE TABLE `asset_items` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `added_on` int(11) NOT NULL,
  `lastupdated` int(11) NOT NULL,
  `who_add` int(11) NOT NULL,
  `who_approve` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=deciding,2=yes,3=no',
  `price` int(11) DEFAULT NULL COMMENT 'null=decide price',
  `onsale` tinyint(1) NOT NULL,
  `limited` tinyint(1) NOT NULL,
  `robloxid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `cur_serial` int(11) NOT NULL,
  `custom_asset` tinyint(1) NOT NULL DEFAULT '0',
  `asset_version` int(11) NOT NULL DEFAULT '1',
  `pkgids` varchar(1024) DEFAULT NULL,
  `pkg_version` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` int(11) NOT NULL,
  `badge_order` int(11) NOT NULL,
  `name` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `pngname` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `badges_owned`
--

CREATE TABLE `badges_owned` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `earnon` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banqueries`
--

CREATE TABLE `banqueries` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `content` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `sent` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `reason` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `when_banned` int(16) NOT NULL,
  `days_banned` int(16) NOT NULL,
  `activated` tinyint(1) NOT NULL,
  `forever` tinyint(1) NOT NULL,
  `who_banned` int(11) NOT NULL,
  `who_unban` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'User who blocked',
  `pid` int(11) NOT NULL COMMENT 'User who is blocked',
  `time_added` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `body_colors`
--

CREATE TABLE `body_colors` (
  `id` int(11) NOT NULL,
  `head` int(11) NOT NULL DEFAULT '24',
  `torso` int(11) NOT NULL DEFAULT '23',
  `left_arm` int(11) NOT NULL DEFAULT '24',
  `right_arm` int(11) NOT NULL DEFAULT '24',
  `left_leg` int(11) NOT NULL DEFAULT '37',
  `right_leg` int(11) NOT NULL DEFAULT '37',
  `uid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_items`
--

CREATE TABLE `catalog_items` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL,
  `creator` int(11) NOT NULL,
  `createdon` int(16) NOT NULL,
  `updatedon` int(16) NOT NULL,
  `cost` int(11) NOT NULL,
  `limited` tinyint(1) NOT NULL,
  `limitedu` tinyint(1) NOT NULL,
  `unique_items` int(11) DEFAULT NULL,
  `sales` int(11) NOT NULL,
  `onsale` tinyint(1) NOT NULL,
  `expireon` int(16) DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  `asset_link` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_info`
--

CREATE TABLE `client_info` (
  `version` varchar(16) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `updateinfo` varchar(2048) NOT NULL,
  `update_url` varchar(64) NOT NULL,
  `filestodelete` varchar(4096) NOT NULL,
  `size` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `minVerReq` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `custom_assets`
--

CREATE TABLE `custom_assets` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL COMMENT 'id of asset',
  `thumbnailurl` text NOT NULL,
  `xml` text NOT NULL,
  `texturelink` text NOT NULL,
  `meshlink` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `custom_char_app`
--

CREATE TABLE `custom_char_app` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `url` mediumtext NOT NULL,
  `add_on` int(11) NOT NULL,
  `upd_on` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discord_tokens`
--

CREATE TABLE `discord_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `uid` int(11) NOT NULL,
  `added_on` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0=verify,1=link'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `error_information`
--

CREATE TABLE `error_information` (
  `id` int(11) NOT NULL,
  `code` varchar(16) NOT NULL,
  `desc1` varchar(32) NOT NULL,
  `desc2` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `poster` int(11) NOT NULL,
  `time_posted` int(11) NOT NULL,
  `topics_id` int(11) NOT NULL,
  `pinned` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `w_d` int(11) DEFAULT NULL COMMENT 'who did the last action (pin,lock,delete)',
  `last_post_date` int(16) NOT NULL,
  `last_poster` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_replies`
--

CREATE TABLE `forum_replies` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `poster` int(11) NOT NULL,
  `message` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `time_posted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE `forum_topics` (
  `id` int(11) NOT NULL,
  `f_order` int(3) NOT NULL,
  `title` varchar(1337) COLLATE utf8_unicode_ci NOT NULL,
  `body` varchar(1337) COLLATE utf8_unicode_ci NOT NULL,
  `poster` varchar(1337) COLLATE utf8_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'accepter',
  `fid` int(11) NOT NULL COMMENT 'accepted',
  `time_added` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'user who sent',
  `sid` int(11) NOT NULL COMMENT 'user sent to',
  `time_added` int(16) NOT NULL,
  `accepted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(62) NOT NULL,
  `description` varchar(256) NOT NULL,
  `creator` int(11) NOT NULL,
  `version` int(1) NOT NULL COMMENT '0=2010,1=2008',
  `image` varchar(256) NOT NULL,
  `image_approved` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=notyet,1=yes,2=denied',
  `port` int(6) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `pingtoken` varchar(16) DEFAULT NULL,
  `lastpingtime` int(11) DEFAULT NULL,
  `eventgame` int(11) DEFAULT NULL COMMENT 'format: title|desc|colouroftitle|colorofbackground',
  `created` int(16) NOT NULL,
  `updated` int(16) NOT NULL,
  `loopback` tinyint(1) NOT NULL,
  `access` int(11) DEFAULT NULL COMMENT '0=open,1=paid,2=friendsonly,3=private',
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `games_owned`
--

CREATE TABLE `games_owned` (
  `id` int(11) NOT NULL COMMENT 'this table is for paid access games',
  `game_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `time_added` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_tokens`
--

CREATE TABLE `game_tokens` (
  `keyvalue` varchar(64) NOT NULL,
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `game_id` int(11) NOT NULL,
  `time_generated` int(15) NOT NULL,
  `used` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `thumbnail` varchar(512) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(8196) NOT NULL,
  `creator` int(11) NOT NULL,
  `when_created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `help_topics`
--

CREATE TABLE `help_topics` (
  `id` int(11) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `text_only_title` varchar(64) NOT NULL,
  `body` mediumtext NOT NULL,
  `who_created` int(11) NOT NULL,
  `when_created` int(11) NOT NULL,
  `last_edited` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `host_tokens`
--

CREATE TABLE `host_tokens` (
  `id` int(11) NOT NULL,
  `keyvalue` varchar(32) NOT NULL,
  `game_id` int(11) NOT NULL,
  `time_generated` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ingame_players`
--

CREATE TABLE `ingame_players` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `last_pinged` int(11) NOT NULL,
  `token_used` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ipblacklist`
--

CREATE TABLE `ipblacklist` (
  `id` int(11) NOT NULL,
  `ip` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `whendate` int(16) NOT NULL,
  `untildate` int(16) NOT NULL,
  `whoUserid` int(16) NOT NULL,
  `whyb` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logged_in_sessions`
--

CREATE TABLE `logged_in_sessions` (
  `id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(256) NOT NULL,
  `useragent` varchar(2048) NOT NULL,
  `when_created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `old_usernames`
--

CREATE TABLE `old_usernames` (
  `id` int(11) NOT NULL,
  `username` varchar(24) NOT NULL,
  `uid` int(11) NOT NULL,
  `when_added` int(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `registered_discord_users`
--

CREATE TABLE `registered_discord_users` (
  `id` int(11) NOT NULL,
  `token_used` varchar(32) NOT NULL,
  `uid` int(11) NOT NULL,
  `did` bigint(32) NOT NULL,
  `added_on` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `render_user`
--

CREATE TABLE `render_user` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rendered` tinyint(1) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `timestamp` int(16) NOT NULL,
  `renderedon` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `maintenance` tinyint(1) NOT NULL,
  `sysMaintenance` tinyint(1) DEFAULT NULL,
  `mtpw` varchar(196) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `blurb` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hello there, world!',
  `cash` bigint(11) NOT NULL DEFAULT '50',
  `last_daily_cash_received` int(16) NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '0' COMMENT '0 = member, 1=mod, 2=admin',
  `com_manager` tinyint(1) NOT NULL DEFAULT '0',
  `verified_hoster` tinyint(1) NOT NULL DEFAULT '0',
  `betatester` tinyint(1) NOT NULL DEFAULT '0',
  `asset_approver` tinyint(1) NOT NULL DEFAULT '0',
  `joindate` int(11) NOT NULL,
  `lastseen` int(11) NOT NULL,
  `theme` int(11) NOT NULL DEFAULT '0',
  `accentColor` varchar(6) NOT NULL DEFAULT '50596c',
  `glow` tinyint(1) NOT NULL DEFAULT '0',
  `regIP` varchar(1024) NOT NULL,
  `curIP` varchar(1024) NOT NULL,
  `letter` varchar(1) DEFAULT NULL,
  `verifycode` varchar(64) DEFAULT NULL,
  `verifytype` int(11) DEFAULT NULL COMMENT '1=account',
  `verifysent` int(16) DEFAULT NULL COMMENT 'whencodesent',
  `account_verified` tinyint(1) NOT NULL,
  `donated` int(11) NOT NULL DEFAULT '0',
  `when_donated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `msgs` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=everyone,2=friends',
  `wcsyp` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'who can see your profile (1=everyone,2=friends)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wearing_items`
--

CREATE TABLE `wearing_items` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `itemtype` int(11) NOT NULL,
  `when_worn` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_owned`
--
ALTER TABLE `assets_owned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_items`
--
ALTER TABLE `asset_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `robloxid` (`robloxid`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `badges_owned`
--
ALTER TABLE `badges_owned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banqueries`
--
ALTER TABLE `banqueries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `body_colors`
--
ALTER TABLE `body_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_items`
--
ALTER TABLE `catalog_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_info`
--
ALTER TABLE `client_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_assets`
--
ALTER TABLE `custom_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_char_app`
--
ALTER TABLE `custom_char_app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discord_tokens`
--
ALTER TABLE `discord_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `error_information`
--
ALTER TABLE `error_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_replies`
--
ALTER TABLE `forum_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games_owned`
--
ALTER TABLE `games_owned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_tokens`
--
ALTER TABLE `game_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_topics`
--
ALTER TABLE `help_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `host_tokens`
--
ALTER TABLE `host_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingame_players`
--
ALTER TABLE `ingame_players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipblacklist`
--
ALTER TABLE `ipblacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logged_in_sessions`
--
ALTER TABLE `logged_in_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `old_usernames`
--
ALTER TABLE `old_usernames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_discord_users`
--
ALTER TABLE `registered_discord_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `render_user`
--
ALTER TABLE `render_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wearing_items`
--
ALTER TABLE `wearing_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_owned`
--
ALTER TABLE `assets_owned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_items`
--
ALTER TABLE `asset_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `badges_owned`
--
ALTER TABLE `badges_owned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banqueries`
--
ALTER TABLE `banqueries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `body_colors`
--
ALTER TABLE `body_colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_items`
--
ALTER TABLE `catalog_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_info`
--
ALTER TABLE `client_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_assets`
--
ALTER TABLE `custom_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_char_app`
--
ALTER TABLE `custom_char_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discord_tokens`
--
ALTER TABLE `discord_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `error_information`
--
ALTER TABLE `error_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_replies`
--
ALTER TABLE `forum_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games_owned`
--
ALTER TABLE `games_owned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'this table is for paid access games';

--
-- AUTO_INCREMENT for table `game_tokens`
--
ALTER TABLE `game_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_topics`
--
ALTER TABLE `help_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `host_tokens`
--
ALTER TABLE `host_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingame_players`
--
ALTER TABLE `ingame_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ipblacklist`
--
ALTER TABLE `ipblacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logged_in_sessions`
--
ALTER TABLE `logged_in_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `old_usernames`
--
ALTER TABLE `old_usernames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_discord_users`
--
ALTER TABLE `registered_discord_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `render_user`
--
ALTER TABLE `render_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wearing_items`
--
ALTER TABLE `wearing_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
