-- tables

-- Table: users
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) UNIQUE,
    password varchar(255) NOT NULL,
    avatar varchar(511) DEFAULT NULL DEFAULT "avatar.png",
    bio varchar(511) DEFAULT NULL,
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: posts
CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    users_id INTEGER NOT NULL,
    image varchar(511) NOT NULL,
    content varchar(511) NOT NULL,
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(users_id) REFERENCES users(id)
);

-- Table: comments
CREATE TABLE comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    users_id INTEGER NOT NULL,
    posts_id INTEGER NOT NULL,
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(users_id) REFERENCES users(id),
    FOREIGN KEY(posts_id) REFERENCES posts(id)
);

-- Table: likes
CREATE TABLE likes (
    users_id INTEGER NOT NULL,
    posts_id INTEGER NOT NULL,
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT likes_pk PRIMARY KEY (users_id,posts_id)
    FOREIGN KEY(users_id) REFERENCES users(id)
    FOREIGN KEY(posts_id) REFERENCES posts(id)
);
