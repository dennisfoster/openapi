<?php
namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

class RequestSubscription extends \yii\db\ActiveRecord implements Linkable {
	public static function tableName() {
		return 'request_subscription';
	}
	public function rules() {
		return [
			[['requestID', 'userID'], 'required'],
			[['requestSubscriptionID', 'requestID', 'userID', '_createdAt', '_isDeleted'], 'integer'],
		];
	}

    public function fields() {
		return [
            'requestID',
            'userID',
		];
	}

    public function getLinks() {
        return [
            'Request' => Url::to(['request/view', 'id' => $this->requestID], true),
            'User' => Url::to(['user/view', 'id' => $this->userID], true),
        ];
    }

}
