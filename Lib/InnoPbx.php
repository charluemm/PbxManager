<?php

/**
 * Class to handle SOAP calls via InnoPbx
 *
 * @author Michael Müller <development@reu-network.de>
 *
 * inspired by innovaphone PBX SOAP API PHP wrapper class
 * http://wiki.innovaphone.com/index.php?title=Howto:SOAP_API_PHP5_Sample_Code
 *
 */
class InnoPbx extends \SoapClient {

	/** Session key */
	protected $_key;
	/** Session id */
	protected $_session;

	protected $_options = array(
			// default SOAPClient::__construct options used by the class
			"connection_timeout" => 10,
			"exceptions" => true,
	);

	const _wsdl = 'http://www.innovaphone.com/wsdl/pbx900.wsdl';

	/**
	 * Class constructor
	 * 
	 * @param string $server the PBX IP
	 * @param string $soapUser soap auth user
	 * @param string $soapPasswd soap auth password
	 * @param string $user pbx user CN to work with
	 * @param array $options extra or overriding options for SoapClient::__construct
	 * @param string $wsdl wsdl file location
	 */
	public function __construct($server, $soapUser,	$soapPasswd, $user = null, $options = null,	$wsdl = null)
	{
		$wsdl = ($wsdl === null) ? self::_wsdl : $wsdl;

		$usedoptions = array(
				'login' => $soapUser,
				'password' => $soapPasswd,
				'location' => "http://$server/PBX0/user.soap"
		);

		if (is_array($options))
			$usedoptions += $options;

			// merge in user options
			$usedoptions += $this->___options;	// merged in class global options

			// construct parent class
			parent::__construct($wsdl, $usedoptions);

			// get the connection (using and activating v9 wsdl)
			$init = $this->Initialize($user, "Chronos SOAP Client", true, true, true, true, true);
			$this->_key = $init['key'];
			$this->_session = $init['return'];
	}

	/**
	 * Get Session key
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->_key;
	}

	/**
	 * Get Session Id
	 *
	 * @return string
	 */
	public function getSession()
	{
		return $this->_session;
	}
}

class InnoUserInfo {
	/** @var boolean */
	protected $active;
	/** @var string */
	protected $state;
	/** @var string */
	protected $channel;
	/** @var string */
	protected $alert;
	/** @var string */
	protected $type;
	/** @var string */
	protected $guid;
	/** @var string */
	protected $cn;
	/** @var string */
	protected $e164;
	/** @var string */
	protected $h323;
	/** @var string */
	protected $dn;
	/** @var string */
	protected $domain;
	/** @var boolean */
	protected $h323email;
	/** @var string */
	protected $email = array();
	/** @var array of InnoGroups records */
	protected $groups = array();
	/** @var array of InnoPresence records */
	protected $presence = array();
	/** @var boolean */
	protected $cfg;
	/** @var string */
	protected $object;
	/** @var string */
	protected $loc;
	/** @var string */
	protected $node;
	/** @var string */
	protected $nodenum;
	/** @var array of InnoInfo **/
	protected $info;
}

class InnoGroup
{
	/** @var string */
	protected $group;
	/** @var boolean */
	protected $active;
}

class InnoPresence
{
	/** @var string */
	protected $status;
	/** @var string */
	protected $activity;
	/** @var string */
	protected $note;
}

class InnoCallInfo
{
	/** @var int **/
	protected $user;
	/** @var int **/
	protected $call;
	/** @var int **/
	protected $reg;
	/** @var boolean */
	protected $active;
	/** @var int **/
	protected $state;
	/** @var string */
	protected $msg;
	/** @var array of InnoNo */
	protected $no = array();
	/** @var array of InnoInfo */
	protected $info;
}

class InnoNo
{
	/** @var string */
	protected $type;
	/** @var string */
	protected $cn;
	/** @var string */
	protected $e164;
	/** @var string */
	protected $h323;
	/** @var string */
	protected $dn;
}

class InnoInfo
{
	/** @var string */
	protected $type;
	/** @var string */
	protected $vals;
	/** @var int */
	protected $vali;
}

class InnoAnyInfo
{
	/** @var array of InnoUserInfo */
	protected $user = array();
	/** @var array of InnoCallInfo */
	protected $call = array();
	
	protected $reg;
	
	protected $info;
}
