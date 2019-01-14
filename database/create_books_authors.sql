--
-- books_authors table
--

CREATE TABLE `books_authors`
(
  `book_id`   INT NOT NULL,
  `author_id` INT NOT NULL,
  CONSTRAINT `author_id_fk`
  FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `book_id_fk`
  FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`book_id`,`author_id`)
) Engine=InnoDB;