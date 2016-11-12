<?php

/**
 * @author Michael Müller <development@reu-network.de>
 */
class AdminController extends AppController
{
	public $components = array("PbxManager.Soap");//, "PbxManager.InnoPbx" => array('cn' => 'Carsten.Homeoffice'));

	/**
	 * creates new log entry
	 */
	private function logWrite($message)
	{
		// TODO: Methodenkörper füllen
	}

	public function index()
	{
		if(!empty($this->request->data))
		{
			$supervisor = trim($this->request->data['select']['supervisorPhone']);
			$agent = trim($this->request->data['select']['agentPhone']);
				
			// check attributes
			if((empty($supervisor) || empty($agent)) || (!is_numeric($supervisor) || !is_numeric($agent)))
			{
				$this->Session->setFlash(__('Es ist ein Fehler aufgetreten! Bitte prüfen Sie Ihre Eingaben.'), 'default', array(), 'bad');
				return;
			}
		
			// check which submit button was clicked
			// enable
			if(isset($this->request->data['enable']))
			{
				try
				{
					$result = $this->Soap->enableRecording($agent, $supervisor);
						
					if($result)
					{
						$this->logWrite("Recording wurde auf Agent $agent für Supervisor $supervisor aktiviert");
						$this->Session->setFlash(__('Mithören wurde aktiviert.'), 'default', array(), 'good');
					}
					else
					{
						$this->Session->setFlash(__('Es ist ein Fehler aufgetreten! Mithören konnte nicht aktiviert werden.'), 'default', array(), 'bad');
					}
				}
				catch (Exception $ex)
				{
					$this->Session->setFlash(__('Es ist ein Fehler aufgetreten: '.$ex->getMessage()), 'default', array(), 'bad');
					die($ex->getMessage());
				}
			}
			// disable
			elseif(isset($this->request->data['disable']))
			{
				$result = $this->Soap->disableRecording($agent, $supervisor);
				if($result)
				{
					$this->logWrite("Recording wurde auf Agent $agent für Supervisor $supervisor deaktiviert");
					$this->Session->setFlash(__('Mithören wurde deaktiviert.'), 'default', array(), 'good');
				}
				else
				{
					$this->Session->setFlash(__('Es ist ein Fehler aufgetreten! Mithören konnte nicht deaktiviert werden.'), 'default', array(), 'bad');
				}
			}
		
			// user info
			$userinfo = $this->Soap->getRecordingStatus($agent);
			$this->set('userinfo', $userinfo);
		}
	}
}