-- Gaps filling
CREATE TABLE "gaps" (
  "id" serial PRIMARY KEY,
  "title" varchar(90) NOT NULL,
  "instructions" text,
  "gaps" text NOT NULL DEFAULT '',
  "license_id" smallint REFERENCES licenses(id) NOT NULL DEFAULT 6,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "updated" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "user_id" int REFERENCES users(id) ON DELETE CASCADE,
  "status" smallint NOT NULL DEFAULT 0,
  "archived" boolean NOT NULL DEFAULT False,
  "points" smallint NOT NULL DEFAULT 3,
  "knet" smallint NOT NULL DEFAULT 0  
);

-- students answers
CREATE TABLE result_gaps ( 
  "id" serial NOT NULL UNIQUE,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "gap_id" int NOT NULL REFERENCES gaps (id) ON DELETE CASCADE,
  "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
   PRIMARY KEY (user_id, gap_id, vclassroom_id)
);

--Linking Kandie
CREATE TABLE "gaps_vclassrooms" (
 "id" serial PRIMARY KEY,
 "gap_id" int NOT NULL REFERENCES gaps(id) ON DELETE CASCADE,
 "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
 "sdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "fdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "hidden" boolean NOT NULL DEFAULT True,
  UNIQUE  ("gap_id", "vclassroom_id")
);
