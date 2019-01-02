<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */
namespace skeeks\proxmox;

use ProxmoxVE\Exception\AuthenticationException;
use ProxmoxVE\Exception\MalformedCredentialsException;
use ProxmoxVE\Proxmox;
use yii\base\Component;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class ProxmoxComponent extends Component
{
    /**
     * @var string proxmox.server.com
     */
    public $hostname;

    /**
     * @var string root
     */
    public $username;

    /**
     * @var string secret
     */
    public $password;

    /**
     * @var string pve
     */
    public $realm;

    /**
     * @var int 8006
     */
    public $port;

    /**
     * @var Proxmox
     */
    public $api;

    /**
     * @var \Exception
     */
    protected $_error;

    public function init()
    {
        parent::init();

        $this->_error    = null;

        try
        {
            $credentials = [];
            $credentials['hostname'] = $this->hostname;
            $credentials['username'] = $this->username;
            $credentials['password'] = $this->password;

            $this->realm ? $credentials['realm'] = $this->realm : "";
            $this->port ? $credentials['port'] = $this->port : "";

            $this->api = new Proxmox($credentials);
        } catch (AuthenticationException $e)
        {
            $this->api      = null;
            $this->_error    = $e;
        } catch (MalformedCredentialsException $e)
        {
            $this->api      = null;
            $this->_error    = $e;
        }
    }

    /**
     * @return \Exception
     */
    public function getError()
    {
        return $this->_error;
    }
}

