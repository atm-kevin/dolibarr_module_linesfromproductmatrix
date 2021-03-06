<?php
/* Copyright (C) 2004-2018  Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2019  Nicolas ZABOURI         <info@inovea-conseil.com>
 * Copyright (C) 2019-2020  Frédéric France         <frederic.france@netlogic.fr>
 * Copyright (C) 2020 SuperAdmin
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup   linesfromproductmatrix     Module LinesFromProductMatrix
 *  \brief      LinesFromProductMatrix module descriptor.
 *
 *  \file       htdocs/linesfromproductmatrix/core/modules/modLinesFromProductMatrix.class.php
 *  \ingroup    linesfromproductmatrix
 *  \brief      Description and activation file for module LinesFromProductMatrix
 */
include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

/**
 *  Description and activation class for module LinesFromProductMatrix
 */
class modLinesFromProductMatrix extends DolibarrModules
{
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $langs, $conf,$user;
		$this->db = $db;

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 104104;
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'linesfromproductmatrix';
		// Family can be 'base' (core modules),'crm','financial','hr','projects','products','ecm','technic' (transverse modules),'interface' (link with external tools),'other','...'
		// It is used to group modules by family in module setup page
		$this->family = "other";
		// Module position in the family on 2 digits ('01', '10', '20', ...)
		$this->module_position = '90';
		// Gives the possibility for the module, to provide his own family info and position of this family (Overwrite $this->family and $this->module_position. Avoid this)
		//$this->familyinfo = array('myownfamily' => array('position' => '01', 'label' => $langs->trans("MyOwnFamily")));
		// Module label (no space allowed), used if translation string 'ModuleLinesFromProductMatrixName' not found (LinesFromProductMatrix is name of module).
		$this->name = preg_replace('/^mod/i', '', get_class($this));
		// Module description, used if translation string 'ModuleLinesFromProductMatrixDesc' not found (LinesFromProductMatrix is name of module).
		$this->description = "LinesFromProductMatrixDescription";
		// Used only if file README.md and README-LL.md not found.
		$this->descriptionlong = "LinesFromProductMatrix description (Long)";
		$this->editor_name = 'Editor name';
		$this->editor_url = 'https://www.example.com';
		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated' or a version string like 'x.y.z'
		$this->version = '1.0';
		// Url to the file with your last numberversion of this module
		//$this->url_last_version = 'http://www.example.com/versionmodule.txt';

		// Key used in llx_const table to save module status enabled/disabled (where LINESFROMPRODUCTMATRIX is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		$this->picto = 'linesfromproductmatrix@linesfromproductmatrix';
		// Define some features supported by module (triggers, login, substitutions, menus, css, etc...)
		$this->module_parts = array(
			// Set this to 1 if module has its own trigger directory (core/triggers)
			'triggers' => 0,
			// Set this to 1 if module has its own login method file (core/login)
			'login' => 0,
			// Set this to 1 if module has its own substitution function file (core/substitutions)
			'substitutions' => 0,
			// Set this to 1 if module has its own menus handler directory (core/menus)
			'menus' => 0,
			// Set this to 1 if module overwrite template dir (core/tpl)
			'tpl' => 0,
			// Set this to 1 if module has its own barcode directory (core/modules/barcode)
			'barcode' => 0,
			// Set this to 1 if module has its own models directory (core/modules/xxx)
			'models' => 0,
			// Set this to 1 if module has its own theme directory (theme)
			'theme' => 0,
			// Set this to relative path of css file if module has its own css file
			'css' => array(
				    '/linesfromproductmatrix/css/linesfromproductmatrix.css.php',
				    '/linesfromproductmatrix/css/linesfromproductmatrix-notifications.css.php',
			),
			// Set this to relative path of js file if module must load a js on all pages
			'js' => array(
					'/linesfromproductmatrix/js/linesfromproductmatrix.js.php'
			),
			// Set here all hooks context managed by module. To find available hook context, make a "grep -r '>initHooks(' *" on source code. You can also set hook context to 'all'
			'hooks' => array(
				//   'data' => array(
				//       'hookcontext1',
				//       'hookcontext2',
				//   ),
				//   'entity' => '0',
			),
			// Set this to 1 if features of module are opened to external users
			'moduleforexternal' => 0,
		);
		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/linesfromproductmatrix/temp","/linesfromproductmatrix/subdir");
		$this->dirs = array("/linesfromproductmatrix/temp");
		// Config pages. Put here list of php page, stored into linesfromproductmatrix/admin directory, to use to setup module.
		$this->config_page_url = array("setup.php@linesfromproductmatrix");
		// Dependencies
		// A condition to hide module
		$this->hidden = false;
		// List of module class names as string that must be enabled if this module is enabled. Example: array('always1'=>'modModuleToEnable1','always2'=>'modModuleToEnable2', 'FR1'=>'modModuleToEnableFR'...)
		$this->depends = array();
		$this->requiredby = array(); // List of module class names as string to disable if this one is disabled. Example: array('modModuleToDisable1', ...)
		$this->conflictwith = array(); // List of module class names as string this module is in conflict with. Example: array('modModuleToDisable1', ...)
		$this->langfiles = array("linesfromproductmatrix@linesfromproductmatrix");
		$this->phpmin = array(5, 5); // Minimum version of PHP required by module
		$this->need_dolibarr_version = array(11, -3); // Minimum version of Dolibarr required by module
		$this->warnings_activation = array(); // Warning to show when we activate module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation_ext = array(); // Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		//$this->automatic_activation = array('FR'=>'LinesFromProductMatrixWasAutomaticallyActivatedBecauseOfYourCountryChoice');
		//$this->always_enabled = true;								// If true, can't be disabled

		// Constants
		// List of particular constants to add when module is enabled (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		// Example: $this->const=array(1 => array('LINESFROMPRODUCTMATRIX_MYNEWCONST1', 'chaine', 'myvalue', 'This is a constant to add', 1),
		//                             2 => array('LINESFROMPRODUCTMATRIX_MYNEWCONST2', 'chaine', 'myvalue', 'This is another constant to add', 0, 'current', 1)
		// );
		$this->const = array();

		// Some keys to add into the overwriting translation tables
		/*$this->overwrite_translation = array(
			'en_US:ParentCompany'=>'Parent company or reseller',
			'fr_FR:ParentCompany'=>'Maison mère ou revendeur'
		)*/

		if (!isset($conf->linesfromproductmatrix) || !isset($conf->linesfromproductmatrix->enabled)) {
			$conf->linesfromproductmatrix = new stdClass();
			$conf->linesfromproductmatrix->enabled = 0;
		}

		// Array to add new pages in new tabs
		$this->tabs = array();
		// Example:
		$this->tabs[] = array('data'=>'propal:+tabmatrix:Ajout rapide de quantité:linesfromproductmatrix@linesfromproductmatrix:$user->rights->linesfromproductmatrix->bloc->read:/linesfromproductmatrix/tab_matrix.php?id=__ID__&element=propal'); // To add a new tab identified by code tabname1
		$this->tabs[] = array('data'=>'order:+tabmatrix:Ajout rapide de quantité:linesfromproductmatrix@linesfromproductmatrix:$user->rights->linesfromproductmatrix->bloc->read:/linesfromproductmatrix/tab_matrix.php?id=__ID__&element=commande');
		$this->tabs[] = array('data'=>'invoice:+tabmatrix:Ajout rapide de quantité:linesfromproductmatrix@linesfromproductmatrix:$user->rights->linesfromproductmatrix->bloc->read:/linesfromproductmatrix/tab_matrix.php?id=__ID__&element=facture');

		// Dictionaries
		$this->dictionaries = array();
		/* Example:
		$this->dictionaries=array(
			'langs'=>'linesfromproductmatrix@linesfromproductmatrix',
			// List of tables we want to see into dictonnary editor
			'tabname'=>array(MAIN_DB_PREFIX."table1", MAIN_DB_PREFIX."table2", MAIN_DB_PREFIX."table3"),
			// Label of tables
			'tablib'=>array("Table1", "Table2", "Table3"),
			// Request to select fields
			'tabsql'=>array('SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table1 as f', 'SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table2 as f', 'SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table3 as f'),
			// Sort order
			'tabsqlsort'=>array("label ASC", "label ASC", "label ASC"),
			// List of fields (result of select to show dictionary)
			'tabfield'=>array("code,label", "code,label", "code,label"),
			// List of fields (list of fields to edit a record)
			'tabfieldvalue'=>array("code,label", "code,label", "code,label"),
			// List of fields (list of fields for insert)
			'tabfieldinsert'=>array("code,label", "code,label", "code,label"),
			// Name of columns with primary key (try to always name it 'rowid')
			'tabrowid'=>array("rowid", "rowid", "rowid"),
			// Condition to show each dictionary
			'tabcond'=>array($conf->linesfromproductmatrix->enabled, $conf->linesfromproductmatrix->enabled, $conf->linesfromproductmatrix->enabled)
		);
		*/

		// Boxes/Widgets
		// Add here list of php file(s) stored in linesfromproductmatrix/core/boxes that contains a class to show a widget.
		$this->boxes = array(
			//  0 => array(
			//      'file' => 'linesfromproductmatrixwidget1.php@linesfromproductmatrix',
			//      'note' => 'Widget provided by LinesFromProductMatrix',
			//      'enabledbydefaulton' => 'Home',
			//  ),
			//  ...
		);

		// Cronjobs (List of cron jobs entries to add when module is enabled)
		// unit_frequency must be 60 for minute, 3600 for hour, 86400 for day, 604800 for week
		$this->cronjobs = array(
			//  0 => array(
			//      'label' => 'MyJob label',
			//      'jobtype' => 'method',
			//      'class' => '/linesfromproductmatrix/class/bloc.class.php',
			//      'objectname' => 'Bloc',
			//      'method' => 'doScheduledJob',
			//      'parameters' => '',
			//      'comment' => 'Comment',
			//      'frequency' => 2,
			//      'unitfrequency' => 3600,
			//      'status' => 0,
			//      'test' => '$conf->linesfromproductmatrix->enabled',
			//      'priority' => 50,
			//  ),
		);
		// Example: $this->cronjobs=array(
		//    0=>array('label'=>'My label', 'jobtype'=>'method', 'class'=>'/dir/class/file.class.php', 'objectname'=>'MyClass', 'method'=>'myMethod', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>'$conf->linesfromproductmatrix->enabled', 'priority'=>50),
		//    1=>array('label'=>'My label', 'jobtype'=>'command', 'command'=>'', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>1, 'unitfrequency'=>3600*24, 'status'=>0, 'test'=>'$conf->linesfromproductmatrix->enabled', 'priority'=>50)
		// );

		// Permissions provided by this module
		$this->rights = array();
		$r = 0;

		// Add here entries to declare new permissions

		/* BEGIN  PERMISSIONS */
		$this->rights[$r][0] = $this->numero . $r; // Permission id (must not be already used)
		$this->rights[$r][1] = 'Read objects of LinesFromProductMatrix'; // Permission label
		$this->rights[$r][4] = 'bloc'; // In php code, permission will be checked by test if ($user->rights->linesfromproductmatrix->level1->level2)
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->linesfromproductmatrix->level1->level2)
		$r++;
		$this->rights[$r][0] = $this->numero . $r; // Permission id (must not be already used)
		$this->rights[$r][1] = 'Create/Update objects of LinesFromProductMatrix'; // Permission label
		$this->rights[$r][4] = 'bloc'; // In php code, permission will be checked by test if ($user->rights->linesfromproductmatrix->level1->level2)
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->linesfromproductmatrix->level1->level2)
		$r++;
		$this->rights[$r][0] = $this->numero . $r; // Permission id (must not be already used)
		$this->rights[$r][1] = 'Delete objects of LinesFromProductMatrix'; // Permission label
		$this->rights[$r][4] = 'bloc'; // In php code, permission will be checked by test if ($user->rights->linesfromproductmatrix->level1->level2)
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->linesfromproductmatrix->level1->level2)
		$r++;
		/* END  PERMISSIONS */

		// Main menu entries to add
		$this->menu = array();
		$r = 0;
		// Add here entries to declare new menus
		/* BEGIN  TOPMENU */
		$this->menu[$r++] = array(
			'fk_menu'=>'fk_mainmenu=products', // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left', // This is a Top menu entry
			'titre'=>$langs->trans('ModuleLinesFromProductMatrixName'),
			'mainmenu'=>'products',
			'leftmenu'=>'linesfromproductmatrix',
			'url'=>'/linesfromproductmatrix/admin/matrix_config.php',
			'langs'=>'linesfromproductmatrix@linesfromproductmatrix', // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000 + $r,
			'enabled'=>'$conf->linesfromproductmatrix->enabled', // Define condition to show or hide menu entry. Use '$conf->linesfromproductmatrix->enabled' if entry must be visible if module is enabled.
			'perms'=>'$user->rights->linesfromproductmatrix->bloc->write', // Use 'perms'=>'$user->rights->linesfromproductmatrix->bloc->read' if you want your menu with a permission rules
			'target'=>'',
			'user'=>2, // 0=Menu for internal users, 1=external users, 2=both
		);
		/* END  TOPMENU */
		/* BEGIN  LEFTMENU BLOC
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=linesfromproductmatrix',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',                          // This is a Top menu entry
			'titre'=>'Bloc',
			'mainmenu'=>'linesfromproductmatrix',
			'leftmenu'=>'bloc',
			'url'=>'/linesfromproductmatrix/linesfromproductmatrixindex.php',
			'langs'=>'linesfromproductmatrix@linesfromproductmatrix',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->linesfromproductmatrix->enabled',  // Define condition to show or hide menu entry. Use '$conf->linesfromproductmatrix->enabled' if entry must be visible if module is enabled.
			'perms'=>'$user->rights->linesfromproductmatrix->bloc->read',			                // Use 'perms'=>'$user->rights->linesfromproductmatrix->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		*/

        $this->menu[$r++]=array(
            // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
            'fk_menu'=>'fk_mainmenu=linesfromproductmatrix',
            // This is a Left menu entry
            'type'=>'left',
            'titre'=>'List Bloc',
            'mainmenu'=>'linesfromproductmatrix',
            'leftmenu'=>'linesfromproductmatrix_bloc',
            'url'=>'/linesfromproductmatrix/bloc_list.php',
            // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
            'langs'=>'linesfromproductmatrix@linesfromproductmatrix',
            'position'=>1100+$r,
            // Define condition to show or hide menu entry. Use '$conf->linesfromproductmatrix->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
            'enabled'=>'$conf->linesfromproductmatrix->enabled',
            // Use 'perms'=>'$user->rights->linesfromproductmatrix->level1->level2' if you want your menu with a permission rules
            'perms'=>'1',
            'target'=>'',
            // 0=Menu for internal users, 1=external users, 2=both
            'user'=>2,
        );
        $this->menu[$r++]=array(
            // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
            'fk_menu'=>'fk_mainmenu=linesfromproductmatrix,fk_leftmenu=linesfromproductmatrix_bloc',
            // This is a Left menu entry
            'type'=>'left',
            'titre'=>'New Bloc',
            'mainmenu'=>'linesfromproductmatrix',
            'leftmenu'=>'linesfromproductmatrix_bloc',
            'url'=>'/linesfromproductmatrix/bloc_card.php?action=create',
            // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
            'langs'=>'linesfromproductmatrix@linesfromproductmatrix',
            'position'=>1100+$r,
            // Define condition to show or hide menu entry. Use '$conf->linesfromproductmatrix->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
            'enabled'=>'$conf->linesfromproductmatrix->enabled',
            // Use 'perms'=>'$user->rights->linesfromproductmatrix->level1->level2' if you want your menu with a permission rules
            'perms'=>'1',
            'target'=>'',
            // 0=Menu for internal users, 1=external users, 2=both
            'user'=>2
        );

		/* END LEFTMENU BLOC */

	}

	/**
	 *  Function called when module is enabled.
	 *  The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *  It also creates data directories
	 *
	 *  @param      string  $options    Options when enabling module ('', 'noboxes')
	 *  @return     int             	1 if OK, 0 if KO
	 */
	public function init($options = '')
	{
		global $conf, $langs;

		$result = $this->_load_tables('/linesfromproductmatrix/sql/');
		if ($result < 0) return -1; // Do not activate module if error 'not allowed' returned when loading module SQL queries (the _load_table run sql with run_sql with the error allowed parameter set to 'default')

		// Create extrafields during init
		//include_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
		//$extrafields = new ExtraFields($this->db);
		//$result1=$extrafields->addExtraField('linesfromproductmatrix_myattr1', "New Attr 1 label", 'boolean', 1,  3, 'thirdparty',   0, 0, '', '', 1, '', 0, 0, '', '', 'linesfromproductmatrix@linesfromproductmatrix', '$conf->linesfromproductmatrix->enabled');
		//$result2=$extrafields->addExtraField('linesfromproductmatrix_myattr2', "New Attr 2 label", 'varchar', 1, 10, 'project',      0, 0, '', '', 1, '', 0, 0, '', '', 'linesfromproductmatrix@linesfromproductmatrix', '$conf->linesfromproductmatrix->enabled');
		//$result3=$extrafields->addExtraField('linesfromproductmatrix_myattr3', "New Attr 3 label", 'varchar', 1, 10, 'bank_account', 0, 0, '', '', 1, '', 0, 0, '', '', 'linesfromproductmatrix@linesfromproductmatrix', '$conf->linesfromproductmatrix->enabled');
		//$result4=$extrafields->addExtraField('linesfromproductmatrix_myattr4', "New Attr 4 label", 'select',  1,  3, 'thirdparty',   0, 1, '', array('options'=>array('code1'=>'Val1','code2'=>'Val2','code3'=>'Val3')), 1,'', 0, 0, '', '', 'linesfromproductmatrix@linesfromproductmatrix', '$conf->linesfromproductmatrix->enabled');
		//$result5=$extrafields->addExtraField('linesfromproductmatrix_myattr5', "New Attr 5 label", 'text',    1, 10, 'user',         0, 0, '', '', 1, '', 0, 0, '', '', 'linesfromproductmatrix@linesfromproductmatrix', '$conf->linesfromproductmatrix->enabled');

		// Permissions
		$this->remove($options);

		$sql = array();

		// Document templates
		$moduledir = 'linesfromproductmatrix';
		$myTmpObjects = array();
		$myTmpObjects['Bloc']=array('includerefgeneration'=>0, 'includedocgeneration'=>0);

		foreach ($myTmpObjects as $myTmpObjectKey => $myTmpObjectArray) {
			if ($myTmpObjectKey == 'Bloc') continue;
			if ($myTmpObjectArray['includerefgeneration']) {
				$src=DOL_DOCUMENT_ROOT.'/install/doctemplates/linesfromproductmatrix/template_blocs.odt';
				$dirodt=DOL_DATA_ROOT.'/doctemplates/linesfromproductmatrix';
				$dest=$dirodt.'/template_blocs.odt';

				if (file_exists($src) && ! file_exists($dest))
				{
					require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
					dol_mkdir($dirodt);
					$result=dol_copy($src, $dest, 0, 0);
					if ($result < 0)
					{
						$langs->load("errors");
						$this->error=$langs->trans('ErrorFailToCopyFile', $src, $dest);
						return 0;
					}
				}

				$sql = array_merge($sql, array(
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'standard_".strtolower($myTmpObjectKey)."' AND type = '".strtolower($myTmpObjectKey)."' AND entity = ".$conf->entity,
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('standard_".strtolower($myTmpObjectKey)."','".strtolower($myTmpObjectKey)."',".$conf->entity.")",
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'generic_".strtolower($myTmpObjectKey)."_odt' AND type = '".strtolower($myTmpObjectKey)."' AND entity = ".$conf->entity,
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('generic_".strtolower($myTmpObjectKey)."_odt', '".strtolower($myTmpObjectKey)."', ".$conf->entity.")"
				));
			}
		}

		return $this->_init($sql, $options);
	}

	/**
	 *  Function called when module is disabled.
	 *  Remove from database constants, boxes and permissions from Dolibarr database.
	 *  Data directories are not deleted
	 *
	 *  @param      string	$options    Options when enabling module ('', 'noboxes')
	 *  @return     int                 1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();
		return $this->_remove($sql, $options);
	}
}
