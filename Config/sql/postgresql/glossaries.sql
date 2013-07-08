-- Glossaries categories
CREATE TABLE catglossaries (
 "id" serial PRIMARY KEY,
 "title" varchar(100) NOT NULL,
 "description" text NOT NULL,
 "user_id" int NOT NULL REFERENCES users (id) ON DELETE CASCADE,
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
 "status" int NOT NULL DEFAULT 0,
 "public" smallint NOT NULL DEFAULT 0,
 "knet" smallint NOT NULL DEFAULT 0
);

-- Glossaries
CREATE TABLE glossaries (
 id serial PRIMARY KEY,
 catglossary_id int REFERENCES catglossaries (id) ON DELETE CASCADE,
 license_id smallint REFERENCES licenses(id) NOT NULL DEFAULT 6,
 item varchar(80) NOT NULL,
 definition text NOT NULL,
 display smallint NOT NULL DEFAULT 1, -- display terms order
 status  smallint NOT NULL DEFAULT 1,
 user_id int REFERENCES users (id) ON DELETE CASCADE
);



