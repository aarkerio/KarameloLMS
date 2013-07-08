-- Name: acos;
CREATE TABLE acos (
    id serial PRIMARY KEY,
    parent_id integer,
    model varchar(40),
    foreign_key integer,
    alias varchar(40),
    lft integer,
    rght integer
);

INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (1, NULL, '', NULL, 'controllers', 1, 120);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (2, 1, '', NULL, 'Entries', 2, 3);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (3, 1, '', NULL, 'Images', 4, 5);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (4, 1, '', NULL, 'Answers', 6,7);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (5, 1, '', NULL, 'Catglossaries', 8,9);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (6, 1, '', NULL, 'Glossaries', 10, 11);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (7, 1, '', NULL, 'Scorms', 12,13);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (8, 1, '', NULL, 'Lessons', 14,15);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (9, 1, '', NULL, 'Catfaqs', 16, 17);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (10, 1, '', NULL, 'Faqs', 18, 19);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (11, 1, '', NULL, 'Topics', 20, 21);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (12, 1, '', NULL, 'Quotes', 22, 23);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (13, 1, '', NULL, 'Acquitances', 24 , 25);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (14, 1, '', NULL, 'Comments', 26, 27);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (15, 1, '', NULL, 'Replies', 28, 29);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (16, 1, '', NULL, 'Participations', 30, 31);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (17, 1, '', NULL, 'Webquests', 32, 33);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (18, 1, '', NULL, 'Tests', 34, 35);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (19, 1, '', NULL, 'Gaps', 36, 37);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (20, 1, '', NULL, 'Treasures', 38, 39);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (21, 1, '', NULL, 'Scorms', 40, 41);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (22, 1, '', NULL, 'Ecourses', 42, 43);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (23, 1, '', NULL, 'Activities', 44, 45);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (24, 1, '', NULL, 'Vclassrooms', 46, 47);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (25, 1, '', NULL, 'Catforums', 48, 49);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (26, 1, '', NULL, 'Forums', 50, 51);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (27, 1, '', NULL, 'Images', 52, 53);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (28, 1, '', NULL, 'Shares', 54, 55);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (29, 1, '', NULL, 'Podcasts', 56, 57);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (30, 1, '', NULL, 'Messages', 58, 59);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (31, 1, '', NULL, 'Wikis', 60, 61);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (32, 1, '', NULL, 'Acquaintances', 62, 63);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (33, 1, '', NULL, 'Questions', 64, 65);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (34, 1, '', NULL, 'Reports', 66, 67);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (35, 1, '', NULL, 'Annotations', 68, 69);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (36, 1, '', NULL, 'Chats', 70, 71);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (37, 1, '', NULL, 'Knets', 72, 73);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (38, 1, '', NULL, 'PermanentClasses', 74, 75);

--Admins controllers
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (50, 1, '', NULL, 'Subjects', 80, 81);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (51, 1, '', NULL, 'Newsletters', 82, 83);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (52, 1, '', NULL, 'Collections', 84, 85);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (53, 1, '', NULL, 'Users', 86, 87);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (54, 1, '', NULL, 'Groups', 88, 89);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (55, 1, '', NULL, 'Helps', 90, 91);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (56, 1, '', NULL, 'Colleges', 92, 93);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (57, 1, '', NULL, 'Polls', 94,95);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (58, 1, '', NULL, 'Themes', 96,97);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (59, 1, '', NULL, 'News', 98,99);
INSERT INTO acos (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (60, 1, '', NULL, 'Discussions', 100, 101);



ALTER SEQUENCE "acos_id_seq" RESTART WITH 61;
 
-- Groups and users, aros table created in users.sql file (Web Installer)
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (1, NULL, 'Group', 1, 'Admins', 1, 4);
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (2, NULL, 'Group', 2, 'Teachers', 5, 6);
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (3, NULL, 'Group', 3, 'Students', 7,8);
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (4, NULL, 'Group', 4, 'Parents', 9, 10);

ALTER SEQUENCE "aros_id_seq" RESTART WITH 7;

CREATE TABLE aros_acos (
    id serial PRIMARY KEY,
    aro_id integer NOT NULL,
    aco_id integer NOT NULL,
    _create character varying(2) DEFAULT 0 NOT NULL,
    _read character varying(2) DEFAULT 0 NOT NULL,
    _update character varying(2) DEFAULT 0 NOT NULL,
    _delete character varying(2) DEFAULT 0 NOT NULL
);

--Admin permissions (ALL controllers)
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 1, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 2, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 3, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 4, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 5, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 6, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 7, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 8, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 9, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 10, '1', '1', '1', '1');   -- Faqs
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 11, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 12, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 13, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 14, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 15, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 16, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 17, '1', '1', '1', '1'); -- Webquests
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 18, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 19, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 20, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 21, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 22, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 23, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 24, '1', '1', '1', '1');  -- Vclassrooms
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 25, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 26, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 27, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 28, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 29, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 30, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 31, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 32, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 33, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 34, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 35, '1', '1', '1', '1'); 
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 36, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 37, '1', '1', '1', '1'); 
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 38, '1', '1', '1', '1'); -- < 50 = Admins and teachers sections
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 50, '1', '1', '1', '1'); -- > 50 = Only admins sections
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 51, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 52, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 53, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 54, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 55, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 56, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 57, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 58, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 59, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 60, '1', '1', '1', '1');


--Teachers permissions group_id=2
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 1, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 2, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 3, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 4, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 5, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 6, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 7, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 8, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 9, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 10, '1', '1', '1', '1'); --Faqs
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 11, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 12, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 13, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 14, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 15, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 16, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 17, '1', '1', '1', '1');   -- Webquests
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 18, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 19, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 20, '1', '1', '1', '1');  --Treasures
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 21, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 22, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 23, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 24, '1', '1', '1', '1');  -- Vclassrooms
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 25, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 26, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 27, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 28, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 29, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 30, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 31, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 32, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 33, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 34, '1', '1', '1', '1'); -- reports
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 35, '1', '1', '1', '1'); -- annotations
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 36, '1', '1', '1', '1'); -- chats
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 37, '1', '1', '1', '1'); -- knets
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 38, '1', '1', '1', '1'); -- PermanentClasses


-- ACL KML ends


