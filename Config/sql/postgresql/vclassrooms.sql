-- Name: vclassrooms
-- One of the main Karamelo tables
CREATE TABLE vclassrooms (
    "id" serial PRIMARY KEY,
    "name" varchar(150) NOT NULL,
    "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
    "status" smallint DEFAULT 0 NOT NULL,
    "historical" smallint DEFAULT 0 NOT NULL,
    "ecourse_id" int NOT NULL REFERENCES ecourses(id) ON DELETE CASCADE,
    "secret" varchar(10),
    "sdate" date NOT NULL DEFAULT now(), --starting date
    "fdate" date NOT NULL DEFAULT now(), -- finish date
    "access" smallint NOT NULL DEFAULT 0,
    "message" boolean NOT NULL DEFAULT True,
    "chat" smallint NOT NULL DEFAULT 0, -- active / desactive chat
    "videoconference" smallint NOT NULL DEFAULT 0, -- active / desactive FLV stream
    "streaming" text,
    "evaluation" smallint NOT NULL DEFAULT 0, -- active / desactive student evaluation when course finish
    "diploma" smallint NOT NULL DEFAULT 0, -- active / desactive diploma when student get enough points
    "gcalendar_id" varchar(70) 
);

COMMENT ON TABLE vclassrooms IS 'Virtual classrooms';
COMMENT ON COLUMN vclassrooms.status IS 'Define published or draft';
COMMENT ON COLUMN vclassrooms.historical IS 'Vclassroom is now historical record';
COMMENT ON COLUMN vclassrooms.secret IS 'Secret code to allow students register by themselves';
COMMENT ON COLUMN vclassrooms.access IS 'Public VC in other words without secret code';
COMMENT ON COLUMN vclassrooms.message IS 'Just enabled disabled little message in vclassroom if teacher is logged, See show method';

-- Students comments about course when vclassroom finish
CREATE TABLE evaluations (
 "id" serial PRIMARY KEY,
 "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
 "evaluation" smallint,
 "intructors" text,
 "materiales" text,
 "take_another" boolean,
 "free" text, 
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL
);

COMMENT ON TABLE evaluations IS 'Students comments about course when vclassroom finish';
COMMENT ON COLUMN evaluations.free IS 'suggestions, opinion or something missing';
COMMENT ON COLUMN evaluations.evaluation IS '1 to 10';

--HABTM (Core Karamelo Model)
CREATE TABLE user_vclassrooms (
  "id" serial PRIMARY KEY,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  "group_id" smallint NOT NULL REFERENCES groups(id) ON DELETE CASCADE DEFAULT 3,
  "kind" smallint NOT NULL DEFAULT 0,
   UNIQUE ("user_id", "vclassroom_id", "kind")
);

COMMENT ON TABLE user_vclassrooms IS 'This model links students, teachers and tuthors to vClassrooms';
COMMENT ON COLUMN user_vclassrooms.kind IS 'Owner 1, tuthor 2, or student 0';

CREATE TABLE reports (  -- tests student results
   "id" serial NOT NULL PRIMARY KEY,
   "filename" varchar(80) NOT NULL UNIQUE,
   "description" varchar(150) NOT NULL, 
   "student_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   "activity_id" int,
   "points" smallint NOT NULL DEFAULT 0,
   "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
   "checked" smallint NOT NULL DEFAULT 0    
);

COMMENT ON TABLE reports IS 'Student files sent to Virtual classroom';
COMMENT ON COLUMN reports.checked IS 'Report checked by teacher';

CREATE TABLE participations (  
   "id" serial NOT NULL PRIMARY KEY,
   "title" varchar(80) NOT NULL,
   "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE, -- student id
   "points" smallint NOT NULL DEFAULT 0,
   "participation" text NOT NULL,
   "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
   "activity_id" int,
   "checked" smallint NOT NULL DEFAULT 0  -- participation checked by teacher
);

COMMENT ON TABLE participations IS 'Student opinions at to Virtual classroom';
COMMENT ON COLUMN participations.checked IS 'Participation checked by teacher';

 -- chats on vclassroom
CREATE TABLE chats ( 
   "id" serial NOT NULL PRIMARY KEY,
   "student_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE, -- student id in fact
   "teacher_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE, -- student id in fact
   "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   "message" varchar(100) NOT NULL,
   "status" smallint NOT NULL DEFAULT 1,
   "created" timestamp(0) with time zone DEFAULT now() NOT NULL
);

CREATE TABLE pings ( 
   "id" serial NOT NULL PRIMARY KEY,
   "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   "last_ip" inet,
   "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   "last_time" timestamp(0) with time zone DEFAULT current_timestamp NOT NULL  -- last time
);

COMMENT ON TABLE pings IS 'Keeps current users in chats to generate list';


CREATE TABLE permanent_classes (
  "id" serial PRIMARY KEY,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "title" varchar(160) NOT NULL,
  "description" text,
  "archived" smallint NOT NULL DEFAULT 0,
  "created" date NOT NULL DEFAULT now() --starting date 
);

COMMENT ON TABLE permanent_classes IS 'This model creates permanent lists of students PermanentClass hasMany PcStudent';


CREATE TABLE pc_students ( 
   "id" serial NOT NULL PRIMARY KEY,
   "student_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   "pc_id" int NOT NULL REFERENCES permanent_classes(id) ON DELETE CASCADE,
   "created" date NOT NULL DEFAULT now(),
   UNIQUE ("student_id", "pc_id")
);
COMMENT ON TABLE pc_students IS 'Group of permanent class students';

