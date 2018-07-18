CREATE TABLE users (
  id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(255) NOT NULL ,
  last_name VARCHAR(255) NOT NULL ,
  date_of_birth DATE,
  email VARCHAR(255) NOT NULL UNIQUE ,
  password VARCHAR(255) NOT NULL ,
  created_at DATETIME,
  updated_at DATETIME
);

CREATE TABLE posts (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  user_id INT(11) NOT NULL ,
  title VARCHAR(255) NOT NULL ,
  content VARCHAR(255) NOT NULL ,
  created_at DATETIME,
  updated_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE comments (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  post_id INT(11) NOT NULL ,
  user_id INT(11) NOT NULL ,
  content VARCHAR(255) NOT NULL ,
  created_at DATETIME,
  updated_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE NO ACTION ,
  FOREIGN KEY (post_id) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE NO ACTION

);

INSERT INTO users(first_name, last_name, date_of_birth, email, password, created_at, updated_at)
    VALUES ('Harut','Enoqyan','22.08.91','harut.enoqyan87@gmail.com','secret' , date("Y-m-d H:i:s") , date("Y-m-d H:i:s"));
