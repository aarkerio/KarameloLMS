CREATE TABLE colleges (
  id serial PRIMARY KEY,
  name varchar(150) NOT NULL,
  description text NOT NULL,
  email varchar(40) NOT NULL,
  twitter varchar(60),
  keywords varchar(200) NOT NULL,
  sp  varchar(100),  -- school parents ennabled/disabled
  url varchar(200),
  logo VARCHAR(60) NOT NULL DEFAULT 'cwclogo.jpg',
  gcalendar_id VARCHAR(80),
  user_id smallint NOT NULL DEFAULT 1
);

INSERT INTO colleges (name, description, email, keywords, twitter) VALUES ('Chipotle College', 'Chipotle College','email@test.edu', 'education', 'ChipotleSoft');

-- tipos de elementos didácticos
CREATE TABLE ktypes (   --  knets 
   id smallint PRIMARY KEY,
   edi varchar(90) NOT NULL UNIQUE -- elemento didáctico
);

INSERT INTO ktypes (id, edi) VALUES (1, 'Lesson'); 
INSERT INTO ktypes (id, edi) VALUES (2, 'Gap filling');
INSERT INTO ktypes (id, edi) VALUES (3, 'Webquest');
INSERT INTO ktypes (id, edi) VALUES (4, 'Scavenger hunt');
INSERT INTO ktypes (id, edi) VALUES (5, 'Squeeze test');
INSERT INTO ktypes (id, edi) VALUES (6, 'WikPage');
INSERT INTO ktypes (id, edi) VALUES (7, 'Podcast');
INSERT INTO ktypes (id, edi) VALUES (8, 'FAQ');
INSERT INTO ktypes (id, edi) VALUES (9, 'Glossary');
INSERT INTO ktypes (id, edi) VALUES (10, 'Image');
INSERT INTO ktypes (id, edi) VALUES (11, 'SCORM');

-- Subjects
CREATE TABLE subjects (
 id serial PRIMARY KEY,
 code varchar(8) NOT NULL UNIQUE,
 title varchar(80) NOT NULL UNIQUE
);

INSERT INTO subjects (code, title) VALUES ('0001', 'Mathematics');
INSERT INTO subjects (code, title) VALUES ('0002', 'English');
INSERT INTO subjects (code, title) VALUES ('0003', 'History');
INSERT INTO subjects (code, title) VALUES ('0004', 'Art');
INSERT INTO subjects (code, title) VALUES ('0005', 'Philosophy');
INSERT INTO subjects (code, title) VALUES ('0006', 'Music');
INSERT INTO subjects (code, title) VALUES ('0007', 'Psichology');

-- See Wiki Ttac
CREATE TABLE knets (   --  knets 
   id serial PRIMARY KEY,
   title varchar(90) NOT NULL,
   subject_id smallint REFERENCES subjects(id) NOT NULL,
   ktype_id smallint REFERENCES ktypes(id) NOT NULL,
   description varchar(200), -- set textarea in view
   created timestamp(0) with time zone DEFAULT now() NOT NULL,
   modified timestamp(0) with time zone DEFAULT now() NOT NULL,
   disc int NOT NULL DEFAULT 0,   --discution (comments) actived
   status int NOT NULL DEFAULT 0,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   rank int NOT NULL DEFAULT 0, -- recommended EDI
   visits int NOT NULL DEFAULT 0
);

CREATE INDEX knets_idx ON knets USING gin(to_tsvector('spanish', description));
--Licenses
CREATE TABLE licenses (
 id serial PRIMARY KEY,
 title varchar(150) NOT NULL UNIQUE,
 description text
);

INSERT INTO licenses (id,title) VALUES (1, 'Creative Commons Share-alike');
INSERT INTO licenses (id,title) VALUES (2, 'Creative Commons No derivative');
INSERT INTO licenses (id,title) VALUES (3, 'Creative Commons Attribution');
INSERT INTO licenses (id,title) VALUES (4, 'Creative Commons Non-Commercial');
INSERT INTO licenses (id,title) VALUES (5, 'GNU Documentation License');
INSERT INTO licenses (id,title) VALUES (6, 'CopyRigth License');
