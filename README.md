# SSH wrapper for PHP

## Information

!!! This is in very beta. I would not recommend using this on production or whatsoever. !!!

This library allows you to connect via SSH to your linux server with the PHP core class 'ssh2'.
It also allows to use a "jump server" for instance:

    command --ssh to-> jump server --ssh to-> actual server
    
## Requirements
    
You will need to install the PHP ssh2 extension and enable this. I assume you have knowledge on how to install php extensions
     
     
## Installation

Via composer

    {
        "require": {
            "wiardvanrij/sshwrapper": "*"
        }
    }

Because this library is in beta, please use the latest version. There is no stable

## Usage

Require the autoloader and include the namespace

    <?php
    
    require('vendor/autoload.php');
    
    use SshWrapper\SshCore;
    
Initiate the class with the host
    
    $ssh = new SshCore('123.123.123.123');
    
Optional: Define the rsa public and private key locations if they differ from default. Defaults:
    
    $ssh->authPriv = '~/.ssh/id_rsa';
    $ssh->authPub = '~/.ssh/id_rsa.pub';
    
Optional: Define user and port if they differ from the default. Defaults:    

    $ssh->authUser = 'root';
    $ssh->port = 22;
    
Prefered: If you use the ssh server as "jump server" you can define the actual server here including the user.
    
    $ssh->jumphost = 'root@321.321.321.321';
    
Connect    
    
    $ssh->connect();
    
And execute a command
    
    $result = $ssh->exec('ls -lah');
    
    var_dump($result);
    
Result is a string of the output

Disconnect to close the ssh connection

    $ssh->disconnect();

