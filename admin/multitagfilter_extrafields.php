<?php
/* Copyright (C) 2019 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *      \file       admin/multitagfilter_extrafields.php
 *		\ingroup    multitagfilter
 *		\brief      Page to setup extra fields of multitagfilter
 */

$res = @include '../../main.inc.php'; // From htdocs directory
if (! $res) {
    $res = @include '../../../main.inc.php'; // From "custom" directory
}


/*
 * Config of extrafield page for multiTagFilter
 */
require_once '../lib/multitagfilter.lib.php';
require_once '../class/multitagfilter.class.php';
$langs->loadLangs(array('multitagfilter@multitagfilter', 'admin', 'other'));

$multitagfilter = new multiTagFilter($db);
$elementtype=$multitagfilter->table_element;  //Must be the $table_element of the class that manage extrafield

// Page title and texts elements
$textobject=$langs->transnoentitiesnoconv('multiTagFilter');
$help_url='EN:Help multiTagFilter|FR:Aide multiTagFilter';
$pageTitle = $langs->trans('multiTagFilterExtrafieldPage');

// Configuration header
$head = multitagfilterAdminPrepareHead();



/*
 *  Include of extrafield page
 */

require_once dol_buildpath('abricot/tpl/extrafields_setup.tpl.php'); // use this kind of call for variables scope
