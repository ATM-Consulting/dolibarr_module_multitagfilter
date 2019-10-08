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
 * \file    class/actions_multitagfilter.class.php
 * \ingroup multitagfilter
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class ActionsmultiTagFilter
 */
class ActionsmultiTagFilter
{
    /**
     * @var DoliDb		Database handler (result of a new DoliDB)
     */
    public $db;

	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
     * @param DoliDB    $db    Database connector
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}

	/**
	 * Overloading the printFieldPreListTitle function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object        The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action        Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function printFieldPreListTitle($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $form, $langs;

		$type = $parameters['type']; // Type de liste : vide => tous tiers confondus, p => prospects, c => clientrs, f => fournisseurs
		$TContexts = explode(':', $parameters['context']);

		if (in_array('thirdpartylist', $TContexts) && ! empty($conf->categorie->enabled))
		{
			$TFiltersToReplace = array();

			if (empty($form)) // TEMP
			{
				require_once DOL_DOCUMENT_ROOT . '/core/class/html.form.class.php';

				$form = new Form($this->db);
			}

			if (empty($type) || $type == 'c' || $type == 'p')
			{
				global $search_categ_cus;

				$TCategs = $form->select_all_categories(Categorie::TYPE_CUSTOMER, null, 'parent', null, null, 1);
				$TCategs[-2] = $langs->trans('NotCategorized');

				$customerFilter = $langs->trans('CustomersProspectsCategoriesShort').': ';
				$customerFilter.= Form::multiselectarray('search_categ_cus', $TCategs, $search_categ_cus);

				$TFiltersToReplace['search_categ_cus'] = $customerFilter;
			}

			if (empty($type) || $type == 'f')
			{
				global $search_categ_sup;

				$TCategs = $form->select_all_categories(Categorie::TYPE_SUPPLIER, null, 'parent', null, null, 1);
				$TCategs[-2] = $langs->trans('NotCategorized');

				$supplierFilter = $langs->trans('CustomersProspectsCategoriesShort').': ';
				$supplierFilter.= Form::multiselectarray('search_categ_sup', $TCategs, $search_categ_sup);

				$TFiltersToReplace['search_categ_sup'] = $supplierFilter;
			}

			ob_start();
?>
			<script>
				$(document).ready(function ()
				{
				    let TFilters = <?php echo json_encode($TFiltersToReplace); ?>;

				    for(filterName in TFilters)
				    {
				        let parent = $('[name=' + filterName + ']').parent('.divsearchfield');

				        if(parent.length > 0)
				        {
				            parent.html(TFilters[filterName]);
				        }
				    }
				});
			</script>
<?php
			$this->resprints = ob_get_clean();
		}

		return 0;
	}

	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object        The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action        Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function doActions($parameters, &$object, &$action, $hookmanager)
	{
		global $conf;

		$type = $parameters['type'];
		$TContexts = explode(':', $parameters['context']);

		if (in_array('thirdpartylist', $TContexts) && ! empty($conf->categorie->enabled))
		{

		}

		return 0;
	}
}
