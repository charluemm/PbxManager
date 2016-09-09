<?php

namespace PbxManager\Controller;

use PbxManager\Controller\AppController;


/**
 * @author Michael Müller <development@reu-network.de>
 * @author David Howon <howon.david@gmail.com>
 *
 */
class RecordingController extends AppController
{
	public function index()
	{
	}
	
	public function enable($agent = null)
	{
		$this->Flash->success("Mithören wurde aktiviert.");
		return $this->redirect(array('controller' => 'Recording', 'action' => 'index'));
	}
	
	public function disable($agent = null)
	{
		$this->Flash->success("Mithören wurde deaktiviert.");
		return $this->redirect(array('controller' => 'Recording', 'action' => 'index'));
	}
}