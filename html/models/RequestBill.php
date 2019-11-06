<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_bill".
 *
 * @property integer $requestBillID
 * @property integer $requestID
 * @property integer $packageID
 * @property integer $requestPackageID
 * @property integer $billID
 * @property integer $quantity
 * @property integer $isIncluded
 */
class RequestBill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestID', 'packageID', 'billID'], 'required'],
            [['requestID', 'packageID', 'requestPackageID', 'billID', 'quantity', 'isIncluded'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestBillID' => 'Request Bill ID',
            'requestID' => 'Request ID',
            'packageID' => 'Package ID',
            'requestPackageID' => 'Request Package ID',
            'billID' => 'Bill ID',
            'quantity' => 'Quantity',
            'isIncluded' => 'Is Included',
        ];
    }

    public function fields() {
		return [
			'title' => function ($row) {
				return $row->bill->title;
			},
			'description' => function ($row) {
				return $row->bill->description;
			},
			'quantity',
            'packageID' => 'requestPackageID',
			'source' => function ($row) {
				return $row->bill->payload;
			},
		];
	}

	public function getBill() {
		return $this->hasOne(Bill::className(), ['billID' => 'billID']);
	}
}
