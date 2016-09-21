<?php

namespace PbxManager\Controller;

use PbxManager\Controller\AppController;
use Cake\Core\Configure;

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
		// load soap_config.php
		try 
		{
			Configure::load("soap_config");
		}
		catch (\Exception $ex)
		{
			Configure::load('PbxManager.soap_config');			
		}
		
		// get parameter from soap config
		$url = Configure::read("soap.url");
		$options = array(
				'login' => Configure::read("soap.login"),
				'password' => Configure::read("soap.password"),
				'proxy_host' => Configure::read("proxy.host"),
				'proxy_port' => Configure::read("proxy.port"),
				'proxy_login' => Configure::read("proxy.login"),
				'proxy_password' => Configure::read("proxy.password"),
				'trace' => 1, 
				'exceptions' => 1,
				'connection_timeout' => 10,
				'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0) ) )
		);
		
		// load soap component
		$this->loadComponent('PbxManager.Soap', array(
				'url' => $url,
				'options' => $options
			)
		);
	}
	
	/**
	 * get supervisor phone number
	 * 
	 * @return string superisor phone number
	 */
	private function getSupervisor()
	{
		// TODO: get phone number from current user object
		return null;
	}
	
	public function index()
	{
		if(!empty($this->request->data))
			$this->set('userinfo', $this->Soap->getRecordingStatus($this->request->data['agentPhone']));
	}
	
	public function enable($number)
	{
		if($this->Soap->enableRecording($number))
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