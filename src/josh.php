<?php


/**
 * @author : Alireza Josheghani [ Josh ]
 * @package : Josh console component
 * @version : 0.1
 */

class Josh
{
    var $red;
    var $no_color;
    var $green;
    var $yellow;
    private $os;
    public function __construct(){
        if($this->os !== 'Windows'){
            $this->red = "\033[31m";
            $this->green = "\033[32m";
            $this->no_color = "\033[0m";
            $this->yellow = "\033[33m";
        } else {
            $this->red = "";
            $this->green = "";
            $this->no_color = "";
            $this->yellow = "";
        }
    }
    public function handle_request(array $args)
    {
        if(strpos($_SERVER['TERM_PROGRAM'],'.app','0')){
            $this->os = "Mac";
        } elseif(isset($_SERVER['GDMSESSION']) &&
            !empty($_SERVER['GDMSESSION'])) {
            $this->os = "Linux";
        } else {
            $this->os = "Windows";
        }
        if(!empty($args[1])){
            switch ($args[1]){
                case 'help':
                case '-h':
                case '-about':
                case 'about':
                case '-a':
                case 'h':
                    return $this->help();
                    break;
                case 'hook:setup':
                    return $this->hookSetup();
                    break;
                case 'chmod':
                    return $this->chmod($args[2],$args[3]);
                    break;
                case 'ip':
                    return $this->iP($args[2]);
                    break;
                case 'lamp':
                    if($this->os === 'Linux'){
                        exec("sudo /opt/lmap/lamp start");
                    } else {
                        echo $this->red.">>> Command notfound ! \n".$this->no_color;
                    }
                    break;
            }
        } else {
            echo $this->help();
        }
    }
    public function help(){
        if($this->os === 'Linux'){
            $lamp = "    lamp                    ".
                $this->red."      start lamp services \n";
        } else {
            $lamp = '';
        }
        return $this->yellow."Josh console component 0.1 \n".
        $this->CheckOs()."\n".
        $this->green."Usage:".$this->no_color." \n    command [options] [arguments]".
        $this->green."\n\nAvailable Commands \nMain :\n".
        $this->no_color."    help           ".
        $this->red."               help console \n".$this->no_color.
        $this->no_color.$lamp.
        $this->no_color."    hook:setup              ".
        $this->red."      setup hook of your packagist package \n".
        $this->green."\nChmod : \n".
        $this->no_color."    chmod -l  [Directory Name]    ".
        $this->red."Configuring permissions of your project for localy  \n".
        $this->no_color."    chmod -s  [Directory Name]    ".
        $this->red."Configuring permissions of your project for hostly \n".
        $this->green."\nIP Address : \n".
        $this->no_color."    ip -l                     ".
        $this->red."    get local Ip-Address \n".
        $this->no_color."    ip -p                    ".
        $this->red."     get public Ip-Address \n".
        "\n".$this->no_color;
    }
    public function checkSystem(){
        return "Local Ip Address : ".$this->green.exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'").$this->no_color;
    }
    public function checkPublicIp(){
        return "Public Ip Address : ".$this->green.
        trim(file_get_contents('http://ipinfo.io/ip'))
        .$this->no_color;
    }
    public function iP($command){
        if($command === '-l'){
            return "\n    ".$this->checkSystem()." \n\n";
        } elseif($command === '-p'){
            return "\n    ".$this->checkPublicIp()."\n\n";
        } else {
            return $this->red."\nFailed ❗️ \n\n".$this->no_color.$this->red.
            ">>> Option not found ! \n".
            $this->no_color;
        }
    }
    public function chmod($command,$option){
        if($command === '-l'){
            if(is_dir($option)){
                exec('sudo find '.$option.' -type d -exec chmod 777 {} +');
                exec('sudo find '.$option.' -type f -exec chmod 666 {} +');
                return $this->green."\nSuccess ✅️ \n\n".$this->no_color;
            } else {
                return $this->red."\nFailed ❗️ \n\n".$this->no_color.$this->red.
                ">>> The directory name was empty ! \n".
                $this->no_color;
            }
        } elseif($command === '-s'){
            if(!empty($option)){
                exec('sudo find '.$option.' -type d -exec chmod 755 {} +');
                exec('sudo find '.$option.' -type f -exec chmod 655 {} +');
                return $this->green."\nSuccess ✅️ \n\n".$this->no_color;
            } else {
                return $this->red."\nFailed ❗️ \n\n".$this->no_color.$this->red.
                ">>> The directory name was empty ! \n".
                $this->no_color;
            }
        } else {
            return $this->red."\nFailed ❗️ \n\n".$this->no_color.$this->red.
            ">>> Option not found ! \n".
            $this->no_color;
        }
    }
    public function hookSetup(){
        echo $this->yellow.">>> Enter your packagist username : ".
            $this->no_color;
        $userHandle = fopen("php://stdin","r");
        $username = fgets($userHandle);
        fclose($userHandle);
        if(!empty(trim($username))){
            echo $this->yellow.">>> Enter your packagist API : ".
                $this->no_color;
            $handle = fopen("php://stdin","r");
            $API = fgets($handle);
            fclose($handle);
            if(!empty(trim($API))){
                echo $this->yellow.">>> Enter your package url on github : ".$this->no_color;
                $package = fopen("php://stdin","r");
                $PK = fgets($package);
                fclose($package);
                if(!empty(trim($PK))){
                    echo "\nUsername : " . $username."API : " . $API."Github Url : " . $PK.
                    $this->green."\nSending request ... \n".$this->no_color;
                    $data = [ 'repository' => [ 'url' => trim($PK) ]];
                    $data_string = json_encode($data);
                    $ch = curl_init(
                        'https://packagist.org/api/update-package?username='.
                        trim($username).'&apiToken='.
                        trim($API)
                    );
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data_string))
                    );
                    $Jsonresult = curl_exec($ch);
                    $result = json_decode($Jsonresult,true);
                    if($result['status'] === 'success'){
                        return $this->green."\nSuccess ✅️ \n\n".$this->no_color;
                    } else {
                        return "\nMessage : ".$result['message']."\n".
                        $this->red."\nFailed ❗️ \n\n".$this->no_color;
                    }
                }
            }
        } else {
            return "Enter your packagist username : \n";
        }
    }
    public function CheckOs(){
        switch ($this->os){
            case 'Mac':
                return $this->no_color." Mac Version \n";
                break;
            case 'Linux':
                return $this->no_color."🐧 Linux Version \n";
                break;
            case 'Windows':
                return $this->no_color."Windows Version \n";
                break;
        }
    }
}

