<?php
namespace app\components\amazon;

use Yii;

//*********************************************************************************************************************
// Class:			Document Storage Handler
// Description:		Class definition for controller that handles events and their associated methods and file
//					manipulation
//*********************************************************************************************************************
class FileEncryption {

    const SIZE_LIMIT_PLAIN = 4194304;
    const SIZE_LIMIT_CRYPT = 5592470;
    const CHUNK_SIZE_PLAIN = 1048576;
    const CHUNK_SIZE_CRYPT = 1398104;

    protected $password;
    protected $salt;

    public $error;
    public $action;
    public $source;
    public $destination;

	public function __construct() {
		$this->password = Yii::$app->params['ENCRYPTION_PASSWORD_KEY'];
	    $this->salt =  Yii::$app->params['ENCRYPTION_SALT_KEY'];
	}

    // method: set this instance of object
    function set($settings) {
        if (!isset($settings['action']) || !$this->action = $settings['action']) {
            trigger_error('ERROR: Action required for File Encryption Handler!');
            exit();
        }
        if (!isset($settings['source']) || !$this->source = $settings['source']) {
            trigger_error('ERROR: Source file required for Encryption Handler!');
            exit();
        }
        if (!isset($settings['destination']) || !$this->destination = $settings['destination']) {
            trigger_error('ERROR: Destination file required for Encryption Handler!');
            exit();
        }
        return TRUE;
    }

    // encrypt or decrypt
    function execute() {
        if ($this->action == 'encrypt') {

            $key = hash('SHA256', $this->salt . $this->password, true);
            $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
            if (strlen($ivBase64 = rtrim(base64_encode($iv), '=')) != 22) {
                $this->error = 'ERROR: Error in encrypting file.';
                return FALSE;
            }
            if (($filesize = filesize($this->source)) <= self::SIZE_LIMIT_PLAIN) {
                $contents = file_get_contents($this->source);
                $encrypted = $ivBase64 . base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $contents . md5($contents), MCRYPT_MODE_CBC, $iv));
                file_put_contents($this->destination, $encrypted);

            } else {
                $remaining = $filesize;
                $source = fopen($this->source, 'r');
                $destination = fopen($this->destination, 'w');
                fwrite($destination, $ivBase64);
                while (($contents = fread($source, self::CHUNK_SIZE_PLAIN)) && $remaining) {
                    $remaining -= self::CHUNK_SIZE_PLAIN;
                    if (!feof($source) && $remaining)
                        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $contents, MCRYPT_MODE_CBC, $iv));
                    else
                        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $contents . md5($contents), MCRYPT_MODE_CBC, $iv));
                    fwrite($destination, $encrypted);
                }
                fclose($source);
                fclose($destination);
            }

            unset($contents);
            unset($encrypted);
            return TRUE;

        } elseif ($this->action == 'decrypt') {

            $key = hash('SHA256', $this->salt . $this->password, true);
            if (($filesize = filesize($this->source)) <= self::SIZE_LIMIT_CRYPT) {
                $encrypted = file_get_contents($this->source);
                $iv = base64_decode(substr($encrypted, 0, 22) . '==');
                $encrypted = base64_decode(substr($encrypted, 22));
                $contents = substr(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv), "\0\4"), 0, -32);
                file_put_contents($this->destination, $contents);

            } else {
                $remaining = $filesize;
                $source = fopen($this->source, 'r');
                $destination = fopen($this->destination, 'w');
                $iv = base64_decode(fread($source, 22) . '==');
                $remaining -= 22;
                while (($encrypted = fread($source, self::CHUNK_SIZE_CRYPT)) && $remaining) {
                    $remaining -= self::CHUNK_SIZE_CRYPT;
                    if ($remaining >= 1 && $remaining <= 40) {
                        $encrypted .= fread($source, $remaining);
                        $remaining = 0;
                    }
                    if (!feof($source) && $remaining)
                        $contents = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
                    else
                        $contents = substr(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4"), 0, -32);
                    fwrite($destination, $contents);
                }
                fclose($source);
                fclose($destination);
            }

            unset($contents);
            unset($encrypted);
            return TRUE;

        } else {
            $this->error = 'ERROR: Unknown action for File Encryption Handler!';
            exit();
        }
    }

    function get($key) {
        return $this->$key;
    }

}
