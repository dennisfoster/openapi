<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_package".
 *
 * @property integer $requestPackageID
 * @property integer $requestID
 * @property integer $packageID
 * @property string $title
 * @property string $description
 * @property string $dateStart
 * @property string $dateEnd
 * @property integer $quantity
 * @property integer $frequencyMultiplier
 * @property string $frequency
 * @property integer $duration
 * @property string $period
 * @property integer $multiplier
 * @property string $multiplierText
 * @property string $rawJSONPackage
 * @property string $rawJSONBills
 */
class RequestPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestID'], 'required'],
            [['requestID', 'packageID', 'quantity', 'frequencyMultiplier', 'duration', 'multiplier'], 'integer'],
            [['description', 'rawJSONPackage', 'rawJSONBills'], 'string'],
            [['dateStart', 'dateEnd'], 'safe'],
            [['title'], 'string', 'max' => 250],
            [['frequency', 'period'], 'string', 'max' => 10],
            [['multiplierText'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestPackageID' => 'Request Package ID',
            'requestID' => 'Request ID',
            'packageID' => 'Package ID',
            'title' => 'Title',
            'description' => 'Description',
            'dateStart' => 'Date Start',
            'dateEnd' => 'Date End',
            'quantity' => 'Quantity',
            'frequencyMultiplier' => 'Frequency Multiplier',
            'frequency' => 'Frequency',
            'duration' => 'Duration',
            'period' => 'Period',
            'multiplier' => 'Multiplier',
            'multiplierText' => 'Multiplier Text',
            'rawJSONPackage' => 'Raw Jsonpackage',
            'rawJSONBills' => 'Raw Jsonbills',
        ];
    }

    public function fields() {
		return [
			'packageID',
			'packageGUID' => function ($row) {
				return '';
			},
			'link' => 'requestPackageID',
			'title' => function ($row) {
				return (!empty($row->title))? $row->title: '';
			},
			'description' => function ($row) {
				return (!empty($row->description))? $row->description: '';
			},
			'quantity' => function ($row) {
				return (!empty($row->quantity))? $row->quantity: '';
			},
			'frequencyMultiplier' => function ($row) {
				return (!empty($row->frequencyMultiplier))? $row->frequencyMultiplier: '';
			},
			'frequency' => function ($row) {
				return (!empty($row->frequency))? $row->frequency: '';
			},
			'duration' => function ($row) {
				return (!empty($row->duration))? $row->duration: '';
			},
			'period' => function ($row) {
				return (!empty($row->period))? $row->period: '';
			},
			'multiplier' => function ($row) {
				return (!empty($row->multiplier))? $row->multiplier: '';
			},
			'multiplierText' => function ($row) {
				return (!empty($row->multiplierText))? $row->multiplierText: '';
			},
		];
	}
}
