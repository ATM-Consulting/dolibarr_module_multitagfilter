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
 *	\file		lib/multitagfilter.lib.php
 *	\ingroup	multitagfilter
 *	\brief		This file is an example module library
 *				Put some comments here
 */

/**
 * @return array
 */
function multitagfilterAdminPrepareHead()
{
    global $langs, $conf;

    $langs->load('multitagfilter@multitagfilter');

    $h = 0;
    $head = array();

    $head[$h][0] = dol_buildpath("/multitagfilter/admin/multitagfilter_setup.php", 1);
    $head[$h][1] = $langs->trans("Parameters");
    $head[$h][2] = 'settings';
    $h++;
    $head[$h][0] = dol_buildpath("/multitagfilter/admin/multitagfilter_extrafields.php", 1);
    $head[$h][1] = $langs->trans("ExtraFields");
    $head[$h][2] = 'extrafields';
    $h++;
    $head[$h][0] = dol_buildpath("/multitagfilter/admin/multitagfilter_about.php", 1);
    $head[$h][1] = $langs->trans("About");
    $head[$h][2] = 'about';
    $h++;

    // Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    //$this->tabs = array(
    //	'entity:+tabname:Title:@multitagfilter:/multitagfilter/mypage.php?id=__ID__'
    //); // to add new tab
    //$this->tabs = array(
    //	'entity:-tabname:Title:@multitagfilter:/multitagfilter/mypage.php?id=__ID__'
    //); // to remove a tab
    complete_head_from_modules($conf, $langs, $object, $head, $h, 'multitagfilter');

    return $head;
}

/**
 * Return array of tabs to used on pages for third parties cards.
 *
 * @param 	multiTagFilter	$object		Object company shown
 * @return 	array				Array of tabs
 */
function multitagfilter_prepare_head(multiTagFilter $object)
{
    global $langs, $conf;
    $h = 0;
    $head = array();
    $head[$h][0] = dol_buildpath('/multitagfilter/card.php', 1).'?id='.$object->id;
    $head[$h][1] = $langs->trans("multiTagFilterCard");
    $head[$h][2] = 'card';
    $h++;
	
	// Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    // $this->tabs = array('entity:+tabname:Title:@multitagfilter:/multitagfilter/mypage.php?id=__ID__');   to add new tab
    // $this->tabs = array('entity:-tabname:Title:@multitagfilter:/multitagfilter/mypage.php?id=__ID__');   to remove a tab
    complete_head_from_modules($conf, $langs, $object, $head, $h, 'multitagfilter');
	
	return $head;
}

/**
 * @param Form      $form       Form object
 * @param multiTagFilter  $object     multiTagFilter object
 * @param string    $action     Triggered action
 * @return string
 */
function getFormConfirmmultiTagFilter($form, $object, $action)
{
    global $langs, $user;

    $formconfirm = '';

    if ($action === 'valid' && !empty($user->rights->multitagfilter->write))
    {
        $body = $langs->trans('ConfirmValidatemultiTagFilterBody', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ConfirmValidatemultiTagFilterTitle'), $body, 'confirm_validate', '', 0, 1);
    }
    elseif ($action === 'accept' && !empty($user->rights->multitagfilter->write))
    {
        $body = $langs->trans('ConfirmAcceptmultiTagFilterBody', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ConfirmAcceptmultiTagFilterTitle'), $body, 'confirm_accept', '', 0, 1);
    }
    elseif ($action === 'refuse' && !empty($user->rights->multitagfilter->write))
    {
        $body = $langs->trans('ConfirmRefusemultiTagFilterBody', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ConfirmRefusemultiTagFilterTitle'), $body, 'confirm_refuse', '', 0, 1);
    }
    elseif ($action === 'reopen' && !empty($user->rights->multitagfilter->write))
    {
        $body = $langs->trans('ConfirmReopenmultiTagFilterBody', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ConfirmReopenmultiTagFilterTitle'), $body, 'confirm_refuse', '', 0, 1);
    }
    elseif ($action === 'delete' && !empty($user->rights->multitagfilter->write))
    {
        $body = $langs->trans('ConfirmDeletemultiTagFilterBody');
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ConfirmDeletemultiTagFilterTitle'), $body, 'confirm_delete', '', 0, 1);
    }
    elseif ($action === 'clone' && !empty($user->rights->multitagfilter->write))
    {
        $body = $langs->trans('ConfirmClonemultiTagFilterBody', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ConfirmClonemultiTagFilterTitle'), $body, 'confirm_clone', '', 0, 1);
    }
    elseif ($action === 'cancel' && !empty($user->rights->multitagfilter->write))
    {
        $body = $langs->trans('ConfirmCancelmultiTagFilterBody', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ConfirmCancelmultiTagFilterTitle'), $body, 'confirm_cancel', '', 0, 1);
    }

    return $formconfirm;
}
