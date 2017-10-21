# SSH wrapper and server information via php

## Information

!!! This is in very beta. I would not recommend using this on production or whatsoever. !!!

This library allows you to connect via SSH to your linux server with the PHP core class 'ssh2'.
It also allows to use a "jump server" for instance:

    command --ssh to-> jump server --ssh to-> actual server
    
    

## Installation

Via composer

    {
        "require": {
            "douweegbertje/sshwrapper": "*"
        }
    }

Because this library is in beta, please use the latest version. There is no stable

## Usage

Require the autoloader and include the namespace

    <?php
    
    require('vendor/autoload.php');
    
    use SshWrapper\SshCore;
    
initiate the class with the host
    
    $ssh = new SshCore('123.123.123.123');
    
Define the rsa public and private key locations
    
    $ssh->authPriv = '~/.ssh/id_rsa';
    $ssh->authPub = '~/.ssh/id_rsa.pub';
    
Prefered: If you use the ssh server as "jump server" you can define the actual server here
    
    $ssh->jumphost = 'vps0004';
    
Connect    
    
    $ssh->connect();
    
And execute a command
    
    $result = $ssh->exec('ls -lah');
    
    var_dump($result);
    
Result is a string of the output
