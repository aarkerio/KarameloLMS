-- Name: quotes; Type: TABLE; Schema: public; Owner: www-data; Tablespace: 
CREATE TABLE quotes (
    id serial PRIMARY KEY,
    quote varchar(150) NOT NULL,
    author varchar(50) NOT NULL,
    user_id int REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO quotes (quote, author, user_id) VALUES ('Always forgive your enemies; nothing annoys them so much.', 'Oscar Wilde', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('I am not young enough to know everything.', 'Oscar Wilde', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('Seriousness is the only refuge of the shallow.', 'Oscar Wilde', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('Patriotism is the willingness to kill and be killed for trivial reasons.', 'Bertrand Rusell', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('There is much pleasure to be gained from useless knowledge.', 'Bertrand Rusell', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('The time you enjoy wasting is not wasted time', 'Bertrand Rusell', 1);

