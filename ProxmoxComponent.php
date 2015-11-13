<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 14.11.2015
 */
namespace skeeks\proxmox;

use ProxmoxVE\Exception\AuthenticationException;
use ProxmoxVE\Exception\MalformedCredentialsException;
use ProxmoxVE\Proxmox;
use yii\base\Component;

/**
 * Class ProxmoxComponent
 * @package skeeks\proxmox
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
    protected $error;

    public function init()
    {
        parent::init();

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
            $this->error    = $e;
        } catch (MalformedCredentialsException $e)
        {
            $this->api      = null;
            $this->error    = $e;
        }
    }
}

