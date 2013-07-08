# Osmosis 
# SCORM PgSQL version GPLv3 Chipotle Software(c) 2009 

-- Table structure for table scorm_scorms
CREATE TABLE  scorm_scorms (
  id serial PRIMARY KEY,
  name varchar(255) NOT NULL,     
  file_name varchar(255) NOT NULL,
  description text NOT NULL,      
  version varchar(9) NOT NULL, 
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,  
  modified  timestamp(0) with time zone DEFAULT now() NOT NULL,  
  hash varchar(35) NOT NULL,  
  path text NOT NULL
);
COMMENT ON TABLE  scorm_scorms IS 'Represents a scorm Kandie asset';
COMMENT ON COLUMN scorm_scorms.version IS '1.2 or 2004';
COMMENT ON COLUMN scorm_scorms.hash IS 'hash sum of file reference';

-- Table structure for table scorm_scos
CREATE TABLE  scorm_scos (
  id serial PRIMARY KEY,
  scorm_id int NOT NULL REFERENCES scorm_scorms(id) ON DELETE CASCADE,
  parent_id int  NOT NULL,
  manifest varchar(255) NOT NULL, 
  organization varchar(255) NOT NULL,
  identifier varchar(255) NOT NULL, 
  href varchar(255),
  title varchar(255),
  completionThreshold varchar(3),
  parameters text,
  isvisible boolean NOT NULL DEFAULT True,
  attemptAbsoluteDurationLimit varchar(6),
  dataFromLMS text,
  attemptLimit varchar(10),
  scormType varchar(6)
);
COMMENT ON TABLE  scorm_scos IS 'Holds each SCO from a SCORM package';
COMMENT ON COLUMN scorm_scos.completionThreshold IS 'defines a threshold value that can be used by the SCO';
COMMENT ON COLUMN scorm_scos.isvisible IS 'indicates whether or not this SCO is displayed when the structure of the package is displayed or rendered';
COMMENT ON COLUMN scorm_scos.attemptAbsoluteDurationLimit IS 'maximum time duration that the learner is permitted to spend on any single learner attempt';
COMMENT ON COLUMN scorm_scos.dataFromLMS IS 'provides initialization data expected by the LMS';
COMMENT ON COLUMN scorm_scos.attemptLimit IS ' the maximum number of attempts for the activity';
COMMENT ON COLUMN scorm_scos.scormType IS 'type of SCORM resource';
COMMENT ON COLUMN scorm_scos.parameters IS 'static parameters to be passed to the resource at launch time';
COMMENT ON COLUMN scorm_scos.href IS 'Reference to the location to launch';
COMMENT ON COLUMN scorm_scos.identifier IS 'Identifier string for sco';
COMMENT ON COLUMN scorm_scos.organization IS 'The organization that contains this sco';

-- Table structure for table 'scorm_attendee_trackings'
CREATE TABLE scorm_attendee_trackings (
  "id" serial PRIMARY KEY,
  "sco_id" int NOT NULL REFERENCES scorm_scos(id) ON DELETE CASCADE,
  "student_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "datamodel_element" varchar(255) NOT NULL,
  "value" varchar(255) NOT NULL,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
  UNIQUE (sco_id,student_id,datamodel_element)
);
COMMENT ON TABLE scorm_attendee_trackings IS 'Keeps information of each sco relative to each student';
COMMENT ON COLUMN scorm_attendee_trackings.datamodel_element IS 'Some SCORM-RTE datamodel element';

-- Table structure for table scorm_choice_considerations
CREATE TABLE scorm_choice_considerations (
  id serial PRIMARY KEY,
  sco_id int NOT NULL REFERENCES scorm_scos(id) ON DELETE CASCADE,
  preventActivation boolean NOT NULL DEFAULT false,
  constrainChoice boolean NOT NULL DEFAULT false
);

-- Table structure for table scorm_conditions
CREATE TABLE scorm_conditions (
  id serial PRIMARY KEY,
  referencedObjective varchar(255),
  measureThreshold varchar(7),
  operator varchar(4) DEFAULT 'admin',
  ruleCondition varchar(27),
  rule_id int
);

-- Table structure for table scorm_control_modes
CREATE TABLE scorm_control_modes (
  id serial PRIMARY KEY,
  sco_id int NOT NULL REFERENCES scorm_scos(id) ON DELETE CASCADE,
  choiceExit boolean NOT NULL DEFAULT True,
  choice boolean NOT NULL DEFAULT True,
  flow boolean NOT NULL DEFAULT False,
  forwardOnly boolean NOT NULL DEFAULT False,
  useCurrentAttemptObjectiveInfo boolean NOT NULL DEFAULT True,
  useCurrentAttemptProgressInfo boolean NOT NULL DEFAULT True
);
COMMENT ON TABLE scorm_control_modes IS 'Sequence information container';

-- Table structure for table scorm_delivery_controls
CREATE TABLE  scorm_delivery_controls (
  id serial PRIMARY KEY,
  sco_id int NOT NULL REFERENCES scorm_scos(id) ON DELETE CASCADE,
  tracked boolean NOT NULL DEFAULT True,
  completionSetByContent boolean NOT NULL DEFAULT False,
  objectiveSetByContent boolean NOT NULL DEFAULT False
);
COMMENT ON TABLE  scorm_delivery_controls IS 'The sequence that activities must follow';

-- Table structure for table scorm_map_infos
CREATE TABLE  scorm_map_infos (
  id serial PRIMARY KEY,
  objective_id int NOT NULL,
  targetObjectiveID varchar(255) NOT NULL, -- COMMENT 'the identifier of the global shared objective',
  readSatisfiedStatus boolean DEFAULT True,
  readNormalizedMeasure boolean NOT NULL DEFAULT True,
  writeSatisfiedStatus boolean DEFAULT False,
  writeNormalizedMeasure boolean DEFAULT False
);
COMMENT ON TABLE  scorm_map_infos IS 'Represents the mapping of an activity s objective';

-- Table structure for table scorm_objectives
CREATE TABLE  scorm_objectives (
  "id" serial PRIMARY KEY,
  "sco_id" int NOT NULL REFERENCES scorm_scos(id) ON DELETE CASCADE,
  "satisfiedByMeasure" boolean DEFAULT False,  -- COMMENT 'indicates that minNormalizedMeasure shall be used intead of other method',
  "minNormalizedMeasure" varchar(3) NOT NULL DEFAULT '1.0', -- COMMENT 'identifies minimum satisfaction measure for the objective',
  "objectiveID" varchar(255) NOT NULL,  -- COMMENT 'objective ID',
  "primary" smallint NOT NULL DEFAULT 0  -- COMMENT 'indicates whether is a primary objective or not',
);
COMMENT ON TABLE scorm_objectives IS 'Identifies objectives that do not contribute to rollup assoc';


-- Table structure for table scorm_randomizations
CREATE TABLE  scorm_randomizations (
  id serial PRIMARY KEY,
  sco_id int NOT NULL,
  randomizationTiming varchar(16) DEFAULT 'never', -- COMMENT 'indicates when the ordering of the children of the activity should occur',
  selectCount int,   -- COMMENT 'indicates the number of child activities that must be selected',
  reorderChildren boolean NOT NULL DEFAULT False, -- COMMENT 'indicates that the order of the child activities is randomized',
  selectionTiming varchar(16) DEFAULT 'never'    --COMMENT 'indicates when the selection should occur'
);

-- Table structure for table scorm_rollups
CREATE TABLE  scorm_rollups (
  id serial PRIMARY KEY,
  sco_id int NOT NULL,
  rollupObjectiveSatisfied boolean DEFAULT True,
  rollupProgressCompletion boolean DEFAULT True,
  objectiveMeasureWeight varchar(20) DEFAULT '1.0000'
);

-- Table structure for table scorm_rollup_considerations
CREATE TABLE  scorm_rollup_considerations (
  id serial PRIMARY KEY,
  sco_id int NOT NULL REFERENCES scorm_scos(id) ON DELETE CASCADE,
  requiredForSatisfied varchar(15) NOT NULL DEFAULT 'always',
  requiredForNotSatisfied varchar(15) NOT NULL DEFAULT 'always',
  requiredForComplete varchar(15) NOT NULL DEFAULT 'always',
  requiredForIncomplete varchar(15) NOT NULL DEFAULT 'always',
  measureSatisfactionIfActive boolean NOT NULL DEFAULT True
);
COMMENT ON TABLE scorm_rollup_considerations IS 'RollupConsideration:indican cuándo una actividad debe ser i';

-- Table structure for table scorm_rules
CREATE TABLE  scorm_rules (
  id serial PRIMARY KEY,
  sco_id int DEFAULT NULL,
  type varchar(4) DEFAULT NULL,
  conditionCombination varchar(3) DEFAULT 'all',
  action varchar(20),
  minimumPercent varchar(6) DEFAULT '0.0000',
  minimumCount  varchar(5) DEFAULT '0',
  rollup_id int
);

-- Table structure for table scorm_sco_presentations
CREATE TABLE scorm_sco_presentations (
  id serial PRIMARY KEY,
  hideKey varchar(10) NOT NULL,
  sco_id int NOT NULL
);
COMMENT ON TABLE  scorm_sco_presentations IS 'Information about activities presentation';