-- tables for school library

CREATE TABLE types (
  id serial PRIMARY KEY,
  type varchar(80) NOT NULL UNIQUE
);

INSERT INTO types (type) VALUES ('Book'); 
INSERT INTO types (type) VALUES ('Magazine');
INSERT INTO types (type) VALUES ('Newspaper');
INSERT INTO types (type) VALUES ('DVD');
INSERT INTO types (type) VALUES ('CD');

CREATE TABLE clasifications (
  id serial PRIMARY KEY,
  name varchar(80) NOT NULL UNIQUE
);

INSERT INTO clasifications (name) VALUES ('Computers & Internet');
INSERT INTO clasifications (name) VALUES ('Reference');
INSERT INTO clasifications (name) VALUES ('Business & Investing'); 
INSERT INTO clasifications (name) VALUES ('Professional & Technical');
INSERT INTO clasifications (name) VALUES ('Nonfiction');
INSERT INTO clasifications (name) VALUES ('Entertainment');
INSERT INTO clasifications (name) VALUES ('Science');
INSERT INTO clasifications (name) VALUES ('History ');
INSERT INTO clasifications (name) VALUES ('Health, Mind & Body');
INSERT INTO clasifications (name) VALUES ('Arts & Photography');
INSERT INTO clasifications (name) VALUES ('Medicine');
INSERT INTO clasifications (name) VALUES ('Home & Garden');
INSERT INTO clasifications (name) VALUES ('Literature & Fiction');
INSERT INTO clasifications (name) VALUES ('Law');
INSERT INTO clasifications (name) VALUES ('Children''s Books');
INSERT INTO clasifications (name) VALUES ('Biographies & Memoirs');
INSERT INTO clasifications (name) VALUES ('Teens');
INSERT INTO clasifications (name) VALUES ('Outdoors & Nature');
INSERT INTO clasifications (name) VALUES ('Mystery & Thrillers');
INSERT INTO clasifications (name) VALUES ('Comics & Graphic Novels');
INSERT INTO clasifications (name) VALUES ('Society');
INSERT INTO clasifications (name) VALUES ('Science Fiction & Fantasy');
INSERT INTO clasifications (name) VALUES ('Romance');
INSERT INTO clasifications (name) VALUES ('Gay & Lesbian');
INSERT INTO clasifications (name) VALUES ('Religion & Spirituality');
INSERT INTO clasifications (name) VALUES ('Travel');
INSERT INTO clasifications (name) VALUES ('Cooking, Food & Wine');
INSERT INTO clasifications (name) VALUES ('Sports');
INSERT INTO clasifications (name) VALUES ('Education and school');
INSERT INTO clasifications (name) VALUES ('Politics');

CREATE TABLE collections (
  id serial PRIMARY KEY,
  clasification_id smallint NOT NULL references clasifications(id),
  tags varchar(60),
  taxonomy varchar(60),
  type_id smallint NOT NULL references types(id) ON DELETE CASCADE,  -- Book, CD, LP, periodicals
  title varchar(150) NOT NULL,
  author varchar(150) NOT NULL,
  edition smallint,
  status smallint NOT NULL DEFAULT 0,
  editor varchar(100),
  isonumber varchar(70), --ISBN, ISSN, NS
  cost float DEFAULT '0.0',
  groups smallint NOT NULL DEFAULT 1, -- 1) only students 2) students and teachers
  copies smallint NOT NULL DEFAULT 1,
  created timestamp(0) without time zone DEFAULT now() NOT NULL
);
COMMENT ON TABLE collections IS 'Books, Magazines and CDs in School';
COMMENT ON COLUMN collections.copies IS 'number of copies';
COMMENT ON COLUMN collections.tags IS 'tags helps in search';
COMMENT ON COLUMN collections.taxonomy IS 'Dewey ubication in shell';

-- Lent to students
CREATE TABLE lendings (
  id serial PRIMARY KEY,
  collection_id int NOT NULL references collections(id) ON DELETE CASCADE,
  lend timestamp(0) without time zone DEFAULT now() NOT NULL,
  fdate date DEFAULT now() NOT NULL,
  sdate date DEFAULT now() NOT NULL,
  days smallint NOT NULL DEFAULT 7,
  user_id int NOT NULL references users(id) ON DELETE CASCADE,
  status smallint NOT NULL DEFAULT 1
);

COMMENT ON TABLE lendings IS 'Students books lendings';
COMMENT ON COLUMN lendings.status IS '1 lending,  2 passed, 3 closed';
