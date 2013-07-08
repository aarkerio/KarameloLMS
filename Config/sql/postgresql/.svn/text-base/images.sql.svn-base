-- Name: images; Type: TABLE; Schema: public; Owner: www-data; Tablespace: each users images 
CREATE TABLE images (
   id serial PRIMARY KEY,
   file varchar(40) NOT NULL UNIQUE,
   user_id int REFERENCES users(id) ON DELETE CASCADE
);

