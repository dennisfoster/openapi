<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pharmaceutical".
 *
 * @property integer $pharmaceuticalID
 * @property string $pharmaceuticalGUID
 * @property string $ndc
 * @property string $name
 * @property string $price
 * @property string $unit
 * @property integer $isOverTheCounter
 * @property string $classification
 * @property string $effectiveDate
 * @property string $data
 */
class Pharmaceutical extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pharmaceutical';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pharmaceuticalGUID', 'name', 'price', 'unit', 'effectiveDate', 'data'], 'required'],
            [['price'], 'number'],
            [['isOverTheCounter'], 'integer'],
            [['classification', 'data'], 'string'],
            [['effectiveDate'], 'safe'],
            [['pharmaceuticalGUID'], 'string', 'max' => 36],
            [['ndc'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 150],
            [['unit'], 'string', 'max' => 2],
            [['pharmaceuticalGUID'], 'unique'],
            [['ndc'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pharmaceuticalID' => 'Pharmaceutical ID',
            'pharmaceuticalGUID' => 'Pharmaceutical Guid',
            'ndc' => 'Ndc',
            'name' => 'Name',
            'price' => 'Price',
            'unit' => 'Unit',
            'isOverTheCounter' => 'Is Over The Counter',
            'classification' => 'Classification',
            'effectiveDate' => 'Effective Date',
            'data' => 'Data',
        ];
    }
}
