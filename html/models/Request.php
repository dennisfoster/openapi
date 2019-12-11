<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "request".
 *
 * @property integer $requestID
 * @property string $requestGUID
 * @property integer $requestTypeID
 * @property integer $requestStatusID
 * @property integer $reportTypeID
 * @property integer $reportStatusID
 * @property integer $claimTypeID
 * @property integer $isTrial
 * @property integer $organizationID
 * @property integer $userID
 * @property integer $contactID
 * @property integer $patientID
 * @property string $caseReference
 * @property string $dateOfLoss
 * @property string $distance
 * @property integer $percentile
 * @property string $promoCode
 * @property string $dueDate
 * @property string $customHeader
 * @property string $customNote
 * @property integer $reportConsent
 * @property integer $updatedAt
 * @property integer $_createdAt
 * @property integer $employeeID
 * @property integer $isDownloaded
 * @property integer $_downloadedAt
 * @property string $internalNote
 * @property string $linkToReport
 * @property integer $isSample
 * @property integer $tierLevel
 * @property integer $packageID
 * @property integer $createdBy
 * @property integer $clientID
 * @property string $bodyPartID
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property double $latitude
 * @property double $longitude
 * @property integer $minRows
 * @property string $dataFile
 * @property string $procedures
 * @property string $procedureByUser
 * @property string $customPackage
 */
class Request extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    public function fields() {
        return [
            'requestID',
            'requestGUID',
            'discloseExpert' => function ($row) {
				return $row->isTrial? true: false;
			},
            'customHeader' => function ($row) {
				return (isset($row->customNote))? $row->customNote: '';
			},
			'notes' => function ($row) {
				return (isset($row->customHeader))? $row->customHeader: '';
			},
			'dueDate' => function ($row) {
				if (isset($row->dueDate) && $time = strtotime($row->dueDate)) {
					return date('Y-m-d', $time);
				} else {
					return '';
				}
			},
			'promoCode' => function ($row) {
				return (isset($row->promoCode))? $row->promoCode: '';
			},
			'created' => function ($row) {
				if (isset($row->_createdAt)) {
					return date('Y-m-d H:i:s', $row->_createdAt);
				} else {
					return '';
				}
			},
			'lastUpdated' => function ($row) {
				if (isset($row->updatedAt)) {
					return date('Y-m-d H:i:s', $row->updatedAt);
				} else {
					return '';
				}
			},
            'isDownloaded',
            '_embedded' => function ($row) {
                return [
                    'Type' => $row->typeRequest,
                    'Status' => $row->status,
                    'Report' => $row->report,
                    'Organization' => $row->organization,
                    'User' => $row->user,
                    'Claim' => [
                        'reference' => (isset($row->patient->foreignReference)) ? $row->patient->foreignReference: '',
                        'caseNumber' => (isset($row->patient->caseNumber)) ? $row->patient->caseNumber: '',
                        'dateOfLoss' => (isset($row->patient->dateOfLoss) && $time = strtotime($row->patient->dateOfLoss)) ? date('Y-m-d', $time) : '',
                        'dateOfDiscovery' => '',
                        'dateOfTrial' => '',
                        '_embedded' => ['TypeClaim' => $row->typeClaim],
                    ],
                    'Attorney' => [],
                    'Contact' => (isset($row->contact)) ? $row->contact : [],
                    'Patient' => $row->patient,
                    'Packages' => $row->requestPackage,
                    'Bills' => $row->bill,
                    'Pharmaceuticals' => $row->pharmaceutical,
                    'Attachments' => $row->attachment,
                    'Documents' => $row->document,
            ];
            },
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestGUID', 'userID', 'updatedAt', '_createdAt'], 'required'],
            [['requestTypeID', 'requestStatusID', 'reportTypeID', 'reportStatusID', 'claimTypeID', 'isTrial', 'organizationID', 'userID', 'contactID', 'patientID', 'percentile', 'reportConsent', 'updatedAt', '_createdAt', 'employeeID', 'isDownloaded', '_downloadedAt', 'isSample', 'tierLevel', 'packageID', 'createdBy', 'clientID', 'minRows'], 'integer'],
            [['dateOfLoss', 'dueDate'], 'safe'],
            [['distance', 'latitude', 'longitude'], 'number'],
            [['customHeader', 'customNote', 'internalNote', 'procedureByUser', 'customPackage'], 'string'],
            [['requestGUID'], 'string', 'max' => 36],
            [['caseReference'], 'string', 'max' => 40],
            [['promoCode', 'bodyPartID', 'city'], 'string', 'max' => 50],
            [['linkToReport'], 'string', 'max' => 150],
            [['address'], 'string', 'max' => 200],
            [['state', 'zip'], 'string', 'max' => 10],
            [['dataFile'], 'string', 'max' => 255],
            [['procedures'], 'string', 'max' => 250],
            [['requestGUID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestID' => 'Request ID',
            'requestGUID' => 'Request Guid',
            'requestTypeID' => 'Request Type ID',
            'requestStatusID' => 'Request Status ID',
            'reportTypeID' => 'Report Type ID',
            'reportStatusID' => 'Report Status ID',
            'claimTypeID' => 'Claim Type ID',
            'isTrial' => 'Is Trial',
            'organizationID' => 'Organization ID',
            'userID' => 'User ID',
            'contactID' => 'Contact ID',
            'patientID' => 'Patient ID',
            'caseReference' => 'Case Reference',
            'dateOfLoss' => 'Date Of Loss',
            'distance' => 'Distance',
            'percentile' => 'Percentile',
            'promoCode' => 'Promo Code',
            'dueDate' => 'Due Date',
            'customHeader' => 'Custom Header',
            'customNote' => 'Custom Note',
            'reportConsent' => 'Report Consent',
            'updatedAt' => 'Updated At',
            '_createdAt' => 'Created At',
            'employeeID' => 'Employee ID',
            'isDownloaded' => 'Is Downloaded',
            '_downloadedAt' => 'Downloaded At',
            'internalNote' => 'Internal Note',
            'linkToReport' => 'Link To Report',
            'isSample' => 'Is Sample',
            'tierLevel' => 'Tier Level',
            'packageID' => 'Package ID',
            'createdBy' => 'Created By',
            'clientID' => 'Client ID',
            'bodyPartID' => 'Body Part ID',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'minRows' => 'Min Rows',
            'dataFile' => 'Data File',
            'procedures' => 'Procedures',
            'procedureByUser' => 'Procedure By User',
            'customPackage' => 'Custom Package',
        ];
    }

    public function getLinks() {
        return [
            Link::REL_SELF => Url::to(['request/view', 'id' => $this->requestID], true),
        ];
    }

    public function getTypeRequest() {
		return $this->hasOne(TypeRequest::className(), ['requestTypeID' => 'requestTypeID']);
	}

    public function getTypeClaim() {
		return $this->hasOne(TypeClaim::className(), ['claimTypeID' => 'claimTypeID']);
	}

    public function getStatus() {
		return $this->hasOne(StatusRequest::className(), ['requestStatusID' => 'requestStatusID']);
	}

    public function getReport() {
		return $this->hasOne(TypeReport::className(), ['reportTypeID' => 'reportTypeID']);
	}

    public function getOrganization() {
		return $this->hasOne(Organization::className(), ['organizationID' => 'organizationID']);
	}

    public function getUser() {
		return $this->hasOne(User::className(), ['userID' => 'userID']);
	}

    public function getPatient() {
		return $this->hasOne(Patient::className(), ['patientID' => 'patientID']);
	}

    public function getContact() {
		return $this->hasOne(Contact::className(), ['contactID' => 'contactID']);
	}

    public function getRequestPackage() {
		return $this->hasMany(RequestPackage::className(), ['requestID' => 'requestID']);
	}

    public function getBill() {
		return $this->hasMany(RequestBill::className(), ['requestID' => 'requestID'])->with('bill');
	}

    public function getPharmaceutical() {
		return $this->hasMany(RequestPharmaceutical::className(), ['requestID' => 'requestID']);
	}

    public function getAttachment() {
		return $this->hasMany(RequestAttachment::className(), ['requestID' => 'requestID'])->where(['request_attachment.isDeleted' => 0]);
	}

    public function getDocument() {
		return RequestDocument::getPublishedDocumentsByRequestGUID($this->requestGUID);
	}

}
