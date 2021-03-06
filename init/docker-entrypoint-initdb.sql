CREATE TABLE users (
    id INT(11) unsigned NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL DEFAULT '',
    password VARCHAR(255) NOT NULL DEFAULT '',
    created_at DATETIME NOT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE searches (
    id INT(11) unsigned NOT NULL AUTO_INCREMENT,
    user_id INT(11) unsigned NOT NULL,
    search VARCHAR(255) NOT NULL DEFAULT '',
    created_at DATETIME NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
