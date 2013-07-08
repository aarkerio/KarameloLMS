# Copyright 2006-2011,	Chipotle Software
# GPLv3 License

CREATE TABLE groups (      # the users groups to Auth
    `id` int(10) PRIMARY KEY auto_increment,
    `name` varchar(50) NOT NULL UNIQUE,
    `created` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `code` varchar(7) NOT NULL DEFAULT 'f78Z6v',
    `active` smallint NOT NULL DEFAULT 1  # active/desactive group
) Engine=InnoDB;

INSERT INTO groups (name, code) VALUES ('admin',     'gh67rt5');
INSERT INTO groups (name, code) VALUES ('teachers',  'su8723y');
INSERT INTO groups (name, code) VALUES ('students',  '34uy569');
INSERT INTO groups (name, code) VALUES ('parents',   'ki789t6');

# Core table 
CREATE TABLE users (
    `id` int(10) PRIMARY KEY auto_increment,
    `username` varchar(10) NOT NULL UNIQUE, #login
    `pwd` varchar(60)  NOT NULL,
    `name` varchar(70)  NOT NULL,
    `lastname` varchar(70)  NOT NULL,
    `email` varchar(45)  NOT NULL UNIQUE,
    `last_visit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `group_id` int NOT NULL references groups(id),                       
    `active` tinyint DEFAULT 0 NOT NULL,
    `editor` tinyint DEFAULT 1 NOT NULL,
    `created` timestamp,
    `modified` timestamp,
    `lang` varchar(2) NOT NULL DEFAULT 'en',
    `avatar` varchar(100) NOT NULL DEFAULT 'default-avatar.jpg',
    `current_visit` varchar(20)
) Engine=InnoDB;

# New profile table
create table profiles(
    id int(10) PRIMARY KEY auto_increment,
    user_id int NOT NULL references users(id),
    phone varchar(50),  
    matricula varchar(20),
    cellphone varchar(50),
    quote varchar(150),
    name_blog varchar(150),
    tags varchar(150),
    created  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    layout varchar(30) DEFAULT 'mexico' NOT NULL,
    cv text,
    newsletter smallint NOT NULL DEFAULT 0, #the user is subscribed to portal newsletter
    modified timestamp,
    UNIQUE idx_users_user_id (user_id)
) Engine=InnoDB;


# id 1 = Admin
# id 2 = Anonymous

ALTER TABLE users AUTO_INCREMENT = 3;

# Groups and users
CREATE TABLE aros (
    id serial PRIMARY KEY,
    parent_id integer,
    model varchar(80),
    foreign_key integer,
    alias varchar(80),
    lft integer,
    rght integer
) Engine=InnoDB;

# Anonymous user, just for anonymous comments in blogs
INSERT INTO users (id,username, pwd, name, lastname, avatar, email, group_id, active) VALUES (2,'anonymous', '785b434076916992b9564g5b', 'Anonymous', 'Anonuser', 'anonymous.png', 'anonymous@site.edu',3,1);

# Langs
CREATE TABLE langs (
 id serial PRIMARY KEY,
 code varchar(6) NOT NULL UNIQUE,
 lang varchar(80) NOT NULL UNIQUE
) Engine=InnoDB;

INSERT INTO langs (code, lang) VALUES ('es_AR', 'Spanish Argentina');
INSERT INTO langs (code, lang) VALUES ('es_ES', 'Spanish Spain');
INSERT INTO langs (code, lang) VALUES ('es_MX', 'Spanish Mexico');
INSERT INTO langs (code, lang) VALUES ('en_US', 'English USA');
INSERT INTO langs (code, lang) VALUES ('en_GB', 'English UK');
INSERT INTO langs (code, lang) VALUES ('fr_FR', 'French France');
INSERT INTO langs (code, lang) VALUES ('fr_CA', 'French Canada');
 
# Confirms user registration table, just a support table until new user confirm his/her email
CREATE TABLE confirms ( 
 id serial PRIMARY KEY,
 user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
 secret varchar(16) NOT NULL,
 CHECK ( length(secret)  > 13  )
) Engine=InnoDB;

# this is a table to keep temporal data, is used to recover the user password. See  recovers_controller.php  file
CREATE TABLE recovers (
  id serial PRIMARY KEY,
  user_id int REFERENCES users(id) ON DELETE CASCADE,
  random varchar(150) NOT NULL UNIQUE, # the confirmation string sended to email user to reset his password
  created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL
) Engine=InnoDB;
