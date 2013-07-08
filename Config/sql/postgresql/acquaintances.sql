-- bloggers links
CREATE TABLE acquaintances (
   id serial PRIMARY KEY,
   name varchar(50) NOT NULL,
   url varchar(250),
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   description text
);


