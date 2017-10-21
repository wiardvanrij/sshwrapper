<?php
namespace SshWrapper;

class SshCore
{
    public $host;
    public $port = 22;
    public $authUser = 'root';
    public $authPub = '~/.ssh/id_rsa.pub';
    public $authPriv = '~/.ssh/id_rsa';
    public $authPass = false;
    public $jumphost = false;
    private $connection;
    
    /**
     * SshCore constructor.
     *
     * @param $host
     */
    function __construct($host)
    {
        $this->host = $host;
    }
    
    /**
     * Init the connection
     *
     * @throws \Exception
     */
    public function connect()
    {
        if ( ! ($this->connection = ssh2_connect($this->host, $this->port))) {
            throw new \Exception('Cannot connect to server');
        }
        
        if ( ! ssh2_auth_pubkey_file($this->connection, $this->authUser, $this->authPub, $this->authPriv,
            $this->authPass)
        ) {
            throw new \Exception('Autentication rejected by server');
        }
    }
    
    /**
     * Execute a command on the server, or pass it trough the jump server
     *
     * @param $cmd
     *
     * @return string
     * @throws \Exception
     */
    public function exec($cmd)
    {
        
        if ($this->jumphost) {
            $cmd = "ssh " . $this->jumphost . " " . $cmd;
        }
        
        if ( ! ($stream = ssh2_exec($this->connection, $cmd))) {
            throw new \Exception('SSH command failed');
        }
        stream_set_blocking($stream, true);
        $data = "";
        while ($buf = fread($stream, 4096)) {
            $data .= $buf;
        }
        fclose($stream);
        
        return $data;
    }
    
    /**
     * Disconnect the connection
     */
    public function disconnect()
    {
        $this->exec('echo "EXITING" && exit;');
        $this->connection = null;
    }
}