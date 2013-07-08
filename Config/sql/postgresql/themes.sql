CREATE TABLE themes (  -- News themes with image each one
  id serial PRIMARY KEY,
  theme varchar(40) NOT NULL,
  description varchar(400) NOT NULL,
  img varchar(80) NOT NULL
);

INSERT INTO themes ("theme", "description", "img") VALUES ('Biology', 'All about biology', 'theme-biology.png');
INSERT INTO themes ("theme", "description", "img") VALUES ('Announcement', 'Announcement', 'theme-announcement.png');
INSERT INTO themes ("theme", "description", "img") VALUES ('Fun', 'Fun stuff', 'theme-fun.png');

