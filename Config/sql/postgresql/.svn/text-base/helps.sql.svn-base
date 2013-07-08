-- Helps /help in admin section
CREATE TABLE helps (
 id serial PRIMARY KEY,
 title varchar(80) NOT NULL,
 url varchar(100) NOT NULL,
 help text NOT NULL,
 lang varchar(2) NOT NULL DEFAULT 'en'
);

ALTER TABLE helps ADD CONSTRAINT help_lang_url_key UNIQUE (lang, url);
