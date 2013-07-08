CREATE TABLE themes (  -- News themes with image each one
  id serial PRIMARY KEY,
  theme varchar(40) NOT NULL,
  description varchar(400) NOT NULL,
  img varchar(80) NOT NULL
);

INSERT INTO themes ("theme", "description", "img") VALUES ('Biology', 'All about biology', 'theme-biology.png');
INSERT INTO themes ("theme", "description", "img") VALUES ('Announcement', 'Announcement', 'theme-announcement.png');
INSERT INTO themes ("theme", "description", "img") VALUES ('Fun', 'Fun stuff', 'theme-fun.png');

-- Name: news; Type: TABLE; Schema: public; Owner: www-data; Tablespace: 
CREATE TABLE news (     -- News on index portal page
  id serial PRIMARY KEY,
  title varchar(150) NOT NULL,
  body text NOT NULL,
  created timestamp(0) with time zone DEFAULT now() NOT NULL,
  reference varchar(350),
  theme_id int NOT NULL REFERENCES themes(id) ON DELETE CASCADE,
  status smallint NOT NULL,   -- 0 = draft, 1 = published
  user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  comments int NOT NULL DEFAULT 0  -- 1 = the comments in this new are ctived
);

-- full text search index
CREATE INDEX news_idx ON news USING gin(to_tsvector('spanish', body));

COMMENT ON TABLE news IS 'Institutional news, frontend portal';
COMMENT ON COLUMN news.status IS 'Define published or draft entry';
COMMENT ON COLUMN news.reference IS 'Optional field. Reference new';

INSERT INTO news ("title", "body", "reference", "theme_id", "status", "user_id") VALUES ('What is a Webquest?', 
'<p>A WebQuest is an inquiry-oriented lesson format in which most or all the information that learners work with comes from the web. The model was developed by Bernie Dodge  at San Diego State University in February, 1995 with early input from SDSU/Pacific Bell Fellow Tom March, the Educational Technology staff at San Diego Unified School District, and waves of participants each summer at the Teach the Teachers Consortium.</p><p>Since those beginning days, tens of thousands of teachers have embraced WebQuests as a way to make good use of the internet while engaging their students in the kinds of thinking that the 21st century requires. The model has spread around the world, with special enthusiasm in Brazil, Spain, China, Australia and Holland.</p><p>To find out more, explore <a href="http://webquest.org">the Webquest site</a>.</p>','http://webquest.org',2, 1, 1);

INSERT INTO news ("title", "body", "reference", "theme_id", "status", "user_id") VALUES ('Create edublogs to share and teach', '<p>In Karamelo each teacher has his/her own and personal space to writes posts, share documents, videos and podcasts, give lessons, etc. Edublog is also the the place where Virtual Classrooms (<i>vClassrooms</i>) are showed.</p><p>Karamelo is Web 2.0: is a social and personal network.</p><p style="text-align:center;"><img src="/img/imghelps/teach/mod1/blog_diag.png" alt="edublog" title="edublog" /></p>','http://www.teachersfirst.com/summer/webquest/quest-b.shtml',2, 1, 1);

INSERT INTO news ("title", "body", "reference", "theme_id", "status", "user_id") VALUES ('Welcome to Karamelo!', 
'<p>Karamelo is a cool, open e-Learning platform. We believe that well made sotware is fun to use.</p><p>This is the College Front end wgere you can publish news, tips and events to maintain Campus informed. You can found this layout in <i>APP/views/layouts/portal.ctp</i>.</p><p>In order to publish a new eCourse you must follow four simple steps:</p><ol><li>Create a course</li><li>Define course activities</li><li>Create a vClassroom to impart the course</li><li>Invite your students</li></ol><p>Please let us know what do you want to see on Karamelo in next next releases.</p><p><b>Note</b>:If you are admin user you must change <a href="/admin/groups/listing">groups codes</a> this code allows visitors Sign Up in this portal.</p>',
'http://www.chipotle-software.com/',3, 1, 1);

-- Discussions on portal news
CREATE TABLE discussions (
 "id" serial PRIMARY KEY,
 "new_id" int NOT NULL REFERENCES news(id) ON DELETE CASCADE,
 "name" varchar(100),
 "email" varchar(80),
 "website" varchar(250),
 "comment" text NOT NULL,
 "created" timestamp(0) with time zone DEFAULT now() NOT NULL,
 "level" int NOT NULL,
 "discussion_id" int NOT NULL,
 "user_id" int REFERENCES users(id) NOT NULL,
 "status" int NOT NULL DEFAULT 1
);
