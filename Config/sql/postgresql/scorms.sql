-- Scorm tables 
CREATE TABLE scorms (
    id serial PRIMARY KEY,
    user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE, 
    license_id smallint NOT NULL REFERENCES licenses(id) ON DELETE CASCADE DEFAULT 1,
    lang_id smallint NOT NULL REFERENCES langs(id) ON DELETE CASCADE, 
    points smallint NOT NULL DEFAULT 0, 
    name varchar(255) NOT NULL,
    path varchar(140) NOT NULL, -- /webroot/files/scorms/{name_scorm}
    summary text NOT NULL,
    version varchar(40), -- SCORM 1.2 or 1.3
    maxgrade double precision DEFAULT 0 NOT NULL,
    grademethod smallint DEFAULT 0 NOT NULL,
    whatgrade smallint DEFAULT 0 NOT NULL,
    maxattempt smallint DEFAULT 1 NOT NULL, -- only in SCORM 1.2, 1.3 is defined in imsmanifest.xml 
    updatefreq smallint DEFAULT 0 NOT NULL,
    skipview smallint DEFAULT 1 NOT NULL, -- This allows a user to skip SCORM/AICC overviews
    hidebrowse smallint DEFAULT 0 NOT NULL,  -- hide something
    hidetoc smallint DEFAULT 0 NOT NULL, -- hide table of content
    hidenav smallint DEFAULT 0 NOT NULL,  -- hide nav
    auto smallint DEFAULT 0 NOT NULL, -- autostart ?
    display_order smallint DEFAULT 0 NOT NULL,
    status smallint NOT NULL DEFAULT 0, -- published / Draft
    popup smallint DEFAULT 0 NOT NULL -- 0=popup or 1=embedded
);

COMMENT ON TABLE scorms IS 'Each row is one SCORM element and its configuration';
COMMENT ON COLUMN scorms.points IS 'Sum masteryscore or raw in SCOs';


CREATE TABLE scorms_scos (
    "id" serial PRIMARY KEY,
    "scorm_id" int NOT NULL REFERENCES scorms(id) ON DELETE CASCADE,
    "item_id" int,       
    "type" varchar(90),
    "manifest" varchar(255),  -- CourseID
    "organization" varchar(255), -- CourseID
    "parent" varchar(255),  -- MANIFEST01_ITEM2
    "identifier" varchar(255),
    "identifierref" varchar(255),
    "launch" varchar(255) NOT NULL, --  i.e.  resources/7.html
    "scormtype" varchar(5), -- sco or asset
    "datafromlms" varchar(255),
    "maxtimeallowed" varchar(255),
    "timelimitaction" varchar(255),
    "prerequisites" varchar(255),
    "title" varchar(255),
    "masteryscore" smallint
);

COMMENT ON TABLE scorms IS 'Save Items and resources from imsmanifest.xml file.'; 
COMMENT ON COLUMN scorms.type IS 'item or resource';
COMMENT ON COLUMN scorms.item IS 'This can be null in ITEM but not in resource, this is the way we reconstruct the SCO three'; 

-- students answers and track
CREATE TABLE result_scorms (
  "id" serial NOT NULL UNIQUE,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "scorm_id" int NOT NULL REFERENCES scorms (id) ON DELETE CASCADE,
  "varname"  varchar(255),
  "varvalue" varchar(255),
  "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  "sco_id" int NOT NULL REFERENCES  scorms_scos(id) ON DELETE CASCADE,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL
);
COMMENT ON TABLE result_scorms IS 'Save SCORM grades.'; 


--Linking Kandie
CREATE TABLE "scorms_vclassrooms" (
 "id" serial PRIMARY KEY,
 "scorm_id" int NOT NULL REFERENCES scorms(id) ON DELETE CASCADE,
 "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
 "sdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "fdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "hidden" boolean NOT NULL DEFAULT True,
  UNIQUE  ("scorm_id", "vclassroom_id")
);

