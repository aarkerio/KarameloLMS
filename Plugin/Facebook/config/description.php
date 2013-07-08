<?php
/* SVN FILE: $Id: description.php 513 2008-07-01 03:50:32Z jose.zap $ */
/**
 * Ósmosis LMS: <http://www.osmosislms.org/>
 * Copyright 2008, Ósmosis LMS
 *
 * This file is part of Ósmosis LMS.
 * Ósmosis LMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Ósmosis LMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Ósmosis LMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @filesource
 * @copyright		Copyright 2008, Ósmosis LMS
 * @link			http://www.osmosislms.org/
 * @package			org.osmosislms
 * @subpackage		org.osmosislms.app
 * @since			Version 2.0 
 * @version			$Revision: 513 $
 * @modifiedby		$LastChangedBy: jose.zap $
 * @lastmodified	$Date: 2008-06-30 22:50:32 -0500 (Mon, 30 Jun 2008) $
 * @license			http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 */
Configure::write('Scorm.description',__('Sharable Content Object Reference Model (SCORM) is a collection of standards and specifications for web-based e-learning. This plugin is a player for SCORM 2004 files',true));
Configure::write('Scorm.title',__('Lessons', true));
Configure::write('Scorm.author','Ósmosis Team');
Configure::write('Scorm.type',array('tool'));
?>
