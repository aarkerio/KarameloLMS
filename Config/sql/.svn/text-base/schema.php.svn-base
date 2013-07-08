<?php 
/* SVN FILE: $Id$ */
/* Karamelo schema generated on: 2010-04-02 00:04:48 : 1270189788*/
class KarameloSchema extends CakeSchema {
	var $name = 'Karamelo';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	public $collections = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'clasification_id' => array('type' => 'integer', 'null' => false),
		'tags' => array('type' => 'string', 'null' => true, 'length' => 60),
		'taxonomy' => array('type' => 'string', 'null' => true, 'length' => 60),
		'type_id' => array('type' => 'integer', 'null' => false),
		'title' => array('type' => 'string', 'null' => false, 'length' => 150),
		'author' => array('type' => 'string', 'null' => false, 'length' => 150),
		'edition' => array('type' => 'integer', 'null' => true),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'editor' => array('type' => 'string', 'null' => true, 'length' => 100),
		'isonumber' => array('type' => 'string', 'null' => true, 'length' => 70),
		'cost' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'groups' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'copies' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);

	public $acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'model' => array('type' => 'string', 'null' => true),
		'foreign_key' => array('type' => 'integer', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $acquaintances = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50),
		'url' => array('type' => 'string', 'null' => true, 'length' => 250),
		'user_id' => array('type' => 'integer', 'null' => false),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $annotations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'comment' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'user_id' => array('type' => 'integer', 'null' => false),
		'blogger_id' => array('type' => 'integer', 'null' => false),
		'username' => array('type' => 'string', 'null' => true, 'length' => 15),
		'email' => array('type' => 'string', 'null' => true, 'length' => 60),
		'website' => array('type' => 'string', 'null' => true, 'length' => 120),
		'lesson_id' => array('type' => 'integer', 'null' => true),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $answers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'answer' => array('type' => 'string', 'null' => false, 'length' => 150),
		'correct' => array('type' => 'integer', 'null' => false),
		'question_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $aros = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'model' => array('type' => 'string', 'null' => true),
		'foreign_key' => array('type' => 'integer', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $aros_acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'aro_id' => array('type' => 'integer', 'null' => false),
		'aco_id' => array('type' => 'integer', 'null' => false),
		'_create' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_read' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_update' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_delete' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $cake_sessions = array(
		'id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
		'data' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'expires' => array('type' => 'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $catfaqs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 120),
		'description' => array('type' => 'string', 'null' => false, 'length' => 250),
		'user_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'public' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $catforums = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 150),
		'description' => array('type' => 'string', 'null' => false, 'length' => 150),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $catglossaries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 100),
		'description' => array('type' => 'string', 'null' => false, 'length' => 250),
		'user_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'public' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $chats = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false),
		'teacher_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'message' => array('type' => 'string', 'null' => false, 'length' => 100),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);

	public $colleges = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 150),
		'description' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'email' => array('type' => 'string', 'null' => false, 'length' => 40),
		'twitter' => array('type' => 'string', 'null' => true, 'length' => 60),
		'keywords' => array('type' => 'string', 'null' => false, 'length' => 200),
		'sp' => array('type' => 'string', 'null' => true, 'length' => 100),
		'url' => array('type' => 'string', 'null' => true, 'length' => 200),
		'logo' => array('type' => 'string', 'null' => false, 'default' => 'cwclogo.jpg', 'length' => 60),
		'gcalendar_id' => array('type' => 'string', 'null' => true, 'length' => 80),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'comment' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'user_id' => array('type' => 'integer', 'null' => false),
		'blogger_id' => array('type' => 'integer', 'null' => false),
		'username' => array('type' => 'string', 'null' => true, 'length' => 15),
		'email' => array('type' => 'string', 'null' => true, 'length' => 60),
		'website' => array('type' => 'string', 'null' => true, 'length' => 120),
		'entry_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $confirms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'secret' => array('type' => 'string', 'null' => false, 'length' => 16),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $discussions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'new_id' => array('type' => 'integer', 'null' => false),
		'name' => array('type' => 'string', 'null' => true, 'length' => 100),
		'comment' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'level' => array('type' => 'integer', 'null' => false),
		'discussion_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $ecourses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'subject_id' => array('type' => 'integer', 'null' => false),
		'title' => array('type' => 'string', 'null' => false, 'length' => 110),
		'kind' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'percentage' => array('type' => 'integer', 'null' => false, 'default' => '60'),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'public' => array('type' => 'boolean', 'null' => true, 'default' => 'false'),
		'lang_id' => array('type' => 'integer', 'null' => false),
		'code' => array('type' => 'string', 'null' => true, 'length' => 13),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $entries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 50),
		'body' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'subject_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => true),
		'discution' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $faqs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'question' => array('type' => 'string', 'null' => false, 'length' => 90),
		'answer' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'catfaq_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'display' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);

	public $forums = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 150),
		'description' => array('type' => 'string', 'null' => false, 'length' => 500),
		'user_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'catforum_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $gaps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 90),
		'instructions' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'gaps' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'license_id' => array('type' => 'integer', 'null' => false, 'default' => '6'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'user_id' => array('type' => 'integer', 'null' => true),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'archived' => array('type' => 'boolean', 'null' => false, 'default' => 'false'),
		'points' => array('type' => 'integer', 'null' => false, 'default' => '3'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $gaps_vclassrooms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'gap_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'sdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'fdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'hidden' => array('type' => 'boolean', 'null' => false, 'default' => 'true'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'gaps_vclassrooms_gap_id_key' => array('unique' => true, 'column' => array('gap_id', 'vclassroom_id')))
	);
	public $glossaries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'catglossary_id' => array('type' => 'integer', 'null' => true),
		'license_id' => array('type' => 'integer', 'null' => false, 'default' => '6'),
		'item' => array('type' => 'string', 'null' => false, 'length' => 80),
		'definition' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'display' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);

	public $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'code' => array('type' => 'string', 'null' => false, 'default' => 'f78Z67', 'length' => 7),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'groups_name_key' => array('unique' => true, 'column' => 'name'))
	);
	public $helps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 80),
		'url' => array('type' => 'string', 'null' => false, 'length' => 100),
		'help' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'lang' => array('type' => 'string', 'null' => false, 'default' => 'en', 'length' => 2),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'help_lang_url_key' => array('unique' => true, 'column' => array('lang', 'url')))
	);
	public $images = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'file' => array('type' => 'string', 'null' => false, 'length' => 40),
		'user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'images_file_key' => array('unique' => true, 'column' => 'file'))
	);
	public $knets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 90),
		'subject_id' => array('type' => 'integer', 'null' => false),
		'ktype_id' => array('type' => 'integer', 'null' => false),
		'description' => array('type' => 'string', 'null' => true, 'length' => 200),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'disc' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'rank' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'visits' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')) 
    );
	public $langs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => false, 'length' => 6),
		'lang' => array('type' => 'string', 'null' => false, 'length' => 80),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'langs_code_key' => array('unique' => true, 'column' => 'code'), 'langs_lang_key' => array('unique' => true, 'column' => 'lang'))
	);
	public $lendings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'collection_id' => array('type' => 'integer', 'null' => false),
		'lend' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'fdate' => array('type' => 'date', 'null' => false, 'default' => 'now()'),
		'sdate' => array('type' => 'date', 'null' => false, 'default' => 'now()'),
		'days' => array('type' => 'integer', 'null' => false, 'default' => '7'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $lessons = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 90),
		'subject_id' => array('type' => 'integer', 'null' => false),
		'license_id' => array('type' => 'integer', 'null' => false, 'default' => '6'),
		'body' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'disc' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'public' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'rank' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'visits' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);

	public $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 90),
		'body' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'level' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'sender_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $news = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 150),
		'body' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'reference' => array('type' => 'string', 'null' => true, 'length' => 350),
		'theme_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'comments' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $newsletters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 150),
		'body' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'public' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'sent' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'delivered' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $participations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 80),
		'user_id' => array('type' => 'integer', 'null' => false),
		'points' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'participation' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $pings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'last_ip' => array('type' => 'inet', 'null' => true),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'last_time' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $podcasts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 50),
		'description' => array('type' => 'string', 'null' => false),
		'keywords' => array('type' => 'string', 'null' => true, 'length' => 100),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'length' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 10),
		'duration' => array('type' => 'string', 'null' => false, 'length' => 8),
		'filename' => array('type' => 'string', 'null' => false, 'length' => 100),
		'subject_id' => array('type' => 'integer', 'null' => true),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'adult' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => true),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'public' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);

	public $pollrows = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'poll_id' => array('type' => 'integer', 'null' => false),
		'answer' => array('type' => 'string', 'null' => false, 'length' => 130),
		'color' => array('type' => 'string', 'null' => false, 'default' => 'green', 'length' => 15),
		'vote' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $polls = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'question' => array('type' => 'string', 'null' => false, 'length' => 90),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $questions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'question' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'hint' => array('type' => 'string', 'null' => false, 'length' => 150),
		'explanation' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'test_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'worth' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'type' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'order' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $quotes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'quote' => array('type' => 'string', 'null' => false, 'length' => 150),
		'author' => array('type' => 'string', 'null' => false, 'length' => 50),
		'user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $recovers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true),
		'random' => array('type' => 'string', 'null' => false, 'length' => 150),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'recovers_random_key' => array('unique' => true, 'column' => 'random'))
	);
	public $replies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'reply' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'topic_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'points' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $reports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'filename' => array('type' => 'string', 'null' => false, 'length' => 80),
		'description' => array('type' => 'string', 'null' => false, 'length' => 40),
		'student_id' => array('type' => 'integer', 'null' => false),
		'points' => array('type' => 'integer', 'null' => false, 'default' => '2'),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'reports_filename_key' => array('unique' => true, 'column' => 'filename'))
	);
	public $result_treasures = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'points' => array('type' => 'integer', 'null' => false),
		'treasure_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => array('user_id', 'treasure_id', 'vclassroom_id')), 'result_treasures_id_key' => array('unique' => true, 'column' => 'id'))
	);
	public $result_webquests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'answer' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'user_id' => array('type' => 'integer', 'null' => false),
		'points' => array('type' => 'integer', 'null' => false),
		'webquest_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => array('user_id', 'webquest_id', 'vclassroom_id')), 'result_webquests_id_key' => array('unique' => true, 'column' => 'id'))
	);
	public $results = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'question_id' => array('type' => 'integer', 'null' => false),
		'answer_id' => array('type' => 'integer', 'null' => true),
		'answer' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'correct' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'test_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => array('user_id', 'test_id', 'vclassroom_id', 'question_id')), 'results_id_key' => array('unique' => true, 'column' => 'id'))
	);
	public $shares = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'file' => array('type' => 'string', 'null' => false, 'length' => 50),
		'subject_id' => array('type' => 'integer', 'null' => false),
		'description' => array('type' => 'string', 'null' => false, 'length' => 150),
		'user_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'secret' => array('type' => 'string', 'null' => false, 'length' => 16),
		'public' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'shares_file_key' => array('unique' => true, 'column' => 'file'), 'shares_secret_key' => array('unique' => true, 'column' => 'secret'))
	);
	public $subjects = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => false, 'length' => 8),
		'title' => array('type' => 'string', 'null' => false, 'length' => 80),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'subjects_code_key' => array('unique' => true, 'column' => 'code'), 'subjects_title_key' => array('unique' => true, 'column' => 'title'))
	);
	public $tests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'license_id' => array('type' => 'integer', 'null' => false, 'default' => '6'),
		'title' => array('type' => 'string', 'null' => true, 'length' => 50),
		'description' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'archived' => array('type' => 'boolean', 'null' => false, 'default' => 'false'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $tests_vclassrooms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'test_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'sdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'fdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'hidden' => array('type' => 'boolean', 'null' => false, 'default' => 'true'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'tests_vclassrooms_test_id_key' => array('unique' => true, 'column' => array('test_id', 'vclassroom_id')))
	);
	public $themes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'theme' => array('type' => 'string', 'null' => false, 'length' => 40),
		'description' => array('type' => 'string', 'null' => false, 'length' => 400),
		'img' => array('type' => 'string', 'null' => false, 'length' => 80),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $topics = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'subject' => array('type' => 'string', 'null' => false, 'length' => 150),
		'message' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'forum_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'views' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $treasures = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 150),
		'points' => array('type' => 'integer', 'null' => false, 'default' => '3'),
		'secret' => array('type' => 'string', 'null' => false, 'length' => 15),
		'instructions' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'user_id' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'archived' => array('type' => 'boolean', 'null' => false, 'default' => 'false'),
		'knet' => array('type' => 'boolean', 'null' => false, 'default' => 'false'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $treasures_vclassrooms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'treasure_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'sdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'fdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'hidden' => array('type' => 'boolean', 'null' => false, 'default' => 'true'),
		'open' => array('type' => 'boolean', 'null' => false, 'default' => 'true'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'treasures_vclassrooms_treasure_id_key' => array('unique' => true, 'column' => array('treasure_id', 'vclassroom_id')))
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'length' => 10),
		'pwd' => array('type' => 'string', 'null' => false, 'length' => 60),
		'name' => array('type' => 'string', 'null' => false, 'length' => 70),
		'email' => array('type' => 'string', 'null' => false, 'length' => 45),
		'last_visit' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'current_visit' => array('type' => 'string', 'null' => true, 'length' => 20),
		'group_id' => array('type' => 'integer', 'null' => false),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'lang' => array('type' => 'string', 'null' => false, 'default' => 'en', 'length' => 3),
		'avatar' => array('type' => 'string', 'null' => false, 'default' => 'default-avatar.jpg', 'length' => 100),
		'helps' => array('type' => 'boolean', 'null' => false, 'default' => 'true'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'users_email_key' => array('unique' => true, 'column' => 'email'), 'users_username_key' => array('unique' => true, 'column' => 'username'))
	);
	public $users_vclassrooms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => '3'),
		'kind' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'users_vclassrooms_user_id_key' => array('unique' => true, 'column' => array('user_id', 'vclassroom_id', 'kind')))
	);
	public $vclassrooms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 150),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'historical' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'ecourse_id' => array('type' => 'integer', 'null' => false),
		'secret' => array('type' => 'string', 'null' => true, 'length' => 10),
		'sdate' => array('type' => 'date', 'null' => false, 'default' => 'now()'),
		'fdate' => array('type' => 'date', 'null' => false, 'default' => 'now()'),
		'access' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'message' => array('type' => 'boolean', 'null' => false, 'default' => 'true'),
		'chat' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'gcalendar_id' => array('type' => 'string', 'null' => true, 'length' => 70),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $vclassrooms_webquests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'webquest_id' => array('type' => 'integer', 'null' => false),
		'sdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'fdate' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'hidden' => array('type' => 'boolean', 'null' => false, 'default' => 'true'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'vclassrooms_webquests_vclassroom_id_key' => array('unique' => true, 'column' => array('vclassroom_id', 'webquest_id')))
	);
	public $webquests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 80),
		'introduction' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'tasks' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'process' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'roles' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'evaluation' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'conclusion' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => 'now()'),
		'license_id' => array('type' => 'integer', 'null' => false, 'default' => '6'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'archived' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'points' => array('type' => 'integer', 'null' => false, 'default' => '10'),
		'knet' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	public $wikis = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 80),
		'slug' => array('type' => 'string', 'null' => false, 'length' => 80),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => false),
		'subject_id' => array('type' => 'integer', 'null' => false),
		'vclassroom_id' => array('type' => 'integer', 'null' => false),
		'locked' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'public' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'), 'wikis_slug_key' => array('unique' => true, 'column' => 'slug'), 'wikis_title_key' => array('unique' => true, 'column' => 'title'))
	);
}
?>
