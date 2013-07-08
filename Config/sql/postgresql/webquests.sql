--- FB APP january-2011
-- Webquest
CREATE TABLE "webquests" (
  "id" serial PRIMARY KEY,
  "title" varchar(80) NOT NULL,
  "introduction" text NOT NULL DEFAULT '',
  "tasks" text NOT NULL DEFAULT '',
  "process" text NOT NULL DEFAULT '',
  "roles" text NOT NULL DEFAULT '',
  "evaluation" text NOT NULL DEFAULT '',
  "conclusion" text NOT NULL DEFAULT '',
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "updated" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "user_id" int NOT NULL,  -- FB api gives me this
  "status" smallint NOT NULL DEFAULT 0,
  "archived" smallint NOT NULL DEFAULT 0,
  "points" smallint NOT NULL DEFAULT 10,
  "share" smallint NOT NULL DEFAULT 0  -- share knet?
);

CREATE TABLE result_webquests (  -- webquests student results
   "id" serial NOT NULL UNIQUE,
   "answer" text NOT NULL,
   "user_id" int NOT NULL,
   "points" smallint NOT NULL,
   "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   "checked"  smallint NOT NULL DEFAULT 0,
   "webquest_id" int NOT NULL REFERENCES webquests(id) ON DELETE CASCADE,
   "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
   PRIMARY KEY ("user_id", "webquest_id")
);

--Kandie Join table
CREATE TABLE "vclassrooms_webquests" (
   "id" serial PRIMARY KEY,
   "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   "webquest_id" int NOT NULL REFERENCES webquests(id) ON DELETE CASCADE,
   "sdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
   "fdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
   "hidden" boolean NOT NULL DEFAULT True,
   UNIQUE ("vclassroom_id", "webquest_id")
  );
