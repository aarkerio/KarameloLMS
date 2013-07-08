-- @Package: Test
-- Test model tables beggins
CREATE TABLE "tests" (
  "id" serial PRIMARY KEY,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "title" varchar(50),
  "description" text NOT NULL,
  "status" smallint NOT NULL DEFAULT 0 CHECK (status IN (1, 0)),
  "archived" boolean NOT NULL DEFAULT False,
  "knet" smallint NOT NULL DEFAULT 0,
  "type" smallint NOT NULL DEFAULT 0
);

COMMENT ON TABLE tests IS 'Quizz tests';
COMMENT ON COLUMN tests.type IS 'One view or wizard';


CREATE TABLE "questions" (
  "id" serial PRIMARY KEY,
  "question" text NOT NULL,
  "hint" varchar(150) NOT NULL,
  "explanation" text NOT NULL,
  "test_id" int NOT NULL REFERENCES tests(id) ON DELETE CASCADE,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "status" smallint NOT NULL DEFAULT 0,
  "worth" smallint NOT NULL DEFAULT 1,
  "type" smallint NOT NULL DEFAULT 1,
  "order" smallint NOT NULL DEFAULT 1
);

COMMENT ON TABLE questions IS 'Questions in tests, hasMany Answer';
COMMENT ON COLUMN questions.hint IS 'Optional hint to student';
COMMENT ON COLUMN questions.type IS '1=multiple options, 2=open answer';
COMMENT ON COLUMN questions.order IS 'Order in test';

CREATE TABLE "answers" (
  "id" serial PRIMARY KEY,
  "answer" varchar(150) NOT NULL,
  "correct" smallint NOT NULL,
  "question_id" int NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

COMMENT ON TABLE answers IS 'Answers to Question Model, Test module';
COMMENT ON COLUMN answers.correct IS 'wrong = 0, correct = 1';


--  Tests student results
CREATE TABLE results ( 
  "id" serial NOT NULL UNIQUE,
  "user_id" int NOT NULL REFERENCES users(id) ON DELETE CASCADE,    -- student id
  "question_id" int NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
  "answer_id" int,
  "answer" text,
  "correct" smallint NOT NULL DEFAULT 0,
  "test_id" int NOT NULL REFERENCES tests(id) ON DELETE CASCADE,
  "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  "checked" smallint NOT NULL DEFAULT 0,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
   PRIMARY KEY (user_id, test_id, vclassroom_id, question_id));

COMMENT ON TABLE results IS 'Student answers to quizz tests HABTM relationship';
COMMENT ON COLUMN results.answer_id IS 'Answer to multiple option, is not used in open questions';
COMMENT ON COLUMN results.answer IS 'Answer to open questions';
COMMENT ON COLUMN results.correct IS 'Answer to open questions: correct or wrong';

--  Tests student results
CREATE TABLE "tests_students" ( 
  "id" serial NOT NULL UNIQUE,
  "user_id" int NOT NULL,   
  "test_id" int NOT NULL,
  "vclassroom_id" int NOT NULL,
  "checked" smallint NOT NULL DEFAULT 0,
  "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
   PRIMARY KEY (user_id, test_id, vclassroom_id)
);

COMMENT ON TABLE tests_students IS 'Test answered by student,graded and sent by teacher';
COMMENT ON COLUMN tests_students.checked IS 'If 1 teacher has sent tests result to students email manually';

-- Linking Kandie
CREATE TABLE "tests_vclassrooms" (
 "id" serial PRIMARY KEY,
 "test_id" int NOT NULL REFERENCES tests(id) ON DELETE CASCADE,
 "vclassroom_id" int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
 "sdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "fdate"  timestamp(0) with time zone DEFAULT now() NOT NULL,
 "hidden" boolean NOT NULL DEFAULT True,
  UNIQUE  ("test_id", "vclassroom_id")
);

