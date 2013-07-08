#
#  KARAMELO MySQL TABLES   #- Chipotle-Software 2006-2012
#  Still in Beta!!
#

# Table keeping college information
CREATE TABLE colleges (
  id serial PRIMARY KEY,
  urlbase varchar(150) NOT NULL,
  name varchar(150) NOT NULL,
  description text NOT NULL,
  email varchar(40) NOT NULL,
  keywords varchar(200) NOT NULL,
  logo varchar(60) NOT NULL DEFAULT 'cwclogo.jpg',
  sp boolean,
  gcalendar_id varchar(80),
  twitter varchar(60),
  user_id smallint NOT NULL DEFAULT 1
) Engine=InnoDB;

INSERT INTO colleges (urlbase, name, description, email, keywords) VALUES ('http://www.chipotle-software.com', 'Chipotle Cool College', 'Chipotle Cool College','email@test.edu', 'education');

#  Knets
CREATE TABLE ktypes (
   id tinyint PRIMARY KEY,
   edi varchar(90) NOT NULL UNIQUE    # Didactic element
);

INSERT INTO ktypes (id, edi) VALUES (1, 'Lesson');
INSERT INTO ktypes (id, edi) VALUES (2, 'Gap filling');
INSERT INTO ktypes (id, edi) VALUES (3, 'Webquest');
INSERT INTO ktypes (id, edi) VALUES (4, 'Scavenger hunt');
INSERT INTO ktypes (id, edi) VALUES (5, 'Squeeze test');
INSERT INTO ktypes (id, edi) VALUES (6, 'WikPage');
INSERT INTO ktypes (id, edi) VALUES (7, 'Podcast');
INSERT INTO ktypes (id, edi) VALUES (8, 'FAQ');
INSERT INTO ktypes (id, edi) VALUES (9, 'Glossary');
INSERT INTO ktypes (id, edi) VALUES (10, 'Image');
INSERT INTO ktypes (id, edi) VALUES (11, 'SCORM');

# Knets
CREATE TABLE knets (   #  knets
   id serial PRIMARY KEY,
   title varchar(90) NOT NULL,
   subject_id tinyint NOT NULL REFERENCES subjects(id),
   ktype_id tinyint  NOT NULL REFERENCES ktypes(id),
   description varchar(200),   # set textarea in view
   created timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
   modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
   disc int NOT NULL DEFAULT 0,
   status int NOT NULL DEFAULT 0,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   rank int NOT NULL DEFAULT 0, # recommended Kandie
   visits int NOT NULL DEFAULT 0
);

#Subjects
CREATE TABLE subjects (
 id serial PRIMARY KEY,
 code varchar(8) NOT NULL UNIQUE,
 title varchar(80) NOT NULL UNIQUE
) Engine=InnoDB;

INSERT INTO subjects (code, title) VALUES ('0001', 'Mathematics');
INSERT INTO subjects (code, title) VALUES ('0002', 'English');
INSERT INTO subjects (code, title) VALUES ('0003', 'History');
INSERT INTO subjects (code, title) VALUES ('0004', 'Art');
INSERT INTO subjects (code, title) VALUES ('0005', 'Philosophy');
INSERT INTO subjects (code, title) VALUES ('0006', 'Music');
INSERT INTO subjects (code, title) VALUES ('0007', 'Psichology');

# Messages between users
CREATE TABLE messages (
    id serial PRIMARY KEY,
    title varchar(90) NOT NULL,
    body text NOT NULL,
    created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
    level int NOT NULL DEFAULT 0,  # build the message thread if reply exist
    sender_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE, # Who send the message
    user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,  # Who receive the message
    status tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

CREATE TABLE themes (  # News themes with image each one
  id serial PRIMARY KEY,
  theme varchar(40) NOT NULL,
  description varchar(400) NOT NULL,
  img varchar(80) NOT NULL
) Engine=InnoDB;

INSERT INTO themes (theme, description, img) VALUES ('Biology', 'All about biology', 'theme-biology.png');
INSERT INTO themes (theme, description, img) VALUES ('Announcement', 'Announcement', 'theme-announcement.png');
INSERT INTO themes (theme, description, img) VALUES ('Fun', 'Fun stuff', 'theme-fun.png');

CREATE TABLE news (     # News on index portal page
  id serial PRIMARY KEY,
  title varchar(150) NOT NULL,
  body text NOT NULL,
  created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  reference varchar(350) NOT NULL,
  theme_id int NOT NULL REFERENCES themes(id) ON DELETE CASCADE,
  status tinyint NOT NULL,   # 0 = draft, 1 = published
  user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  comments int NOT NULL DEFAULT 0,  # 1 = the comments in this new are ctived
  FULLTEXT (title,body)
) Engine=MyISAM;

INSERT INTO news (title, body, reference, theme_id, status, user_id) VALUES ('What is a Webquest?',
'<p>A WebQuest is an inquiry-oriented lesson format in which most or all the information that learners work with comes from the web. The model was developed by Bernie Dodge  at San Diego State University in February, 1995 with early input from SDSU/Pacific Bell Fellow Tom March, the Educational Technology staff at San Diego Unified School District, and waves of participants each summer at the Teach the Teachers Consortium.</p><p>Since those beginning days, tens of thousands of teachers have embraced WebQuests as a way to make good use of the internet while engaging their students in the kinds of thinking that the 21st century requires. The model has spread around the world, with special enthusiasm in Brazil, Spain, China, Australia and Holland.</p><p>To find out more, explore <a href="http://webquest.org">the Webquest site</a>.</p>','http://webquest.org',2, 1, 1);

INSERT INTO news (title, body, reference, theme_id, status, user_id) VALUES ('Create edublogs to share and teach', '<p>In Karamelo each teacher has his/her own and personal space to writes posts, share documents, videos and podcasts, give lessons, etc. Edublog is also the the place where Virtual Classrooms (<i>vClassrooms</i>) are showed.</p><p>Karamelo is Web 2.0: is a social and personal network.</p><p style="text-align:center;"><img src="/img/imghelps/teach/mod1/blog_diag.png" alt="edublog" title="edublog" /></p>','http://www.teachersfirst.com/summer/webquest/quest-b.shtml',2, 1, 1);

INSERT INTO news (title, body, reference, theme_id, status, user_id) VALUES ('Welcome to Karamelo!',
'<p>Karamelo is a cool, open e-Learning platform. We believe that well made sotware is fun to use.</p><p>This is the College Front end wgere you can publish news, tips and events to maintain Campus informed. You can found this layout in <i>APP/views/layouts/portal.ctp</i>.</p><p>In order to publish a new eCourse you must follow four simple steps:</p><ol><li>Create a course</li><li>Define course activities</li><li>Create a vClassroom to impart the course</li><li>Invite your students</li></ol><p>Please let us know what do you want to see on Karamelo in next next releases.</p><p><b>Note</b>:If you are admin user you must change <a href="/admin/groups/listing">groups codes</a> this code allows visitors Sign Up in this portal.</p>',
'http://www.chipotle-software.com/',3, 1, 1);


# Discussions on portal news
CREATE TABLE discussions (
 id serial PRIMARY KEY,
 new_id int NOT NULL REFERENCES news(id) ON DELETE CASCADE,
 name varchar(100),
 email varchar(100),
 website varchar(250),
 comment text NOT NULL,
 created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
 level int NOT NULL,
 discussion_id int NOT NULL,
 user_id int REFERENCES users(id),
 status int NOT NULL DEFAULT 1
) Engine=MyISAM;

#Licenses
CREATE TABLE licenses (
 `id` serial PRIMARY KEY,
 `title` varchar(150) NOT NULL,
 `description` text
) Engine=InnoDB;

INSERT INTO licenses (title) VALUES ('Creative Commons Non-Commercial');
INSERT INTO licenses (title) VALUES ('GNU Documentation License');
INSERT INTO licenses (title) VALUES ('CopyRigth License');

CREATE TABLE ecourses (
  `id` serial PRIMARY KEY,
  `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  `subject_id` int NOT NULL REFERENCES subjects(id) ON DELETE CASCADE,
  `title` varchar(110) NOT NULL,
  `description` text,
  `percentage` tinyint NOT NULL DEFAULT 60,
  `created` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `status` tinyint DEFAULT 0 NOT NULL,
  `knet` tinyint DEFAULT 0 NOT NULL,
  `public` tinyint DEFAULT 0 NOT NULL,
  `lang_id` int NOT NULL REFERENCES langs(id),
  `code` varchar(13)
) Engine=InnoDB;

CREATE TABLE vclassrooms (
    `id` serial PRIMARY KEY,
    `name` varchar(150) NOT NULL,
    `created` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `status` tinyint DEFAULT 0 NOT NULL,
    `historical` tinyint DEFAULT 0 NOT NULL,
    `ecourse_id` int NOT NULL REFERENCES ecourses(id) ON DELETE CASCADE,
    `secret` varchar(10),
    `message` boolean NOT NULL DEFAULT True,
    `sdate` date NOT NULL DEFAULT '1970-01-01',    # starting date
    `fdate` date NOT NULL DEFAULT '1970-01-01',    # finish date
    `access` tinyint NOT NULL DEFAULT 0,
    `chat` tinyint NOT NULL DEFAULT 0,      # active / desactive chat
    `videoconference` tinyint NOT NULL DEFAULT 0,    # active / desactive FLV stream
    `streaming` text,
    `evaluation` tinyint NOT NULL DEFAULT 0,
    `diploma` tinyint NOT NULL DEFAULT 0,    # active / desactive chat
    `gcalendar_id` varchar(90)
) Engine=InnoDB;

CREATE TABLE activities (
    `id` serial PRIMARY KEY,
    `title` varchar(40) NOT NULL,
    `created` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `orders` tinyint DEFAULT 1 NOT NULL,    # order palabra reservada mysql
    `status` tinyint DEFAULT 0 NOT NULL,
    `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    `ecourse_id` int NOT NULL REFERENCES ecourses(id) ON DELETE CASCADE,
    `activity` text NOT NULL,
    `points` tinyint NOT NULL DEFAULT 0,
    `minutes` tinyint NOT NULL DEFAULT 0,
    `order` tinyint NOT NULL DEFAULT 0,
    `notes` text # teacher notes
) Engine=InnoDB;

CREATE TABLE users_vclassrooms (
  `id` serial PRIMARY KEY,
  `user_id` int  NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  `kind` tinyint NOT NULL DEFAULT 0,
  UNIQUE (user_id, vclassroom_id)
) Engine=InnoDB;

# ** Forums tables beggins **
CREATE TABLE catforums (  # forums categories
  `id` serial PRIMARY KEY,
  `title` varchar(150) NOT NULL,
  `description` varchar(150) NOT NULL,
  `created` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `user_id` integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  `status` tinyint NOT NULL DEFAULT 0 # Enabled = 1,  Disabled = 0
) Engine=InnoDB;

CREATE TABLE forums (
  id serial PRIMARY KEY,
  title varchar(150) NOT NULL,
  description varchar(500) NOT NULL,
  user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  vclassroom_id integer NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  catforum_id integer NOT NULL REFERENCES catforums(id) ON DELETE CASCADE,
  status tinyint NOT NULL DEFAULT 0  # Activated = 1,  Deactivated=0
) Engine=InnoDB;

CREATE TABLE topics ( # question and aswers in forums
  id serial PRIMARY KEY,
  subject varchar(150) NOT NULL,
  message text NOT NULL,
  created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  forum_id integer NOT NULL REFERENCES forums(id) ON DELETE CASCADE,
  vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,    # just one facility to create students reports
  user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  status int NOT NULL DEFAULT 1,
  views int NOT NULL DEFAULT 0,  # number of times the topic has been seen
  FULLTEXT (subject,message)
) Engine=MyISAM;

CREATE TABLE replies ( # replies to topics in forums
  id serial PRIMARY KEY,
  reply text NOT NULL,
  created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  topic_id integer NOT NULL REFERENCES topics(id) ON DELETE CASCADE,
  vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,    # just one facility to create students reports
  user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  points tinyint NOT NULL DEFAULT 0,
  status int NOT NULL DEFAULT 1
) Engine=InnoDB;

CREATE TABLE visitors ( #save user id visitors on topics
  id serial PRIMARY KEY,
  user_id   int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  topic_id  int NOT NULL REFERENCES topics(id) ON DELETE CASCADE
) Engine=InnoDB;

# News letters
CREATE TABLE newsletters (
 id serial PRIMARY KEY,
 title varchar(150) NOT NULL,
 body text NOT NULL,
 created timestamp  DEFAULT CURRENT_TIMESTAMP,
 user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
 status tinyint NOT NULL DEFAULT 0, # Activated = 1,  Deactivated = 0, sended=2
 public tinyint NOT NULL DEFAULT 0,
 sent timestamp DEFAULT '0000-00-00 00:00:00',
 delivered tinyint NOT NULL DEFAULT 0,  # news already sent to subscribers
 FULLTEXT (title,body)
 ) Engine=MyISAM;

#Gallerys
CREATE TABLE galleries (
 id serial PRIMARY KEY,
 title varchar(150) NOT NULL,
 description text,
 status int NOT NULL DEFAULT 0,
 user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE
) Engine=InnoDB;

# photos gallerys
CREATE TABLE photos (
   id serial PRIMARY KEY,
   gallery_id int REFERENCES galleries (id),  #id gallery
   file varchar(30) NOT NULL,
   title varchar(30) NOT NULL,
   description text,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   karanet tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

# Name: polls
CREATE TABLE polls (
    id serial PRIMARY KEY,
    question varchar(130) NOT NULL,
    created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_id integer NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    status tinyint DEFAULT 0 NOT NULL
) Engine=InnoDB;

INSERT INTO polls (question, user_id, status) VALUES ('Who is your favourite Renaissance Artist?', 1, 1);

CREATE TABLE pollrows (
    id serial PRIMARY KEY,
    poll_id int NOT NULL REFERENCES polls(id) ON DELETE CASCADE,
    answer varchar(130) NOT NULL,
    color varchar(15) DEFAULT 'green' NOT NULL,
    vote tinyint DEFAULT 0 NOT NULL
) Engine=InnoDB;

INSERT INTO pollrows (poll_id, answer, color, vote) VALUES (1, 'Michelangelo',     'green',   0);
INSERT INTO pollrows (poll_id, answer, color, vote) VALUES (1, 'Raphael',          'orange',  0);
INSERT INTO pollrows (poll_id, answer, color, vote) VALUES (1, 'Leonardo Davinci', 'red',     0);
INSERT INTO pollrows (poll_id, answer, color, vote) VALUES (1, 'Other',            'blue',    0);
INSERT INTO pollrows (poll_id, answer, color, vote) VALUES (1, 'None',             'yellow',  0);


CREATE TABLE quotes (
    id serial PRIMARY KEY,
    quote varchar(150) NOT NULL,
    author varchar(50) NOT NULL,
    user_id int REFERENCES users(id) ON DELETE CASCADE
) Engine=InnoDB;

INSERT INTO quotes (quote, author, user_id) VALUES ('Always forgive your enemies; nothing annoys them so much.', 'Oscar Wilde', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('I am not young enough to know everything.', 'Oscar Wilde', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('Seriousness is the only refuge of the shallow.', 'Oscar Wilde', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('Patriotism is the willingness to kill and be killed for trivial reasons.', 'Bertrand Rusell', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('There is much pleasure to be gained from useless knowledge.', 'Bertrand Rusell', 1);
INSERT INTO quotes (quote, author, user_id) VALUES ('The time you enjoy wasting is not wasted time', 'Bertrand Rusell', 1);

# Categories users blogs
CREATE TABLE categories (
 id serial PRIMARY KEY,
 title varchar(90) NOT NULL,
 user_id int REFERENCES users (id) ON DELETE CASCADE
) Engine=InnoDB;

INSERT INTO categories (title, user_id) VALUES ('General', 1);
INSERT INTO categories (title, user_id) VALUES ('History', 1);
INSERT INTO categories (title, user_id) VALUES ('Movie Review', 1);
INSERT INTO categories (title, user_id) VALUES ('Book Review', 1);

# Sections blogs
CREATE TABLE themeblogs (
 id serial PRIMARY KEY,
 title varchar(110) NOT NULL,
 user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE
) Engine=InnoDB;

# entries in the users blogs
CREATE TABLE entries (
   `id` serial PRIMARY KEY,
   `title` varchar(50) NOT NULL,
   `body` text NOT NULL,
   `subject_id` int REFERENCES subjects (id) ON DELETE CASCADE,
   `created` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   `status` int NOT NULL DEFAULT 0,
   `user_id` int REFERENCES users(id) ON DELETE CASCADE,
   `order` tinyint NOT NULL DEFAULT 0
   `discussion` int NOT NULL DEFAULT 0,  # discussion, Activ/Desactiv   1/0
   `knet` tinyint NOT NULL DEFAULT 0,
   FULLTEXT (title,body)
) Engine=MyISAM;

CREATE TABLE comments (    #comments in blogs
   id serial PRIMARY KEY,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   comment text,
   user_id int REFERENCES users (id) ON DELETE CASCADE,
   blogger_id int REFERENCES users(id) ON DELETE CASCADE,
   username varchar(20) NOT NULL,
   email varchar(60),
   website varchar(120),
   entry_id int REFERENCES entries (id) ON DELETE CASCADE,
   status tinyint NOT NULL DEFAULT 1
) Engine=InnoDB;


CREATE TABLE lessons (
   id serial PRIMARY KEY,
   title varchar(90) NOT NULL,
   subject_id int NOT NULL REFERENCES subjects(id),
   license_id tinyint NOT NULL REFERENCES licenses(id),   # DEFAULT 6,
   body text NOT NULL,
   created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
   modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
   disc int NOT NULL DEFAULT 0,   #discussion (comments) actived
   status int NOT NULL DEFAULT 0,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   rank int NOT NULL DEFAULT 0,
   visits int NOT NULL DEFAULT 0,
   knet tinyint NOT NULL DEFAULT 0,
   public tinyint NOT NULL DEFAULT 0,
   FULLTEXT (title,body)
) Engine=MyISAM;

CREATE TABLE contributions (
   id serial PRIMARY KEY,
   created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   comment text NOT NULL,
   username varchar(40) NOT NULL,
   email varchar(60) NOT NULL,
   website varchar(200) NOT NULL,
   entry_id int,
   lesson_id int,
   news_id int,
   status tinyint NOT NULL DEFAULT 1,
   type tinyint NOT NULL DEFAULT 1
)Engine=InnoDB;

# Discussions on lessons (static page
CREATE TABLE discussions (
   id serial PRIMARY KEY,
   comment text,
   level int NOT NULL,
   discussion_id int NOT NULL,
   username varchar(20) NOT NULL DEFAULT '',
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   lesson_id int NOT NULL REFERENCES lessons(id) ON DELETE CASCADE,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL
) Engine=InnoDB;

# bloggers links
CREATE TABLE acquaintances (
   id serial PRIMARY KEY,
   name varchar(50) NOT NULL,
   url varchar(250),
   user_id int REFERENCES users(id) ON DELETE CASCADE,
   description text
) Engine=InnoDB;

# FAQs categories
CREATE TABLE catfaqs (
   id serial PRIMARY KEY,
   title varchar(120) NOT NULL,
   description varchar(250) NOT NULL,
   user_id int REFERENCES users(id) ON DELETE CASCADE,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   status int NOT NULL DEFAULT 0,
   knet tinyint NOT NULL DEFAULT 0,
 public tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

# FAQs
CREATE TABLE faqs (
   id serial PRIMARY KEY,
   question varchar(120) NOT NULL,
   answer text NOT NULL,
   catfaq_id int REFERENCES catfaqs (id) ON DELETE CASCADE,
   license_id tinyint NOT NULL REFERENCES licenses(id),    # DEFAULT 6,
   user_id int REFERENCES users (id) ON DELETE CASCADE,
   display tinyint NOT NULL DEFAULT 1,   # order
   status int NOT NULL DEFAULT 0
) Engine=InnoDB;

# Glossaries categories
CREATE TABLE catglossaries (
   id serial PRIMARY KEY,
   title varchar(100) NOT NULL,
   description text NOT NULL,
   user_id int REFERENCES users (id) ON DELETE CASCADE,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   status int NOT NULL DEFAULT 0,
   knet tinyint NOT NULL DEFAULT 0,
   public tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

# Glossaries
CREATE TABLE glossaries (
   id serial PRIMARY KEY,
   catglossary_id int REFERENCES catglossaries (id) ON DELETE CASCADE,
   license_id tinyint NOT NULL REFERENCES licenses(id) , # DEFAULT 6,
   item varchar(120) NOT NULL,
   definition text NOT NULL,
   display tinyint NOT NULL DEFAULT 1, # order
   status tinyint NOT NULL DEFAULT 1,
   user_id int REFERENCES users (id) ON DELETE CASCADE,
   FULLTEXT (item,definition)
) Engine=MyISAM;

# Helps /help in Karamelo
CREATE TABLE helps (
   id serial PRIMARY KEY,
   title varchar(80) NOT NULL,
   url varchar(100) NOT NULL,
   help text NOT NULL,
   lang varchar(2) NOT NULL DEFAULT 'en',
   FULLTEXT (title,help)
) Engine=MyISAM;

ALTER TABLE helps ADD CONSTRAINT help_lang_url_key UNIQUE (lang, url);

CREATE TABLE cake_sessions (
   id varchar(255) NOT NULL DEFAULT '' PRIMARY KEY,
   data text,
   expires integer
) Engine=InnoDB;

CREATE TABLE images (
   id serial PRIMARY KEY,
   file varchar(40) NOT NULL UNIQUE,
   user_id int REFERENCES users(id) ON DELETE CASCADE
) Engine=InnoDB;

CREATE TABLE types (
  id serial PRIMARY KEY,
  type varchar(80) NOT NULL UNIQUE
) Engine=InnoDB;

INSERT INTO types (type) VALUES ('Book');
INSERT INTO types (type) VALUES ('Magazine');
INSERT INTO types (type) VALUES ('Newspaper');
INSERT INTO types (type) VALUES ('DVD');
INSERT INTO types (type) VALUES ('CD');


CREATE TABLE clasifications (
  id serial PRIMARY KEY,
  name varchar(80) NOT NULL UNIQUE
) Engine=InnoDB;

INSERT INTO clasifications (name) VALUES ('Computers & Internet');
INSERT INTO clasifications (name) VALUES ('Reference');
INSERT INTO clasifications (name) VALUES ('Business & Investing');
INSERT INTO clasifications (name) VALUES ('Professional & Technical');
INSERT INTO clasifications (name) VALUES ('Nonfiction');
INSERT INTO clasifications (name) VALUES ('Entertainment');
INSERT INTO clasifications (name) VALUES ('Science');
INSERT INTO clasifications (name) VALUES ('History ');
INSERT INTO clasifications (name) VALUES ('Health, Mind & Body');
INSERT INTO clasifications (name) VALUES ('Arts & Photography');
INSERT INTO clasifications (name) VALUES ('Medicine');
INSERT INTO clasifications (name) VALUES ('Home & Garden');
INSERT INTO clasifications (name) VALUES ('Literature & Fiction');
INSERT INTO clasifications (name) VALUES ('Law');
INSERT INTO clasifications (name) VALUES ('Children s Books');
INSERT INTO clasifications (name) VALUES ('Biographies & Memoirs');
INSERT INTO clasifications (name) VALUES ('Teens');
INSERT INTO clasifications (name) VALUES ('Outdoors & Nature');
INSERT INTO clasifications (name) VALUES ('Mystery & Thrillers');
INSERT INTO clasifications (name) VALUES ('Comics & Graphic Novels');
INSERT INTO clasifications (name) VALUES ('Parenting & Families');
INSERT INTO clasifications (name) VALUES ('Science Fiction & Fantasy');
INSERT INTO clasifications (name) VALUES ('Romance');
INSERT INTO clasifications (name) VALUES ('Gay & Lesbian');
INSERT INTO clasifications (name) VALUES ('Religion & Spirituality');
INSERT INTO clasifications (name) VALUES ('Travel');
INSERT INTO clasifications (name) VALUES ('Cooking, Food & Wine');
INSERT INTO clasifications (name) VALUES ('Sports');

CREATE TABLE collections (
  id serial PRIMARY KEY,
  clasification_id tinyint NOT NULL references clasifications(id),
  type_id tinyint NOT NULL references types(id) ON DELETE CASCADE, #Book, CD, LP, periodicals
  title varchar (100),
  author varchar(150) NOT NULL,
  edition tinyint,
  status tinyint NOT NULL DEFAULT 0,
  editor varchar(100),
  isonumber varchar(20), #ISBN, ISSN, NS
  cost float DEFAULT '0.0',
  groups tinyint NOT NULL DEFAULT 1, # 1) only students 2) students and teachers
  copies tinyint NOT NULL DEFAULT 1,
  created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL
)Engine=MyISAM;

CREATE TABLE medias (
   id serial PRIMARY KEY,
   file varchar(40) NOT NULL UNIQUE,
   user_id int REFERENCES users(id) ON DELETE CASCADE,
   size int NOT NULL DEFAULT 0,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   status tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

# Library
CREATE TABLE lendings (
  id serial PRIMARY KEY,
  collection_id int NOT NULL references collections(id) ON DELETE CASCADE,
  lend timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  fdate date DEFAULT '1970-01-01' NOT NULL,
  sdate date DEFAULT '1970-01-01' NOT NULL,
  days tinyint NOT NULL DEFAULT 7,
  user_id int NOT NULL references users(id) ON DELETE CASCADE,
  status smallint NOT NULL DEFAULT 1
 ) Engine=InnoDB;

# Podcasts
CREATE TABLE podcasts (
  id serial PRIMARY KEY,
  title varchar(50) NOT NULL DEFAULT '',
  description varchar(255) NOT NULL DEFAULT '',
  created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  length varchar(10) NOT NULL DEFAULT 0,
  duration varchar(8) NOT NULL DEFAULT '',
  filename varchar(100) NOT NULL,
  subject_id int REFERENCES subjects(id) ON DELETE CASCADE,
  status int NOT NULL DEFAULT 0,
  adult int NOT NULL DEFAULT 0,
  public smallint NOT NULL DEFAULT 0,
  user_id int REFERENCES users(id) ON DELETE CASCADE,
  keywords varchar(100),
  knet tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

INSERT INTO podcasts (title, description, filename, subject_id, status, user_id, public, knet) VALUES ('Podcast Demo', 'Some demo sample', 'demo_1.mp3', 1, 1, 1, 1, 1);

#- This models (Test, Webquest ans Treasure) belongsTO to vclassrooms
CREATE TABLE webquests (
  id serial PRIMARY KEY,
  title varchar(150) NOT NULL,
  introduction text NOT NULL DEFAULT '',
  tasks text NOT NULL DEFAULT '',
  process text NOT NULL DEFAULT '',
  roles text NOT NULL DEFAULT '',
  evaluation text NOT NULL DEFAULT '',
  conclusion text NOT NULL DEFAULT '',
  created timestamp  DEFAULT '0000-00-00 00:00:00' NOT NULL,
  updated timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
  user_id int REFERENCES users(id) ON DELETE CASCADE,
  status tinyint NOT NULL DEFAULT 0,
  archived tinyint NOT NULL DEFAULT 0,
  points tinyint NOT NULL DEFAULT 10,
  knet tinyint NOT NULL DEFAULT 0
) Engine=MyISAM;

CREATE TABLE result_webquests (  # webquests student results
   `id` serial NOT NULL UNIQUE,  #- This models (Test, Webquest ans Treasure) belongsTO to vclassrooms
   `answer` text NOT NULL,
   `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   `points` tinyint NOT NULL,
   `webquest_id` int NOT NULL REFERENCES webquests(id) ON DELETE CASCADE,
   `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   `created` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   PRIMARY KEY (user_id, webquest_id, vclassroom_id)
)Engine=InnoDB;

#HABTM
CREATE TABLE vclassrooms_webquests (
   `id` serial PRIMARY KEY,
   `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   `webquest_id` int NOT NULL REFERENCES webquests(id) ON DELETE CASCADE,
   `sdate` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
   `fdate` timestamp,
   UNIQUE (vclassroom_id, webquest_id)
) Engine=InnoDB;


# Treasure hunts         http://www.gma.org/surfing/imaging/treasure.html
CREATE TABLE treasures (
    id serial PRIMARY KEY,
    title varchar(150) NOT NULL,
    points tinyint NOT NULL DEFAULT 3,
    license_id tinyint NOT NULL DEFAULT 6 REFERENCES licenses(id), #,
    secret varchar(15) NOT NULL,  # secret word, stop
    instructions text NOT NULL DEFAULT '',
    user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status  tinyint NOT NULL DEFAULT 0,
    karanet tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

#HABTM
CREATE TABLE treasures_vclassrooms (
    id serial NOT NULL UNIQUE,
    treasure_id   int NOT NULL REFERENCES treasures(id),
    vclassroom_id int NOT NULL REFERENCES vclassrooms(id),
    hidden tinyint NOT NULL DEFAULT 1,
    open tinyint NOT NULL DEFAULT 1, 
    sdate timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    fdate timestamp,
    PRIMARY KEY  (vclassroom_id, treasure_id)
) Engine=InnoDB;

CREATE TABLE result_treasures (  -- tests student results
   id serial NOT NULL UNIQUE,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   points tinyint NOT NULL,
   treasure_id int NOT NULL REFERENCES treasures (id) ON DELETE CASCADE,
   vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   PRIMARY KEY (user_id, treasure_id, vclassroom_id)
);

# Test model tables begins
CREATE TABLE tests (
  id serial PRIMARY KEY,
  user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  license_id tinyint NOT NULL DEFAULT 6 REFERENCES licenses(id),
  title varchar(50),
  description text NOT NULL,
  status tinyint NOT NULL DEFAULT 0 CHECK (status IN (1, 0)),
  knet tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

#HABTM
CREATE TABLE tests_vclassrooms (
   `id` serial PRIMARY KEY,
   `test_id` int NOT NULL REFERENCES tests(id) ON DELETE CASCADE,
   `sdate` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   `fdate` timestamp,
   `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   UNIQUE  (test_id, vclassroom_id)
) Engine=InnoDB;

CREATE TABLE questions (
   `id` serial PRIMARY KEY,
   `question` varchar(150) NOT NULL,
   `hint` varchar(150) NOT NULL,
   `explanation` text NOT NULL,
   `test_id` int NOT NULL REFERENCES tests(id) ON DELETE CASCADE,
   `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   `status` tinyint NOT NULL DEFAULT 0,
   `worth`  tinyint NOT NULL DEFAULT 1,
   `order`  tinyint NOT NULL DEFAULT 1,
   `type` tinyint NOT NULL DEFAULT 1
) Engine=InnoDB;

CREATE TABLE answers (
  `id` serial PRIMARY KEY,
  `answer` varchar(150) NOT NULL,
  `correct` tinyint NOT NULL, # wrong = 0, correct = 1
  `question_id` int NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
  `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE
) Engine=InnoDB;

CREATE TABLE results (  # tests student results
   `id` serial NOT NULL UNIQUE,
   `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   `question_id` int NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
   `answer_id` int NOT NULL REFERENCES answers(id) ON DELETE CASCADE,
   `test_id` int NOT NULL REFERENCES tests(id) ON DELETE CASCADE,
   `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   `checked` tinyint NOT NULL DEFAULT 0,
   `created` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
   PRIMARY KEY (user_id, test_id, vclassroom_id, question_id)
) Engine=InnoDB;

CREATE TABLE tests_students ( 
  `id` serial NOT NULL UNIQUE,
  `user_id` int NOT NULL,   
  `test_id` int NOT NULL,
  `vclassroom_id` int NOT NULL,
  `checked` smallint NOT NULL DEFAULT 0,
  `created` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
   PRIMARY KEY (user_id, test_id, vclassroom_id)
);
# Test model tables ends

CREATE TABLE reports (  # student send files (.dox, .dot, .xls, etc) to Virtual Classroom
   `id` serial NOT NULL PRIMARY KEY,
   `filename` varchar(80) NOT NULL UNIQUE,
   `description` varchar(150) NOT NULL,
   `student_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   `activity_id` int,
   `points` tinyint NOT NULL DEFAULT 0,
   `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `checked` tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;


CREATE TABLE participations ( #tests student results
   `id` serial NOT NULL PRIMARY KEY,
   `title` varchar(80) NOT NULL,
   `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE, # student id
   `points` tinyint NOT NULL DEFAULT 0,
   `participation` text NOT NULL,
   `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   `checked` tinyint NOT NULL DEFAULT 0,
   `activity_id` int,
   `created` timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL
)Engine=InnoDB;

CREATE TABLE chats (  # chats on vgroups
   id serial NOT NULL PRIMARY KEY,
   student_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE, # student id in fact
   teacher_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE, # student id in fact
   vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   message varchar(100) NOT NULL,
   status tinyint NOT NULL DEFAULT 0,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL
)Engine=InnoDB;

CREATE TABLE pings (  #  list current users in chats
   id serial NOT NULL PRIMARY KEY,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   last_time timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL  # last time
)Engine=InnoDB;

# Share stuff (docs and multimedia) with your students
CREATE TABLE shares (
   id serial PRIMARY KEY,
   file varchar(50) UNIQUE NOT NULL,
   description varchar(150) NOT NULL,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   created timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
   secret  varchar(16) NOT NULL UNIQUE, # the secret reference
   public int NOT NULL DEFAULT 0,  #shareable?
   knet tinyint NOT NULL DEFAULT 0,
   status tinyint NOT NULL DEFAULT 0,
   subject_id integer NOT NULL REFERENCES subjects(id) ON DELETE CASCADE
) Engine=InnoDB;

CREATE TABLE metadatas (  #metadata to build Knet element (Lesson, Webquest, Entry, Share, etc)
  id serial PRIMARY KEY,
  fid varchar(150) NOT NULL, #foreign id
  type tinyint NOT NULL DEFAULT 1,  # lesson,
  user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  tags text NOT NULL,
  pedagogic text NOT NULL
) Engine=InnoDB;

CREATE TABLE gaps (
  id serial PRIMARY KEY,
  title varchar(90) NOT NULL,
  gaps text NOT NULL DEFAULT '',
  license_id tinyint NOT NULL DEFAULT 6 REFERENCES licenses(id) ,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  updated timestamp,
  user_id int REFERENCES users(id) ON DELETE CASCADE,
  status tinyint NOT NULL DEFAULT 0,
  points tinyint NOT NULL DEFAULT 3,
  knet tinyint NOT NULL DEFAULT 0  # share Knet?
)Engine=InnoDB;

CREATE TABLE gaps_vclassrooms (
 id serial PRIMARY KEY,
 gap_id int NOT NULL REFERENCES gaps(id) ON DELETE CASCADE,
 vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
 sdate timestamp  DEFAULT CURRENT_TIMESTAMP NOT NULL,
 fdate timestamp,
 UNIQUE  (gap_id, vclassroom_id)
)Engine=InnoDB;

CREATE TABLE result_gaps (
   id serial NOT NULL UNIQUE,
   user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
   gap_id int NOT NULL REFERENCES gaps (id) ON DELETE CASCADE,
   vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
   created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
   PRIMARY KEY (user_id, gap_id, vclassroom_id)
) Engine=InnoDB;

# Wiki tables beggin
CREATE TABLE wikis (
  id serial PRIMARY KEY,
  title varchar(255) NOT NULL,
  slug  varchar(80) NOT NULL UNIQUE,
  status tinyint NOT NULL DEFAULT 0,
  license_id tinyint NOT NULL DEFAULT 6 REFERENCES licenses(id) ,
  user_id int NOT NULL REFERENCES users(id),
  subject_id tinyint NOT NULL REFERENCES subjects(id),
  vclassroom_id int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  locked tinyint NOT NULL DEFAULT 0,
  public tinyint NOT NULL DEFAULT 0
) Engine=InnoDB;

CREATE TABLE revisions (
  id serial PRIMARY KEY,
  content text NOT NULL,
  modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  wiki_id int NOT NULL REFERENCES wikis(id) ON DELETE CASCADE,
  ip varchar(15) NOT NULL,
  revision tinyint NOT NULL,
  points tinyint NOT NULL DEFAULT 1,
  accessed date NOT NULL  DEFAULT '1970-01-01'
 ) Engine=InnoDB;


CREATE TABLE wiki_revisions (
  id serial PRIMARY KEY,
  title varchar(255) NOT NULL,
  content text NOT NULL,
  access tinyint NOT NULL default 0,
  modified timestamp NOT NULL default CURRENT_TIMESTAMP,
  user_id int NOT NULL,
  ip varchar(15) NOT NULL,
  revision tinyint NOT NULL,
  accessed date NOT NULL DEFAULT '1970-01-01'
) Engine=InnoDB;
# wiki tables ends

CREATE TABLE annotations (    #comments in lesson  see Lesson.php model
 id serial PRIMARY KEY,
 created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 comment text NOT NULL,
 email varchar(60),
 username varchar(15),
 website varchar(120),
 user_id int REFERENCES users (id) ON DELETE CASCADE,
 lesson_id int REFERENCES lessons (id) ON DELETE CASCADE,
 status tinyint NOT NULL DEFAULT 1
) Engine=InnoDB;

# Scorm tables
CREATE TABLE scorms (
    id serial PRIMARY KEY,
    user_id int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    license_id tinyint NOT NULL REFERENCES licenses(id) ON DELETE CASCADE,
    lang_id tinyint NOT NULL REFERENCES langs(id) ON DELETE CASCADE,
    points tinyint NOT NULL DEFAULT 0,
    name varchar(255) NOT NULL,
    path varchar(140) NOT NULL,
    summary text NOT NULL,
    version varchar(40),
    maxgrade double precision DEFAULT 0 NOT NULL,
    grademethod tinyint DEFAULT 0 NOT NULL,
    whatgrade tinyint DEFAULT 0 NOT NULL,
    maxattempt tinyint DEFAULT 1 NOT NULL,
    updatefreq tinyint DEFAULT 0 NOT NULL,
    skipview tinyint DEFAULT 1 NOT NULL, # This allows a user to skip SCORM/AICC overviews
    hidebrowse tinyint DEFAULT 0 NOT NULL,  # hide something
    hidetoc tinyint DEFAULT 0 NOT NULL, # hide table of content
    hidenav tinyint DEFAULT 0 NOT NULL,  # hide nav
    auto tinyint DEFAULT 0 NOT NULL, # autostart ?
    display_order tinyint DEFAULT 0 NOT NULL,
    status tinyint NOT NULL DEFAULT 0, # published / Draft
    popup tinyint DEFAULT 0 NOT NULL # 0=popup or 1=embedded
)Engine=InnoDB;

CREATE TABLE scorms_scos (
   `id` serial PRIMARY KEY,
  `scorm_id` int NOT NULL REFERENCES scorms(id) ON DELETE CASCADE,
  `item_id` int COMMENT 'Null in item but nor in resource',   
  `type` varchar(90) COMMENT 'item or resource',
  `datafromlms` varchar(255),
  `maxtimeallowed` varchar(255),
  `timelimitaction` varchar(255),
  `prerequisites` varchar(255),
  `manifest` varchar(255),  # CourseID
  `organization` varchar(255), # CourseID
  `parent` varchar(255),  # MANIFEST01_ITEM2
  `identifier` varchar(255),
  `identifierref` varchar(255),
  `launch` varchar(255) COMMENT 'Null in item only resources',  #  i.e.  resources/7.html
  `scormtype` varchar(5) COMMENT 'sco or asset in resource', 
  `title` varchar(255),
  `masteryscore` tinyint NOT NULL DEFAULT 1
)Engine=InnoDB;

# HABTM
CREATE TABLE scorms_vclassrooms (
  `id` serial PRIMARY KEY,
  `scorm_id` int NOT NULL REFERENCES scorms(id) ON DELETE CASCADE,
  `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  `sdate` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `fdate` timestamp,
  `hidden` boolean NOT NULL DEFAULT True,
  UNIQUE (scorm_id, vclassroom_id)
)Engine=InnoDB;

# students answers and track
CREATE TABLE result_scorms (
  `id` serial NOT NULL UNIQUE,
  `user_id` int NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  `scorm_id` int NOT NULL REFERENCES scorms (id) ON DELETE CASCADE,
  `varname`  varchar(255),
  `varvalue` varchar(255),
  `vclassroom_id` int NOT NULL REFERENCES vclassrooms(id) ON DELETE CASCADE,
  `sco_id` int NOT NULL REFERENCES  scorms_scos(id) ON DELETE CASCADE,
  `created` timestamp
)Engine=InnoDB;

# Karamelo ACL  Name: acos see users.sql file to find aros table
CREATE TABLE acos (
  `id` serial PRIMARY KEY,
  `parent_id` int,
  `model` varchar(255),
  `foreign_key` int,
  `alias` varchar(255),
  `lft` int,
  `rght` int
)Engine=InnoDB;

CREATE TABLE aros_acos (
    `id` serial PRIMARY KEY,
    `aro_id` int NOT NULL,
    `aco_id` int NOT NULL,
    `_create` varchar(2) DEFAULT 0 NOT NULL,
    `_read` varchar(2) DEFAULT 0 NOT NULL,
    `_update` varchar(2) DEFAULT 0 NOT NULL,
    `_delete` varchar(2) DEFAULT 0 NOT NULL
)Engine=InnoDB;


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
# Admins controllers
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

ALTER TABLE acos AUTO_INCREMENT = 61;

#  Groups and users. Note: aros table created in users.sql when running installer.php
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (1, NULL, 'Group', 1, 'Admins', 1, 4);
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (2, NULL, 'Group', 2, 'Teachers', 5, 6);
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (3, NULL, 'Group', 3, 'Students', 7,8);
INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (4, NULL, 'Group', 4, 'Parents', 9, 10);

ALTER TABLE aros AUTO_INCREMENT = 7;


# Admin permissions (ALL controllers)
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 1, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 2, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 3, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 4, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 5, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 6, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 7, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 8, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 9, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 10, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 11, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 12, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 13, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 14, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 15, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 16, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 17, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 18, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 19, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 20, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 21, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 22, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 23, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 24, '1', '1', '1', '1');
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
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 37, '1', '1', '1', '1');  #  < 50 = teachers sections
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 50, '1', '1', '1', '1');  #  > 50 = admins sections
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

# Teachers permissions group_id=2
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 1, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 2, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 3, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 4, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 5, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 6, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 7, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 8, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 9, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 10, '1', '1', '1', '1'); # Faqs
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 11, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 12, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 13, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 14, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 15, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 16, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 17, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 18, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 19, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 20, '1', '1', '1', '1'); # Treasures
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 21, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 22, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 23, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 24, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 25, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 26, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 27, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 28, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 29, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 30, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 31, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 32, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 33, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 34, '1', '1', '1', '1');
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 35, '1', '1', '1', '1'); # annotations
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 36, '1', '1', '1', '1'); # chats
INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (2, 37, '1', '1', '1', '1'); # knets

# Insert Karamelo helps
\. k_helps.sql
