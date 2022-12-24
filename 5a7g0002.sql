-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-12-25 00:00:29
-- 伺服器版本： 10.4.27-MariaDB
-- PHP 版本： 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `5a7g0002`
--

-- --------------------------------------------------------

--
-- 資料表結構 `bookstore`
--

CREATE TABLE `bookstore` (
  `book_id` int(10) NOT NULL,
  `book_name` varchar(200) NOT NULL,
  `book_price` int(10) NOT NULL,
  `book_stock` int(10) NOT NULL,
  `book_sales` int(10) NOT NULL,
  `book_txt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `bookstore`
--

INSERT INTO `bookstore` (`book_id`, `book_name`, `book_price`, `book_stock`, `book_sales`, `book_txt`) VALUES
(1, '小王子', 250, 80, 198, 'https://www.kingstone.com.tw/basic/2018760181356/?zone=book&lid=search&actid=WISE&kw=%E5%B0%8F%E7%8E%8B%E5%AD%90'),
(2, '天地一沙鷗', 250, 72, 80, 'https://www.kingstone.com.tw/basic/2018741034008/?zone=book&lid=search&actid=WISE&kw=%E5%A4%A9%E5%9C%B0%E4%B8%80%E6%B2%99%E9%B7%97'),
(3, '卡夫卡變形記', 310, 73, 79, 'https://www.kingstone.com.tw/basic/2800000027143/?zone=ebook&lid=search&actid=WISE&kw=%E5%8D%A1%E5%A4%AB%E5%8D%A1#catalogid'),
(4, '月亮與六便士', 450, 83, 80, 'https://www.kingstone.com.tw/basic/2800000024711/?zone=ebook&lid=search&actid=WISE&kw=%E6%9C%88%E4%BA%AE%E8%88%87'),
(5, '資料庫入門與實作', 580, 82, 81, 'https://www.kingstone.com.tw/basic/2013120621558/?zone=book&lid=search&actid=WISE&kw=%E8%B3%87%E6%96%99%E5%BA%AB'),
(6, '資料結構-使用c語言', 450, 82, 81, 'https://www.kingstone.com.tw/basic/2014713544162/?zone=book&lid=search&actid=WISE&kw=%E8%B3%87%E6%96%99%E7%B5%90%E6%A7%8B-%E4%BD%BF%E7%94%A8c%E8%AA%9E%E8%A8%80'),
(7, '原子習慣', 270, 81, 82, 'https://www.kingstone.com.tw/basic/2800000022254/?actid=basic_ver'),
(8, '蛤蟆先生去看心理師', 320, 81, 82, 'https://www.kingstone.com.tw/basic/2011780098857/?zone=book&lid=search&actid=WISE&kw=%E8%9B%A4%E8%9F%86%E5%85%88%E7%94%9F%E5%8E%BB%E7%9C%8B%E5%BF%83%E7%90%86%E5%B8%AB'),
(9, 'TOEIC 單字大全', 460, 0, 68, 'https://www.kingstone.com.tw/basic/2018053027033/?zone=book&lid=search&actid=WISE&kw=toeic'),
(10, '被討厭的勇氣', 245, 84, 4, 'https://www.kingstone.com.tw/basic/2011771016167/?zone=book&lid=search&actid=WISE&kw=%E8%A2%AB%E8%A8%8E%E5%8E%AD%E7%9A%84%E5%8B%87%E6%B0%A3'),
(11, '我想跟你好好說話', 295, 84, 79, 'https://www.kingstone.com.tw/basic/2011771293339/?zone=book&lid=search&actid=WISE&kw=%E6%88%91%E6%83%B3%E8%B7%9F%E4%BD%A0%E5%A5%BD%E5%A5%BD%E8%AA%AA%E8%A9%B1'),
(12, '林肯公路', 350, 66, 0, 'https://www.kingstone.com.tw/basic/2018741099410/?zone=book&lid=search&actid=WISE&kw=%E6%9E%97%E8%82%AF%E5%85%AC%E8%B7%AF');

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `member_num` int(10) NOT NULL,
  `member_id` varchar(10) NOT NULL,
  `member_name` varchar(200) NOT NULL,
  `member_pwd` varchar(200) NOT NULL,
  `member_add` varchar(200) NOT NULL,
  `member_rank` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `member`
--

INSERT INTO `member` (`member_num`, `member_id`, `member_name`, `member_pwd`, `member_add`, `member_rank`) VALUES
(0, '5a7g0002', '吳宜瑾', 'stust', '', 0),
(1, 'csie1', '王大明', '123', '台南市永康區南台街1號', 1),
(2, 'csie2', '陳小美', '456', '台南市永康區南台街2號', 1),
(3, 'csie3', 'Yumii', '789', '台南市永康區南台街3號', 1),
(4, 'CSIE4', 'jane', '123', '台南市永康區南台街4號', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `order_item`
--

CREATE TABLE `order_item` (
  `order_id` int(10) NOT NULL,
  `book_name` varchar(200) NOT NULL,
  `book_num` int(10) NOT NULL,
  `book_total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `order_item`
--

INSERT INTO `order_item` (`order_id`, `book_name`, `book_num`, `book_total`) VALUES
(1, '駭客技術揭密', 2, 1240),
(2, '天地一沙鷗', 3, 750),
(2, '資料結構-使用c語言', 1, 450),
(2, '原子習慣', 1, 270),
(3, '我想跟你好好說話', 2, 590),
(3, '駭客技術揭密', 1, 620),
(4, '小王子', 5, 900),
(4, '我想跟你好好說話', 2, 590),
(5, '月亮與六便士', 1, 450),
(5, '蛤蟆先生去看心理師', 2, 640),
(5, '電腦組裝與選購', 1, 300),
(6, '天地一沙鷗', 2, 500),
(6, '我想跟你好好說話', 3, 885),
(7, '蛤蟆先生去看心理師', 1, 320),
(7, '被討厭的勇氣', 3, 735),
(8, '天地一沙鷗', 2, 500),
(8, '月亮與六便士', 1, 450),
(9, '蛤蟆先生去看心理師', 1, 320),
(9, '電腦組裝與選購', 2, 600),
(9, '資料結構-使用c語言', 1, 450),
(9, '原子習慣', 3, 810),
(10, '小王子', 1, 180),
(10, '天地一沙鷗', 2, 500);

-- --------------------------------------------------------

--
-- 資料表結構 `order_list`
--

CREATE TABLE `order_list` (
  `order_id` int(10) NOT NULL,
  `member_num` int(10) NOT NULL,
  `member_name` varchar(200) NOT NULL,
  `member_add` varchar(200) NOT NULL,
  `pay` varchar(7) NOT NULL,
  `order_total` int(10) NOT NULL,
  `order_status` varchar(10) NOT NULL,
  `order_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `order_list`
--

INSERT INTO `order_list` (`order_id`, `member_num`, `member_name`, `member_add`, `pay`, `order_total`, `order_status`, `order_time`) VALUES
(1, 2, '陳小美', '台南市永康區南台街2號', '線上付款', 1240, '訂單完成', '2022-12-01'),
(2, 2, '陳小美', '台南市永康區南台街2號', 'ATM 匯款', 1470, '訂單完成', '2022-12-03'),
(3, 2, '陳小美', '台南市永康區南台街2號', '貨到付款', 1210, '待領貨', '2022-12-05'),
(4, 1, '王曉明', '台南市永康區南台街2號', 'ATM匯款', 1490, '備貨中', '2022-12-06'),
(5, 1, '王大明', '台南市永康區南台街1號', '貨到付款', 1390, '已出貨', '2022-12-06'),
(6, 1, '王曉明', '台南市永康區南台街1號', '線上付款', 1385, '待領貨', '2022-12-12'),
(7, 2, '陳小美', '台南市永康區南台街2號', '線上付款', 1055, '備貨中', '2022-12-13'),
(8, 1, '王曉明', '台南市永康區南台街1號', '線上付款', 950, '已出貨', '2022-12-16'),
(9, 1, '王曉明', '台南市永康區南台街1號', '貨到付款', 2180, '備貨中', '2022-12-18'),
(10, 1, '王曉明', '台南市永康區南台街1號', '線上付款', 680, '已出貨', '2022-12-18');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `bookstore`
--
ALTER TABLE `bookstore`
  ADD PRIMARY KEY (`book_id`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- 資料表索引 `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
