-- Treasure hunts         http://www.gma.org/surfing/imaging/treasure.html
CREATE TABLE "treasures" (
  "id" serial PRIMARY KEY,
  "title" varchar(150) NOT NULL,
  "points" smallint NOT NULL DEFAULT 3, 
  "secret" varchar(15) NOT NULL,  -- secret word, stop  
  "instructions" text NOT NULL DEFAULT '',
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
  "status" smallint NOT NULL DEFAULT 0,
  "archived" boolean NOT NULL DEFAULT False,
  "knet" boolean NOT NULL DEFAULT False
);

-- treasures student results
CREATE TABLE result_treasures ( 
   id serial NOT NULL UNIQUE,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   points smallint NOT NULL,
   treasure_id int NOT NULL REFERENCES treasures (id) ON DELETE CASCADE,
   vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   created timestamp(0) with time zone DEFAULT now() NOT NULL,
   PRIMARY KEY (user_id, treasure_id, vclassroom_id)
);

-- Linking Kandie
CREATE TABLE "treasures_vclassrooms" (
 "id" serial PRIMARY KEY,
 "treasure_id" int NOT NULL REFERENCES treasures(id) ON DELETE CASCADE,
 "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
 "sdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "fdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "hidden" boolean NOT NULL DEFAULT True,
 "open" boolean NOT NULL DEFAULT True, -- no sdate or sdate, always open
  UNIQUE  ("treasure_id", "vclassroom_id")
);
