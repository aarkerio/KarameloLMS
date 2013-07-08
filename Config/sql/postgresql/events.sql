CREATE TABLE events (
    id serial PRIMARY KEY,
    title varchar(100) NOT NULL,
    description  varchar(255) NOT NULL,
    "when" timestamp(0) with time zone DEFAULT now() NOT NULL,
    status int NOT NULL DEFAULT 0
);


