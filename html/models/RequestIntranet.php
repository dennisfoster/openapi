<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property integer $requestID
 * @property integer $employeeID
 * @property integer $createdBy
 * @property integer $typeRequestID
 * @property integer $organizationID
 * @property integer $contactsID
 * @property integer $patientID
 * @property integer $clientID
 * @property integer $packageID
 * @property integer $statusRequestID
 * @property string $bodyPartID
 * @property integer $tierLevel
 * @property string $dueDate
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property double $distance
 * @property double $latitude
 * @property double $longitude
 * @property string $procedures
 * @property string $procedureByUser
 * @property string $reportNote
 * @property integer $isSample
 * @property integer $isTrial
 * @property string $internalNote
 * @property integer $minRows
 * @property string $dataFile
 * @property string $promoCode
 * @property integer $_createdAt
 * @property integer $updatedAt
 */
class RequestIntranet extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'request';
    }

    public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->dbIntranet;
    }

    public function rules() {
        return [
            [['employeeID', 'createdBy', 'typeRequestID', 'organizationID', 'contactsID', 'patientID', 'clientID', 'packageID', 'statusRequestID', 'tierLevel', 'isSample', 'isTrial', 'minRows', '_createdAt', 'updatedAt'], 'integer'],
            [['typeRequestID', 'organizationID', 'address', 'city', 'state', 'zip', 'distance', 'latitude', 'longitude', '_createdAt', 'updatedAt'], 'required'],
            [['dueDate'], 'safe'],
            [['distance', 'latitude', 'longitude'], 'number'],
            [['procedureByUser', 'reportNote', 'internalNote'], 'string'],
            [['bodyPartID', 'city', 'promoCode'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
            [['state', 'zip'], 'string', 'max' => 10],
            [['procedures'], 'string', 'max' => 250],
            [['dataFile'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return [
            'requestID' => 'Request ID',
            'employeeID' => 'Employee ID',
            'createdBy' => 'Created By',
            'typeRequestID' => 'Type Request ID',
            'organizationID' => 'Organization ID',
            'contactsID' => 'Contacts ID',
            'patientID' => 'Patient ID',
            'clientID' => 'Client ID',
            'packageID' => 'Package ID',
            'statusRequestID' => 'Status Request ID',
            'bodyPartID' => 'Body Part ID',
            'tierLevel' => 'Tier Level',
            'dueDate' => 'Due Date',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'distance' => 'Distance',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'procedures' => 'Procedures',
            'procedureByUser' => 'Procedure By User',
            'reportNote' => 'Report Note',
            'isSample' => 'Is Sample',
            'isTrial' => 'Is Trial',
            'internalNote' => 'Internal Note',
            'minRows' => 'Min Rows',
            'dataFile' => 'Data File',
            'promoCode' => 'Promo Code',
            '_createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

	public function fields() {
		return [
			'requestGUID', 'requestGUID',
		];
	}

}
