<?php

namespace sshwrapper\Core;

class Core
{
    
    public $host;
    public $port = 22;
    public $authUser = 'root';
    public $authPub = '/root/.ssh/id_rsa.pub';
    public $authPriv = '/root/.ssh/id_rsa';
    public $authPass;
    public $jumphost;
    private $connection;
    
    function __construct($host)
    {
        $this->host     = $host;
        $this->jumphost = false;
    }
    
    public function connect()
    {
        if ( ! ($this->connection = ssh2_connect($this->host, $this->port))) {
            throw new Exception('Cannot connect to server');
        }
        
        if ( ! ssh2_auth_pubkey_file($this->connection, $this->authUser, $this->authPub, $this->authPriv,
            $this->authPass)
        ) {
            throw new Exception('Autentication rejected by server');
        }
    }
    
    public function exec($cmd)
    {
        
        if ($this->jumphost) {
            $cmd = "ssh " . $this->jumphost . " " . $cmd;
        }
        
        if ( ! ($stream = ssh2_exec($this->connection, $cmd))) {
            throw new Exception('SSH command failed');
        }
        stream_set_blocking($stream, true);
        $data = "";
        while ($buf = fread($stream, 4096)) {
            $data .= $buf;
        }
        fclose($stream);
        
        return $data;
    }
    
    public function disconnect()
    {
        $this->exec('echo "EXITING" && exit;');
        $this->connection = null;
    }
    
}