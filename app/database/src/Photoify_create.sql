-- tables
-- Table: comments
CREATE TABLE comments (
    id int  NOT NULL,
    users_id int  NOT NULL,
    posts_id int  NOT NULL,
    created_at timestamp  NOT NULL,
    updated_at timestamp  NOT NULL,
    CONSTRAINT comments_pk PRIMARY KEY (id)
    FOREIGN KEY(users_id) REFERENCES users(id)
    FOREIGN KEY(posts_id) REFERENCES posts(id)
);

-- Table: likes
CREATE TABLE likes (
    users_id int  NOT NULL,
    posts_id int  NOT NULL,
    created_at timestamp  NOT NULL,
    updated_at timestamp  NOT NULL,
    CONSTRAINT likes_pk PRIMARY KEY (users_id,posts_id)
    FOREIGN KEY(users_id) REFERENCES users(id)
    FOREIGN KEY(posts_id) REFERENCES posts(id)
);

-- Table: posts
CREATE TABLE posts (
    id int  NOT NULL,
    users_id int  NOT NULL,
    image varchar(511)  NOT NULL,
    content varchar(511)  NOT NULL,
    created_at timestamp  NOT NULL,
    updated_at timestamp  NOT NULL,
    CONSTRAINT posts_pk PRIMARY KEY (id)
    FOREIGN KEY(users_id) REFERENCES users(id)
);

-- Table: users
CREATE TABLE users (
    id int  NOT NULL,
    name varchar(255)  NOT NULL,
    email varchar(255)  NOT NULL,
    password varchar(255)  NOT NULL,
    avatar varchar(511)  NOT NULL,
    created_at timestamp  NOT NULL,
    updated_at timestamp  NOT NULL,
    CONSTRAINT id PRIMARY KEY (id)
);
