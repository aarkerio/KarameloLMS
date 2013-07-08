-- ** Forums tables  **
CREATE TABLE catforums (  -- forums categories
 id serial PRIMARY KEY,
 title varchar(150) NOT NULL,
 description varchar(150) NOT NULL,
 created timestamp(0) with time zone DEFAULT now() NOT NULL,
 user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE forums (
 id serial PRIMARY KEY,
 title varchar(150) NOT NULL,
 description varchar(500) NOT NULL,
 user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 vclassroom_id integer NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
 catforum_id integer NOT NULL REFERENCES catforums(id) ON DELETE CASCADE,
 status int NOT NULL DEFAULT 0  -- Activated = 1,  Deactivated=0
);

CREATE TABLE topics ( -- question and aswers in forums  
 id serial PRIMARY KEY,
 subject varchar(150) NOT NULL,
 message text NOT NULL,
 created timestamp(0) with time zone DEFAULT now() NOT NULL,
 forum_id int NOT NULL REFERENCES forums(id) ON DELETE CASCADE,
 vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE, -- just one facility to create student's reports
 user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 status smallint NOT NULL DEFAULT 1,
 views smallint NOT NULL DEFAULT 0  -- number of times the topic has been seen
);

CREATE TABLE replies ( -- replies to topics in forums
 id serial PRIMARY KEY,
 reply text NOT NULL,
 created timestamp(0) with time zone DEFAULT now() NOT NULL,
 topic_id int NOT NULL REFERENCES topics(id) ON DELETE CASCADE,
 vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE, -- just one facility to create student's reports
 user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 status smallint NOT NULL DEFAULT 1,
 points smallint NOT NULL DEFAULT 1
);

-- count visitors
CREATE TABLE visitors ( --save user id visitors on topics 
  id serial PRIMARY KEY,
  user_id   int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  topic_id int NOT NULL REFERENCES topics(id) ON DELETE CASCADE
); 
