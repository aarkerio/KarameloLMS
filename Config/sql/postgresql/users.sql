-- Copyright 2005-2008,	Cake Software Foundation, Inc.
-- Licensed under The MIT License-
-- Redistributions of files must retain the above copyright notice.
-- http://www.opensource.org/licenses/mit-license.php The MIT License
-- Chipotle Software modifications   2006-2010  ;-)

CREATE TABLE groups (     
    id serial PRIMARY KEY,
    name varchar(50) NOT NULL UNIQUE,
    created timestamp(0) with time zone DEFAULT now() NOT NULL,
    modified timestamp(0) with time zone DEFAULT now() NOT NULL,
    code varchar(7) NOT NULL DEFAULT 'f78Z67',
    active smallint NOT NULL DEFAULT 1,  -- active/desactive group
    CHECK ( length(code)  > 6  )
);

INSERT INTO groups ("name", "code") VALUES ('Admins',    'gh67rt5');
INSERT INTO groups ("name", "code") VALUES ('Teachers',  'su8723y');
INSERT INTO groups ("name", "code") VALUES ('Students',  '34uy569');
INSERT INTO groups ("name", "code") VALUES ('Parents',   'ki789t6');

-- Name: users; 
CREATE TABLE users (
    "id" serial PRIMARY KEY,
    "username" varchar(10) NOT NULL UNIQUE, --login
    "pwd" varchar(60)  NOT NULL,
    "name" varchar(70)  NOT NULL,
    "lastname" varchar(70)  NOT NULL,
    "email" varchar(45)  NOT NULL UNIQUE,
    "last_visit" timestamp(0) with time zone DEFAULT now() NOT NULL,
    "current_visit" varchar(20),
    "group_id" int NOT NULL references groups(id),   -- Admin, teacher, parent, ot student
    "active" smallint DEFAULT 0 NOT NULL,
    "lang" varchar(3) NOT NULL DEFAULT 'en',
    "avatar" varchar(100) DEFAULT 'default-avatar.jpg' NOT NULL,
    "editor" smallint DEFAULT 1 NOT NULL,  -- enabled FCKeditor
    "helps" boolean NOT NULL DEFAULT true, -- helps enables
     CHECK ( length(pwd)  > 20  )
);

--New profile table
create table profiles(
    "id" serial PRIMARY KEY,
    "user_id" int NOT NULL references users(id) UNIQUE,
    "phone" varchar(50),  
    "matricula" varchar(20),
    "cellphone" varchar(50),
    "quote" varchar(150),
    "name_blog" varchar(150),
    "tags" varchar(150),
    "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
    "layout" varchar(30) DEFAULT 'mexico' NOT NULL,
    "cv" text,
    "newsletter" smallint NOT NULL DEFAULT 0, --the user is subscribed to portal newsletter
    "modified" timestamp(0) with time zone DEFAULT now() NOT NULL
);

--Anonymous user, just for anonymous comments in blogs
INSERT INTO users("id","username", "pwd", "name", "lastname", "avatar", "email", "group_id", "active") VALUES 
(2,'anonymous', '785b434076916992b9564g5b', 'Anonymous', 'Anonuser', 'anonymous.png', 'anonymous@site.edu',3,1);

ALTER SEQUENCE "users_id_seq" RESTART WITH 4; -- as I not used trigger sequence in 1 and 2 I set manually in 4 

-- OpenID table
--create table users_openids (
--  openid_url varchar(255) NOT NULL UNIQUE,
--  user_id int NOT NULL
--);

-- Groups and users
CREATE TABLE aros (
    "id" serial PRIMARY KEY,
    "parent_id" integer,
    "model" varchar(60),
    "foreign_key" integer,
    "alias"  varchar(60),
    "lft" integer,
    "rght" integer
);

--Langs
CREATE TABLE "langs" (
 "id" serial PRIMARY KEY,
 "code" varchar(6) NOT NULL UNIQUE,
 "lang" varchar(80) NOT NULL UNIQUE
);

INSERT INTO langs (code, lang) VALUES ('es_AR', 'Spanish Argentina');
INSERT INTO langs (code, lang) VALUES ('es_ES', 'Spanish Spain');
INSERT INTO langs (code, lang) VALUES ('es_MX', 'Spanish Mexico');
INSERT INTO langs (code, lang) VALUES ('en_US', 'English USA');
INSERT INTO langs (code, lang) VALUES ('en_GB', 'English UK');
INSERT INTO langs (code, lang) VALUES ('fr_FR', 'French France');
INSERT INTO langs (code, lang) VALUES ('fr_CA', 'French Canada');

-- Confirms user registration table, just a support table until new user confirm his/her email
CREATE TABLE "confirms" ( 
 "id" serial PRIMARY KEY,
 "user_id" integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
 "secret" varchar(16) NOT NULL,
 CHECK ( length(secret)  > 13  )
);

-- this is a table to keep temporal data, is used to recover the user password -- see  recovers_controller.php  file
CREATE TABLE "recovers" (
  "id" serial PRIMARY KEY,
  "user_id" int REFERENCES users(id) ON DELETE CASCADE,
  "random" varchar(150) NOT NULL UNIQUE, -- the confirmation string sended to email user to reset his password
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL
);
