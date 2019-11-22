<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "patient".
 *
 * @property integer $patientID
 * @property string $patientGUID
 * @property integer $organizationID
 * @property string $foreignReference
 * @property string $caseNumber
 * @property string $dateOfLoss
 * @property string $firstName
 * @property string $middleInitial
 * @property string $lastName
 * @property string $dateOfBirth
 * @property string $sex
 * @property string $address
 * @property string $subPremises
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $latitude
 * @property string $longitude
 * @property integer $_isDeleted
 */
class Patient extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organizationID', '_isDeleted'], 'integer'],
            [['dateOfLoss', 'dateOfBirth'], 'safe'],
            [['firstName', 'lastName', 'sex', 'address', 'city', 'state', 'zip'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['patientGUID'], 'string', 'max' => 36],
            [['foreignReference', 'city'], 'string', 'max' => 50],
            [['caseNumber', 'subPremises'], 'string', 'max' => 20],
            [['firstName', 'lastName', 'address'], 'string', 'max' => 150],
            [['middleInitial'], 'string', 'max' => 3],
            [['sex'], 'string', 'max' => 1],
            [['state'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 10],
            [['patientGUID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'patientID' => 'Patient ID',
            'patientGUID' => 'Patient Guid',
            'organizationID' => 'Organization ID',
            'foreignReference' => 'Foreign Reference',
            'caseNumber' => 'Case Number',
            'dateOfLoss' => 'Date Of Loss',
            'firstName' => 'First Name',
            'middleInitial' => 'Middle Initial',
            'lastName' => 'Last Name',
            'dateOfBirth' => 'Date Of Birth',
            'sex' => 'Sex',
            'address' => 'Address',
            'subPremises' => 'Sub Premises',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            '_isDeleted' => 'Is Deleted',
        ];
    }

    public function fields() {
		return [
            'patientID',
			'patientGUID' => function ($row) {
				return (isset($row->patientGUID))? $row->patientGUID: '';
			},
			'name' => function ($row) {
				$middleInitial = (!empty($row->middleInitial)? ' ' . $row->middleInitial: '');
				$firstNameWithMiddleInitial = (!empty($row->firstName)? ', ' . $row->firstName . $middleInitial: '');
				return $row->lastName . $firstNameWithMiddleInitial;
			},
			'firstName' => function ($row) {
				return (isset($row->firstName))? $row->firstName: '';
			},
			'middleInitial' => function ($row) {
				return (isset($row->middleInitial))? $row->middleInitial: '';
			},
			'lastName' => function ($row) {
				return (isset($row->lastName))? $row->lastName: '';
			},
			'sex' => function ($row) {
				return (isset($row->sex))? $row->sex: '';
			},
			'fullAddress' => function ($row) {
				$fullAddress = '';
				$fullAddress .= (!empty($row->address)? $row->address: '');
				$fullAddress .= (!empty($row->subPremises)? (!empty($fullAddress)? ' ': '') . $row->subPremises: '');
				$fullAddress .= (!empty($row->city)? (!empty($fullAddress)? ', ': '') . $row->city: '');
				$fullAddress .= (!empty($row->state)? (!empty($fullAddress)? ', ': '') . $row->state: '');
				$fullAddress .= (!empty($row->zip)? (!empty($fullAddress)? ' ': '') . $row->zip: '');
				$fullAddress .= (!empty($row->country)? (!empty($fullAddress)? ', ': '') . $row->country: '');
				return $fullAddress;
			},
			'address' => function ($row) {
				return (isset($row->address))? $row->address: '';
			},
			'subPremises' => function ($row) {
				return (isset($row->subPremises))? $row->subPremises: '';
			},
			'city' => function ($row) {
				return (isset($row->city))? $row->city: '';
			},
			'state' => function ($row) {
				return (isset($row->state))? $row->state: '';
			},
			'zip' => function ($row) {
				return (isset($row->zip))? $row->zip: '';
			},
			'country' => function ($row) {
				return (isset($row->country))? $row->country: '';
			},
			'latitude' => function ($row) {
				return (isset($row->latitude))? $row->latitude: '';
			},
			'longitude' => function ($row) {
				return (isset($row->longitude))? $row->longitude: '';
			},
			'dateOfBirth' => function ($row) {
				if (isset($row->dateOfBirth) && $time = strtotime($row->dateOfBirth)) {
					return date('Y-m-d', $time);
				} else {
					return '';
				}
			},
		];
	}

    public function getLinks() {
        return [
            Link::REL_SELF => Url::to(['patient/view', 'id' => $this->patientID], true),
        ];
    }
}
