<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_pharmaceutical".
 *
 * @property integer $requestPharmaceuticalID
 * @property integer $requestID
 * @property string $pharmaceuticalGUID
 * @property string $quantity
 * @property string $unit
 * @property string $frequency
 * @property integer $duration
 * @property string $period
 */
class RequestPharmaceutical extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_pharmaceutical';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestID', 'pharmaceuticalGUID'], 'required'],
            [['requestID', 'duration'], 'integer'],
            [['quantity'], 'number'],
            [['frequency', 'period'], 'string'],
            [['pharmaceuticalGUID'], 'string', 'max' => 36],
            [['unit'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestPharmaceuticalID' => 'Request Pharmaceutical ID',
            'requestID' => 'Request ID',
            'pharmaceuticalGUID' => 'Pharmaceutical Guid',
            'quantity' => 'Quantity',
            'unit' => 'Unit',
            'frequency' => 'Frequency',
            'duration' => 'Duration',
            'period' => 'Period',
        ];
    }

    public function fields() {
		return [
			'pharmaceuticalGUID' => function ($row) {
				return (isset($row->pharmaceuticalGUID))? $row->pharmaceuticalGUID: '';
			},
			'ndc' => function ($row) {
				return $row->pharmaceutical->ndc;
			},
			'name' => function ($row) {
				return $row->pharmaceutical->name;
			},
			'quantity' => function ($row) {
				return (isset($row->quantity))? $row->quantity: '';
			},
			'unit' => function ($row) {
				return $row->pharmaceutical->unit;
			},
			'frequency' => function ($row) {
				return (isset($row->frequency))? $row->frequency: '';
			},
			'duration' => function ($row) {
				return (isset($row->duration))? $row->duration: '';
			},
			'period' => function ($row) {
				return (isset($row->period))? $row->period: '';
			},
		];
	}

    public function getPharmaceutical() {
		return $this->hasOne(Pharmaceutical::className(), ['pharmaceuticalGUID' => 'pharmaceuticalGUID']);
	}
}
