--
-- Table structure for table `additional_fields`
--

CREATE TABLE `additional_fields` (
  `id` int(20) NOT NULL,
  `field` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_fields`
--

INSERT INTO `additional_fields` (`id`, `field`) VALUES
(1, 'color'),
(2, 'size');

-- --------------------------------------------------------

--
-- Table structure for table `additional_field_values`
--

CREATE TABLE `additional_field_values` (
  `id` int(20) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_field_values`
--

INSERT INTO `additional_field_values` (`id`, `value`) VALUES
(1, 'red'),
(2, 'black'),
(3, 'white'),
(4, 'S'),
(5, 'M'),
(6, 'L'),
(7, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `additional_goods_field_values`
--

CREATE TABLE `additional_goods_field_values` (
  `id` int(20) NOT NULL,
  `goods_id` int(20) NOT NULL,
  `additional_field_id` int(20) NOT NULL,
  `additional_field_value_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_goods_field_values`
--

INSERT INTO `additional_goods_field_values` (`id`, `goods_id`, `additional_field_id`, `additional_field_value_id`) VALUES
(3, 1, 1, 1),
(1, 1, 1, 2),
(2, 1, 1, 3),
(4, 2, 2, 4),
(5, 2, 2, 5),
(6, 2, 2, 6),
(7, 2, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `name`) VALUES
(1, 'pencil'),
(2, 't-shirt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_fields`
--
ALTER TABLE `additional_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `additional_field_values`
--
ALTER TABLE `additional_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `additional_goods_field_values`
--
ALTER TABLE `additional_goods_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `goods_id` (`goods_id`,`additional_field_id`,`additional_field_value_id`),
  ADD KEY `additional_field_id` (`additional_field_id`),
  ADD KEY `additional_field_value_id` (`additional_field_value_id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_fields`
--
ALTER TABLE `additional_fields`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `additional_field_values`
--
ALTER TABLE `additional_field_values`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `additional_goods_field_values`
--
ALTER TABLE `additional_goods_field_values`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_goods_field_values`
--
ALTER TABLE `additional_goods_field_values`
  ADD CONSTRAINT `additional_goods_field_values_ibfk_1` FOREIGN KEY (`goods_id`) REFERENCES `goods` (`id`),
  ADD CONSTRAINT `additional_goods_field_values_ibfk_2` FOREIGN KEY (`additional_field_id`) REFERENCES `additional_fields` (`id`),
  ADD CONSTRAINT `additional_goods_field_values_ibfk_3` FOREIGN KEY (`additional_field_value_id`) REFERENCES `additional_field_values` (`id`);
COMMIT;
