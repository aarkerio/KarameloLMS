-- Wiki tables beggin
CREATE TABLE wikis (
  id serial PRIMARY KEY,
  title varchar(80) NOT NULL UNIQUE,
  slug  varchar(80) NOT NULL UNIQUE,
  status smallint NOT NULL DEFAULT 0,
  user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  subject_id smallint NOT NULL REFERENCES subjects(id),
  vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  locked smallint NOT NULL DEFAULT 0,
  public smallint NOT NULL DEFAULT 0
);

COMMENT ON TABLE wikis IS 'WikiPages linked to vclassrooms';
COMMENT ON COLUMN wikis.status IS 'Define published or draft WikiPage';
COMMENT ON COLUMN wikis.locked IS 'WikiPage is currently under edition';
COMMENT ON COLUMN wikis.public IS 'Public or restricted WikiPage , ie, only logged in users)';

-- Students edits on WikiPages
CREATE TABLE revisions (
  id serial PRIMARY KEY,
  content text NOT NULL,
  modified timestamp NOT NULL default now(),
  user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  wiki_id int NOT NULL REFERENCES wikis(id) ON DELETE CASCADE,
  ip varchar(15) NOT NULL,
  revision smallint NOT NULL,
  points smallint NOT NULL DEFAULT 1,
  accessed date NOT NULL DEFAULT now()
 );
