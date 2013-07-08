--Ecourses
CREATE TABLE "ecourses" (
  "id" serial PRIMARY KEY,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "subject_id" int NOT NULL REFERENCES subjects(id) ON DELETE CASCADE,
  "title" varchar(110) NOT NULL,
  "kind" smallint NOT NULL DEFAULT 0, 
  "percentage" smallint NOT NULL DEFAULT 60, 
  "description" text,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "status" smallint DEFAULT 0 NOT NULL,
  "public" boolean DEFAULT False,
  "lang_id" int NOT NULL REFERENCES langs(id),
  "code" varchar(13),
  "knet" smallint NOT NULL DEFAULT 0
);

COMMENT ON TABLE ecourses IS 'Online courses';
COMMENT ON COLUMN ecourses.kind IS 'Mixed or 100% online';
COMMENT ON COLUMN ecourses.code IS 'Optional field for school inner control';
COMMENT ON COLUMN ecourses.knet IS 'Let anothers users use this ecourse in Knet';
COMMENT ON COLUMN ecourses.status IS 'Define if ecourse is actually available';
COMMENT ON COLUMN ecourses.public IS 'Define if ecourse ppers in portal and anonymus user can request info';

CREATE TABLE activities (
    "id" serial PRIMARY KEY,
    "title" varchar(40) NOT NULL,
    "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
    "order" smallint DEFAULT 1 NOT NULL,
    "status" smallint DEFAULT 0 NOT NULL,
    "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    "ecourse_id" int NOT NULL REFERENCES ecourses(id) ON DELETE CASCADE,
    "activity" text NOT NULL,
    "notes" text,
    "points" smallint DEFAULT 0 NOT NULL,
    "minutes" smallint DEFAULT 0 NOT NULL
);

COMMENT ON TABLE activities IS 'Activities on ecourse';
COMMENT ON COLUMN activities.activity IS 'Just description to student';
COMMENT ON COLUMN activities.notes IS 'Teachers notes: aims, sources, etc. The student dont see this field';

