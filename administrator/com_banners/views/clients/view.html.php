<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of clients.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.6
 */
class BannersViewClients extends BannersViewClientsDefault
{
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		//fix helper loading
		$this->loadHelper('banners');

		$canDo	= BannersHelper::getActions();

		JToolbarHelper::title(JText::_('COM_BANNERS_MANAGER_CLIENTS'), 'banners-clients.png');
		if ($canDo->get('core.create')) {
			JToolbarHelper::addNew('client.add');
		}
		if ($canDo->get('core.edit')) {
			JToolbarHelper::editList('client.edit');
		}
		if ($canDo->get('core.edit.state')) {
			JToolbarHelper::publish('clients.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('clients.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('clients.archive');
			JToolbarHelper::checkin('clients.checkin');
		}
		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolbarHelper::deleteList('', 'clients.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state')) {
			JToolbarHelper::trash('clients.trash');
		}

		if ($canDo->get('core.admin')) {
			JToolbarHelper::preferences('com_banners');
		}

		JToolbarHelper::help('JHELP_COMPONENTS_BANNERS_CLIENTS');
	}
}