CREATE TABLE members (
  `m_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` datetime(6),
  `book_limit` int(10) unsigned,
  `status` bit(1),
  `admin` bit(1),
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE addresses (
  `m_id` int(10) unsigned NOT NULL,
  `line_1` varchar(50) DEFAULT NULL,
  `line_2` varchar(50) DEFAULT NULL,
  `line_3` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `other` varchar(50) DEFAULT NULL,
  FOREIGN KEY (`m_id`) REFERENCES members(m_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE books (
  `b_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `quantity` int(10) unsigned,
  `subject` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE INDEX title_index ON books(`title`) USING BTREE;

CREATE TABLE orders (
  `o_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`o_id`, `m_id`),
  FOREIGN KEY (`m_id`) REFERENCES members(`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE transactions (
  `o_id` int(10) unsigned NOT NULL,
  `b_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`o_id`, `b_id`),
  FOREIGN KEY (`o_id`) REFERENCES orders(`o_id`),
  FOREIGN KEY (`b_id`) REFERENCES books(`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE frequentItems1 (
  `b_id` int(10) unsigned NOT NULL,
  `frequency` double,
  PRIMARY KEY (`b_id`),
  FOREIGN KEY (`b_id`) REFERENCES books(`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE frequentItems2 (
  `b_id1` int(10) unsigned NOT NULL,
  `b_id2` int(10) unsigned NOT NULL,
  `frequency` double,
  PRIMARY KEY (`b_id1`,`b_id2`),
  FOREIGN KEY (`b_id1`) REFERENCES books(`b_id`),
  FOREIGN KEY (`b_id2`) REFERENCES books(`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE frequentItems3 (
  `b_id1` int(10) unsigned NOT NULL,
  `b_id2` int(10) unsigned NOT NULL,
  `b_id3` int(10) unsigned NOT NULL,
  `frequency` double,
  PRIMARY KEY (`b_id1`,`b_id2`,`b_id3`),
  FOREIGN KEY (`b_id1`) REFERENCES books(`b_id`),
  FOREIGN KEY (`b_id2`) REFERENCES books(`b_id`),
  FOREIGN KEY (`b_id3`) REFERENCES books(`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE frequentItems4 (
  `b_id1` int(10) unsigned NOT NULL,
  `b_id2` int(10) unsigned NOT NULL,
  `b_id3` int(10) unsigned NOT NULL,
  `b_id4` int(10) unsigned NOT NULL,
  `frequency` double,
  PRIMARY KEY (`b_id1`,`b_id2`,`b_id3`,`b_id4`),
  FOREIGN KEY (`b_id1`) REFERENCES books(`b_id`),
  FOREIGN KEY (`b_id2`) REFERENCES books(`b_id`),
  FOREIGN KEY (`b_id3`) REFERENCES books(`b_id`),
  FOREIGN KEY (`b_id4`) REFERENCES books(`b_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;