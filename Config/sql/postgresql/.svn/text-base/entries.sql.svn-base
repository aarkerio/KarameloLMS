--Subjects
CREATE TABLE subjects (
   "id" serial PRIMARY KEY,
   "code" varchar(8) NOT NULL UNIQUE,
   "title" varchar(80) NOT NULL UNIQUE
  );

INSERT INTO subjects (code, title) VALUES ('0001', 'Mathematics');
INSERT INTO subjects (code, title) VALUES ('0002', 'English');
INSERT INTO subjects (code, title) VALUES ('0003', 'History');
INSERT INTO subjects (code, title) VALUES ('0004', 'Art');
INSERT INTO subjects (code, title) VALUES ('0005', 'Philosophy');
INSERT INTO subjects (code, title) VALUES ('0006', 'Music');
INSERT INTO subjects (code, title) VALUES ('0007', 'Psichology');
         
COMMENT ON COLUMN subjects.code IS 'CODE is obligatory and unique';

-- entries in the users blogs
CREATE TABLE entries (
 "id" serial PRIMARY KEY,
 "title" varchar(50) NOT NULL,
 "body" text NOT NULL,
 "subject_id" int REFERENCES subjects(id) NOT NULL,
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
 "order" smallint DEFAULT 1 NOT NULL,
 "status" smallint NOT NULL DEFAULT 0,
 "user_id" int REFERENCES users(id) ON DELETE CASCADE,
 "discussion" smallint NOT NULL DEFAULT 0,  -- discution, Activ/Desactiv   1/0
 "knet" smallint NOT NULL DEFAULT 0
);

COMMENT ON TABLE entries IS 'Blogger entries';
COMMENT ON COLUMN entries.discussion IS 'Comments allowed in entry';
COMMENT ON COLUMN entries.order IS 'Order display';

 --comments in blogs
CREATE TABLE comments (   
 "id" serial PRIMARY KEY,
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
 "comment" text,
 "user_id" int NOT NULL REFERENCES users (id) ON DELETE CASCADE,
 "blogger_id" int NOT NULL REFERENCES users (id) ON DELETE CASCADE,
 "username" varchar(15),
 "email" varchar(60),
 "website" varchar(120),
 "entry_id" int NOT NULL REFERENCES entries (id) ON DELETE CASCADE,
 "status" smallint NOT NULL DEFAULT 1
);

COMMENT ON TABLE comments IS 'Comment on Blogger entries can save comment from anonymous and registered users';
