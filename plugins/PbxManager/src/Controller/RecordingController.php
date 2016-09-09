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
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('PbxManager.Soap', array(
				'url' => '',
				'options' => array()
			)
		);
	}
	
	public function index()
	{
		
	}
	
	public function enable($agent = null)
	{
		if($this->Soap->enableRecording($agent))
			$this->Flash->success("Mithören wurde aktiviert.");
		else
			$this->Flash->error("Es ist ein Fehler aufgetreten! Mithören konnte nicht aktiviert werden.");
		return $this->redirect(array('controller' => 'Recording', 'action' => 'index'));
	}
	
	public function disable($agent = null)
	{
		if($this->Soap->disableRecording($agent))
			$this->Flash->success("Mithören wurde deaktiviert.");
		else
			$this->Flash->error("Es ist ein Fehler aufgetreten! Mithören konnte nicht deaktiviert werden.");
		return $this->redirect(array('controller' => 'Recording', 'action' => 'index'));
	}
}