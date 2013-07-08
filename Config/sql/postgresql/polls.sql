-- Name: polls; Type: TABLE; Schema: public; Owner: www-data; Tablespace: 
CREATE TABLE polls (
    id serial PRIMARY KEY,
    question varchar(90) NOT NULL,
    created timestamp(0) with time zone DEFAULT now() NOT NULL,
    user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    status smallint DEFAULT 0 NOT NULL
);

INSERT INTO polls (question, user_id, status) VALUES ('Who is your favourite Renaissance Artist?', 1, 1);

-- Name: pollrows; Type: TABLE; Schema: public; Owner: www-data; Tablespace: 
CREATE TABLE pollrows (
    id serial PRIMARY KEY,
    poll_id int NOT NULL REFERENCES polls(id) ON DELETE CASCADE,
    answer varchar(130) NOT NULL,
    color varchar(15) DEFAULT 'green' NOT NULL,
    vote smallint DEFAULT 0 NOT NULL
);

INSERT INTO pollrows ("poll_id", "answer", "color", "vote") VALUES (1, 'Michelangelo',     'green',   0);
INSERT INTO pollrows ("poll_id", "answer", "color", "vote") VALUES (1, 'Raphael',          'orange',  0);
INSERT INTO pollrows ("poll_id", "answer", "color", "vote") VALUES (1, 'Leonardo Davinci', 'red',     0);
INSERT INTO pollrows ("poll_id", "answer", "color", "vote") VALUES (1, 'Other',            'blue',    0);
INSERT INTO pollrows ("poll_id", "answer", "color", "vote") VALUES (1, 'None',             'yellow',   0);
