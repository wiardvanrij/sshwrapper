<?php
namespace sshwrapper\ServerInfo;


class ServerInfo {
    
    public function getPHPVersion()
    {
        return $this->exec("ls -lah /etc/init.d/ | grep 'php' |  awk '{print $9}'");
    }
}