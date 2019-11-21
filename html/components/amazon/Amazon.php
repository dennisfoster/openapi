<?php

namespace app\components\amazon;

use Yii;
use yii\base\Component;

//require __DIR__ . '/FileEncryption2.php';
//require __DIR__ . '/S3.php';

class Amazon extends Component {

    public $filetype = "userdoc";
	public $encryption;
	public $amazonS3;

    function __construct() {
        $this->encryption = new FileEncryption();
        $this->amazonS3 = new S3(Yii::$app->params['AMAZON_FILE_ACCESS_KEY'], Yii::$app->params['AMAZON_FILE_SECRET_KEY']);
    }

    function get_fileName($document) {
        $documentName = str_replace('/tmp/', '', $document);
        $tempFile = $this->getObject($document);

        return array(
            'tempName' => $tempFile,
            'realName' => $documentName,
        );
    }

    function putObject($file, $access = S3::ACL_PUBLIC_READ) {
        $baseName = basename($file);
        $uri = $this->filetype."/" . $baseName;
        if (!$this->amazonS3->putObjectFile($file, Yii::$app->params['AMAZON_BUCKET'], $uri, $access)) {
            return false;
        } else {
            return $baseName;
        }
    }

    function getObject($document) {
        $tempFile = tempnam(sys_get_temp_dir(), $this->filetype.'-' . time());
		// $baseName = $this->filetype.'/' . $document;
		$baseName = $document;
        $this->amazonS3->getObject(Yii::$app->params['AMAZON_BUCKET'], $baseName, $tempFile);
        return $this->decryptFile($tempFile) ? $this->encryption->destination : false;
    }

    function encryptFile($source) {
        $this->encryption->action = "encrypt";
        $this->encryption->source = $source;
        $this->encryption->destination = tempnam(sys_get_temp_dir(), $this->filetype.'-');
        return $this->encryption->execute() ? true : false;
    }

    function decryptFile($source) {
        $this->encryption->action = "decrypt";
        $this->encryption->source = $source;
        $this->encryption->destination = tempnam(sys_get_temp_dir(), $this->filetype.'-' . time());
        return $this->encryption->execute() ? true : false;
    }

}
