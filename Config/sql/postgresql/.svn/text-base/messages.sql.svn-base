-- Messages between users
CREATE TABLE messages (
    "id" serial PRIMARY KEY,
    "title" varchar(90) NOT NULL,
    "body" text NOT NULL,
    "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
    "level" int NOT NULL DEFAULT 0,  -- build the message thread if reply exist
    "sender_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE, -- Who send the message
    "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,  -- Who receive the message
    "status" smallint NOT NULL DEFAULT 0
);


