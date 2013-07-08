-- News letters
CREATE TABLE newsletters (
 id serial PRIMARY KEY,
 title varchar(150) NOT NULL,
 body text NOT NULL,
 created timestamp(0) with time zone DEFAULT now() NOT NULL,
 user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 status smallint NOT NULL DEFAULT 0, -- Activated = 1,  Deactivated = 0, sended=2
 public smallint NOT NULL DEFAULT 0, 
 sent timestamp(0) with time zone DEFAULT now() NOT NULL,
 delivered smallint NOT NULL DEFAULT 0  -- news already sent to subscribers
 );

COMMENT ON COLUMN newsletters.status IS 'Define published or draft NL';
COMMENT ON COLUMN newsletters.sent IS 'Keeps date when NL was send to users';
COMMENT ON COLUMN newsletters.public IS 'Define if NL can be reach for anonymous user in browser';
COMMENT ON COLUMN newsletters.delivered IS 'set 1 if NL is already sent to users list';
