<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "user".
 *
 * @property integer $userID
 * @property string $userGUID
 * @property integer $organizationID
 * @property integer $consentToEula
 * @property integer $consentToHipaa
 * @property string $email
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $phone
 * @property string $cellPhone
 * @property string $directLine
 * @property string $directExtension
 * @property integer $isActive
 * @property integer $isSysAdmin
 * @property integer $isExpert
 * @property integer $isExpertReviewComplete
 * @property integer $hasExpertAccess
 * @property integer $isTempPassword
 * @property integer $_createdOn
 * @property integer $updatedOn
 * @property string $authKey
 * @property string $accessToken
 * @property string $salesforceIdentityURL
 * @property string $salesforceUserID
 * @property string $salesforceOAuth2AccessToken
 * @property string $salesforceOAuth2RefreshToken
 * @property string $salesforceSignature
 */
class User extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organizationID', 'consentToEula', 'consentToHipaa', 'isActive', 'isSysAdmin', 'isExpert', 'isExpertReviewComplete', 'hasExpertAccess', 'isTempPassword', '_createdOn', 'updatedOn'], 'integer'],
            [['email', 'password', 'firstName', 'lastName', '_createdOn', 'updatedOn', 'authKey', 'accessToken'], 'required'],
            [['userGUID'], 'string', 'max' => 36],
            [['email', 'firstName', 'lastName'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 132],
            [['phone', 'cellPhone', 'directLine', 'directExtension'], 'string', 'max' => 15],
            [['authKey', 'accessToken'], 'string', 'max' => 32],
            [['salesforceIdentityURL', 'salesforceUserID', 'salesforceOAuth2AccessToken', 'salesforceOAuth2RefreshToken', 'salesforceSignature'], 'string', 'max' => 250],
            [['email'], 'unique'],
            [['userGUID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userID' => 'User ID',
            'userGUID' => 'User Guid',
            'organizationID' => 'Organization ID',
            'consentToEula' => 'Consent To Eula',
            'consentToHipaa' => 'Consent To Hipaa',
            'email' => 'Email',
            'password' => 'Password',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'phone' => 'Phone',
            'cellPhone' => 'Cell Phone',
            'directLine' => 'Direct Line',
            'directExtension' => 'Direct Extension',
            'isActive' => 'Is Active',
            'isSysAdmin' => 'Is Sys Admin',
            'isExpert' => 'Is Expert',
            'isExpertReviewComplete' => 'Is Expert Review Complete',
            'hasExpertAccess' => 'Has Expert Access',
            'isTempPassword' => 'Is Temp Password',
            '_createdOn' => 'Created On',
            'updatedOn' => 'Updated On',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'salesforceIdentityURL' => 'Salesforce Identity Url',
            'salesforceUserID' => 'Salesforce User ID',
            'salesforceOAuth2AccessToken' => 'Salesforce Oauth2 Access Token',
            'salesforceOAuth2RefreshToken' => 'Salesforce Oauth2 Refresh Token',
            'salesforceSignature' => 'Salesforce Signature',
        ];
    }

    public function fields() {
        return [
            'userGUID' => function ($row) {
				return (isset($row->userGUID))? $row->userGUID: '';
			},
			'name' => function ($row) {
				return $row->lastName . (!empty($row->firstName)? ', ' . $row->firstName: '');
			},
			'lastName' => function ($row) {
				return (isset($row->lastName))? $row->lastName: '';
			},
			'firstName' => function ($row) {
				return (isset($row->firstName))? $row->firstName: '';
			},
			'email' => function ($row) {
				return (isset($row->email))? $row->email: '';
			},
			'phone' => function ($row) {
				$extension = (!empty($row->directExtension)? ' Ext. ' . $row->directExtension: '');
				return $row->directLine . $extension;
			},
			'directLine' => function ($row) {
				return (isset($row->directLine))? $row->directLine: '';
			},
			'directExtension' => function ($row) {
				return (isset($row->directExtension))? $row->directExtension: '';
			},
			'cellphone' => function ($row) {
				return (isset($row->cellphone))? $row->cellphone: '';
			},
			'other' => function ($row) {
				return (isset($row->phone))? $row->phone: '';
			},
        ];
    }

    public function getLinks() {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->userID], true),
        ];
    }

}
