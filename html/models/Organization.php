<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "organization".
 *
 * @property integer $organizationID
 * @property string $organizationGUID
 * @property string $name
 * @property string $address
 * @property string $subPremises
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property double $latitude
 * @property double $longitude
 * @property string $salesforceOrganizationID
 * @property string $salesforceApplicationURL
 * @property string $salesforceClientID
 * @property string $salesforceClientSecret
 */
class Organization extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['address'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['organizationGUID'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 256],
            [['subPremises'], 'string', 'max' => 20],
            [['city'], 'string', 'max' => 50],
            [['state'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 10],
            [['salesforceOrganizationID', 'salesforceApplicationURL', 'salesforceClientID', 'salesforceClientSecret'], 'string', 'max' => 250],
            [['organizationGUID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organizationID' => 'Organization ID',
            'organizationGUID' => 'Organization Guid',
            'name' => 'Name',
            'address' => 'Address',
            'subPremises' => 'Sub Premises',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'salesforceOrganizationID' => 'Salesforce Organization ID',
            'salesforceApplicationURL' => 'Salesforce Application Url',
            'salesforceClientID' => 'Salesforce Client ID',
            'salesforceClientSecret' => 'Salesforce Client Secret',
        ];
    }

    public function fields() {
        return [
            'organizationID',
            'organizationGUID',
            'name',
            'fullAddress' => function($row) {
                return $row->address . ' ' . $row->subPremises . ', ' . $row->city . ', ' . $row->state . ' ' . $row->zip;
            },
            'address',
            'subPremises',
            'city',
            'state',
            'zip',
        ];
    }

    public function getLinks() {
        return [
            Link::REL_SELF => Url::to(['organization/view', 'id' => $this->organizationID], true),
        ];
    }

}
