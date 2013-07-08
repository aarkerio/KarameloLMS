--- FB APP january-2011
-- Webquest
CREATE TABLE "wquests" (
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

CREATE TABLE result_wquests (  -- webquests student results
   id serial NOT NULL UNIQUE,
   answer text NOT NULL,
   user_id int NOT NULL,
   points smallint NOT NULL,
   wquest_id int NOT NULL REFERENCES wquests(id) ON DELETE CASCADE,
   created timestamp(0) with time zone DEFAULT now() NOT NULL,
   PRIMARY KEY (user_id, wquest_id)
);
