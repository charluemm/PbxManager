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