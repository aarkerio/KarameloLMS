-- Español 
-- Three steps to create Text Full Search
-- This create a dictionary to create several kind of tokens : emails, number, lexems
-- lexems are created according language
CREATE TEXT SEARCH DICTIONARY karamelo_es (
    template  = snowball,
    language  = spanish,
    stopwords = spanish
);

-- A text search configuration specifies a text search parser that can divide a string into tokens, 
-- plus dictionaries that can be used to determine which tokens are of interest for searching.
-- See: http://developer.postgresql.org/pgdocs/postgres/textsearch-configuration.html
CREATE TEXT SEARCH CONFIGURATION public.karamelo_es ( COPY = pg_catalog.spanish ); 

-- FTS (Full Text Search) index = Storing preprocessed documents optimized for searching
--Also allow create ranked searchs
-- A data type "tsvector" is provided for storing preprocessed documents
-- For text search purposes, each document (text field) must be reduced to the preprocessed tsvector format.
CREATE INDEX pgnews_idx  ON news       USING gin(to_tsvector('karamelo_es', body));
CREATE INDEX pgentr_idx  ON entries    USING gin(to_tsvector('karamelo_es', body));
CREATE INDEX pgpod_idx   ON podcasts   USING gin(to_tsvector('karamelo_es', description));
CREATE INDEX users_idx   ON users      USING gin(to_tsvector('karamelo_es', cv));

-- English
CREATE TEXT SEARCH DICTIONARY karamelo_en (
    template  = snowball,
    language  = english,
    stopwords = english
);

CREATE TEXT SEARCH CONFIGURATION public.karamelo_en ( COPY = pg_catalog.english ); 

CREATE INDEX pgnews_idx ON news USING gin(to_tsvector('karamelo_en', body));
CREATE INDEX pgentr_idx ON entries USING gin(to_tsvector('karamelo_en', body));
CREATE INDEX pgless_idx ON lessons USING gin(to_tsvector('karamelo_en', body));
CREATE INDEX pgglo_idx ON glossaries USING gin(to_tsvector('karamelo_en', definition));
CREATE INDEX pgpod_idx ON podcasts USING gin(to_tsvector('karamelo_en', description));
CREATE INDEX users_idx ON users USING gin(to_tsvector('karamelo_en', cv));
CREATE INDEX lessons_idx ON lessons USING gin(to_tsvector('english', body));

-- German (ToDo)
--CREATE TEXT SEARCH DICTIONARY karamelo_de (
--    template  = snowball,
--    language  = german,
--    stopwords = german
--);
--CREATE TEXT SEARCH CONFIGURATION public.karamelo_de ( COPY = pg_catalog.german ); 
--CREATE INDEX pgnews_idx ON news USING gin(to_tsvector('karamelo_de', body));
--CREATE INDEX pgentr_idx ON entries USING gin(to_tsvector('karamelo_de', body));
--CREATE INDEX pgless_idx ON lessons USING gin(to_tsvector('karamelo_de', body));
--CREATE INDEX pgglo_idx ON glossaries USING gin(to_tsvector('karamelo_de', definition));
--CREATE INDEX pgpod_idx ON podcasts USING gin(to_tsvector('karamelo_de', description));
--CREATE INDEX users_idx ON users USING gin(to_tsvector('karamelo_de', cv));
--CREATE INDEX lessons_idx ON lessons USING gin(to_tsvector('spanish', body));
