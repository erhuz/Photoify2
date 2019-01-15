-- tables

-- Table: users
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE,
    password TEXT NOT NULL,
    avatar TEXT DEFAULT NULL DEFAULT "avatar.png",
    bio TEXT DEFAULT NULL,
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: posts
CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    image TEXT NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

-- Table: comments
CREATE TABLE comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    post_id INTEGER NOT NULL,
    description TEXT NOT NULL, -- Beauty fault, should be named content instead
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(post_id) REFERENCES posts(id)
);

-- Table: reactions
CREATE TABLE reactions (
    user_id INTEGER NOT NULL,
    post_id INTEGER NOT NULL,
    status INTEGER NOT NULL,
    created_at TIMESTAMP DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT reactions_pk PRIMARY KEY (user_id,post_id)
    FOREIGN KEY(user_id) REFERENCES users(id)
    FOREIGN KEY(post_id) REFERENCES posts(id)
);
