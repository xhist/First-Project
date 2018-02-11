--
-- Database: `myweb`
--
CREATE DATABASE IF NOT EXISTS `myweb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `myweb`;

-- --------------------------------------------------------

--
-- Структура на таблица `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `header` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `blog`
--

INSERT INTO `blog` (`id`, `header`, `description`, `cid`) VALUES
(23, 'dasdasddsas', 'dadsdadsadsda', 2),
(24, 'dasdasdasdad', 'asdasdasdasdada', 3);

-- --------------------------------------------------------

--
-- Структура на таблица `cats`
--

CREATE TABLE `cats` (
  `cid` int(11) NOT NULL,
  `cname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `cats`
--

INSERT INTO `cats` (`cid`, `cname`) VALUES
(1, 'Linux'),
(2, 'PHP'),
(3, 'Windows'),
(4, 'Mac');

-- --------------------------------------------------------

--
-- Структура на таблица `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `description` text NOT NULL,
  `pid` int(11) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `comments`
--

INSERT INTO `comments` (`id`, `userid`, `description`, `pid`, `cdate`) VALUES
(22, 9, 'dasdasdsdas', 23, '2017-05-04 20:41:11'),
(23, 9, 'dasdasdsasda', 23, '2017-05-05 22:25:36'),
(24, 9, 'dasdasdadas', 23, '2017-05-12 16:07:39'),
(25, 9, 'output: hello. How are you. code: hello  How are you  ... Impossible with the same HTML structure, you must have something to\noutput: hello. How are you. code: hello  How are you  ... Impossible with the same HTML structure, you must have something to', 23, '2017-05-12 16:12:17'),
(26, 9, 'dasdasdasdasdas\noutput: hello. How are you. code: hello How are you ... Impossible with the same HTML structure, you must have something to output: hello. How are you. code: hello How are you ..', 23, '2017-05-13 20:00:20');

-- --------------------------------------------------------

--
-- Структура на таблица `favorites`
--

CREATE TABLE `favorites` (
  `pid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `favid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура на таблица `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_title` varchar(50) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `level` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`userId`, `userName`, `firstname`, `lastname`, `userEmail`, `userPass`, `photo`, `level`) VALUES
(9, 'xhister', 'John', 'Doe', 'xhister@abv.bg', 'dd18f99383b418cdcc488d482d6e5b4a385767cbf772fca863dd92ed99d2a9ff', '591b22a41d3626.80744741.jpg', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;