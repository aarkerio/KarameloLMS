-- Share stuff (docs and multimedia) with your students
CREATE TABLE shares (
"id" serial PRIMARY KEY,
"file" varchar(50) UNIQUE NOT NULL,
"subject_id" int REFERENCES subjects(id) NOT NULL,
"description" varchar(150) NOT NULL,
"user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
"created" timestamp(0) with time zone DEFAULT now() NOT NULL,
"secret"  varchar(16) NOT NULL UNIQUE, -- the secret reference
"public" smallint NOT NULL DEFAULT 0,  --shareable?
"status" smallint NOT NULL DEFAULT 0, 
"knet" smallint NOT NULL DEFAULT 0
);

COMMENT ON TABLE shares IS 'Teachers shared files';
COMMENT ON COLUMN shares.public IS 'Public or only logged users';