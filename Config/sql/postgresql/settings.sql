CREATE TABLE settings (
  "id" serial PRIMARY KEY,
  "name" varchar(50) NOT NULL UNIQUE,
  "value" varchar(255) NOT NULL,
  "default" varchar(255) NOT NULL,
  "description" varchar(255) NOT NULL
);

