-- Podcasts
CREATE TABLE "podcasts" ( 
"id" serial PRIMARY KEY, 
"title" varchar(50) NOT NULL DEFAULT '', 
"description" varchar(255) NOT NULL DEFAULT '', 
"keywords" varchar(100), 
"created" timestamp(0) with time zone DEFAULT now() NOT NULL, 
"length" varchar(10) NOT NULL DEFAULT 0,
"duration" varchar(8) NOT NULL DEFAULT '',
"filename" varchar(100) NOT NULL,
"subject_id" int REFERENCES subjects(id),
"status" int NOT NULL DEFAULT 0,
"adult" int NOT NULL DEFAULT 0,
"user_id" int REFERENCES users(id) ON DELETE CASCADE,
"knet" smallint NOT NULL DEFAULT 0,
"public" smallint NOT NULL DEFAULT 0
);

INSERT INTO podcasts ("title", "description", "filename", "subject_id", "status", "user_id", "public", "knet") VALUES ('Podcast Demo', 'Some demo sample', 'demo_1.mp3', 1, 1, 1, 1, 1);
