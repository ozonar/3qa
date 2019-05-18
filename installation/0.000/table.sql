use shorter;
DROP TABLE IF EXISTS short;
CREATE TABLE IF NOT EXISTS short
(
  id     INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  little VARCHAR(255),
  `long` TEXT,
  ip     VARCHAR(20),
  type   INT(64),
  UNIQUE (little)
)
