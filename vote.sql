    CREATE TABLE IF NOT EXISTS `tc_tuto_rating` (
      `id` int(6) NOT NULL AUTO_INCREMENT,
      `media` int(6) NOT NULL,
      `rate` int(3) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;