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
 * View to edit a client.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.5
 */
class BannersViewPosition extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$this->loadHelper('banners');
		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo		= BannersHelper::getActions();

		JToolbarHelper::title($isNew ? JText::_('COM_BANNERS_MANAGER_CLIENT_NEW') : JText::_('COM_BANNERS_MANAGER_CLIENT_EDIT'), 'banners-clients.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit')||$canDo->get('core.create'))) {
			JToolbarHelper::apply('position.apply');
			JToolbarHelper::save('position.save');
		}
		if (!$checkedOut && $canDo->get('core.create')) {

			JToolbarHelper::save2new('position.save2new');
		}
		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolbarHelper::save2copy('position.save2copy');
		}

		if (empty($this->item->id))  {
			JToolbarHelper::cancel('position.cancel');
		} else {
			JToolbarHelper::cancel('position.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
