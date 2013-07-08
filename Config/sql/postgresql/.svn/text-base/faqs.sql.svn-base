-- FAQs categories
CREATE TABLE catfaqs (
 "id" serial PRIMARY KEY,
 "title" varchar(120) NOT NULL,
 "description" varchar(250) NOT NULL,
 "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
 "status" int NOT NULL DEFAULT 0,
 "knet" smallint NOT NULL DEFAULT 0,
 "public" smallint NOT NULL DEFAULT 0  --shareable?
);

-- FAQs
CREATE TABLE faqs (
 "id" serial PRIMARY KEY,
 "question" varchar(90) NOT NULL,
 "answer" text NOT NULL,
 "catfaq_id" int NOT NULL REFERENCES catfaqs (id) ON DELETE CASCADE,
 "user_id" int NOT NULL REFERENCES users (id) ON DELETE CASCADE,
 "display" smallint NOT NULL DEFAULT 1, -- order
 "status" int NOT NULL DEFAULT 0
);
