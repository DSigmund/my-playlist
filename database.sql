CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(45) NOT NULL DEFAULT 'game, movie, book',
  `image` varchar(255) NOT NULL DEFAULT 'link to imagee',
  `platform` varchar(255) DEFAULT NULL,
  `launcher` varchar(45) DEFAULT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'backlog, active, done',
  `user` varchar(255) NOT NULL DEFAULT 'foreign key to users.name',
  PRIMARY KEY (`id`),
  KEY `name_idx` (`user`),
  CONSTRAINT `name` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `subitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `order` int(11) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'active, done, backlog',
  PRIMARY KEY (`id`),
  KEY `id_idx` (`listid`),
  CONSTRAINT `id` FOREIGN KEY (`listid`) REFERENCES `list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
