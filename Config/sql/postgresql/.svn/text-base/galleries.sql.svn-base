--Gallerys
CREATE TABLE galleries (
  "id" serial PRIMARY KEY,
  "title" varchar(150) NOT NULL,
  "description" text,
  "status" smallint NOT NULL DEFAULT 0,
  "user_id" integer NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

-- photos gallerys
CREATE TABLE photos (
   "id" serial PRIMARY KEY,
   "gallery_id" int REFERENCES galleries (id),  --id gallery
   "file" varchar(30) NOT NULL,
   "title" varchar(30) NOT NULL,
   "description" text,
   "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
   "user_id" integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   "knet" smallint NOT NULL DEFAULT 0
);

