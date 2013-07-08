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

CREATE TABLE lessons ( 
  "id" serial PRIMARY KEY,
  "title" varchar(90) NOT NULL,
  "subject_id" smallint REFERENCES subjects(id) NOT NULL,
  "license_id" smallint REFERENCES licenses(id) NOT NULL DEFAULT 6,
  "body" text NOT NULL,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "modified" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "disc" smallint NOT NULL DEFAULT 0,  
  "public" smallint NOT NULL DEFAULT 0,
  "status" smallint NOT NULL DEFAULT 0,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "rank" int NOT NULL DEFAULT 0,
  "visits" int NOT NULL DEFAULT 0,
  "knet" smallint NOT NULL DEFAULT 0
);

COMMENT ON TABLE lessons IS 'Teachers lessons';
COMMENT ON COLUMN lessons.user_id IS 'Teacher Id';
COMMENT ON COLUMN lessons.disc IS 'Discution (comments) actived on lessons';
COMMENT ON COLUMN lessons.public IS 'Lesson public or only for registered users';

--comments in lesson  see Lesson.php model
CREATE TABLE annotations (   
 "id" serial PRIMARY KEY,
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
 "comment" text NOT NULL,
 "user_id" int NOT NULL REFERENCES users (id) ON DELETE CASCADE, 
 "blogger_id" int NOT NULL REFERENCES users (id) ON DELETE CASCADE,
 "username" varchar(15),
 "email" varchar(60),
 "website" varchar(120),
 "lesson_id" int REFERENCES lessons (id) ON DELETE CASCADE,
 "status" smallint NOT NULL DEFAULT 1
);

COMMENT ON TABLE annotations IS 'Keeps comments in lessons anonymous and registered users';
COMMENT ON COLUMN annotations.status IS 'Define published or draft entry';
