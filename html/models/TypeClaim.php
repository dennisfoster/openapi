<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_claim".
 *
 * @property integer $claimTypeID
 * @property string $slug
 * @property string $type
 * @property string $description
 * @property string $abbreviation
 * @property integer $isActive
 */
class TypeClaim extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_claim';
    }

    public function fields() {
        return ['slug', 'type'];
    }    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['claimTypeID', 'slug', 'type', 'abbreviation'], 'required'],
            [['claimTypeID', 'isActive'], 'integer'],
            [['slug'], 'string', 'max' => 15],
            [['type'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 255],
            [['abbreviation'], 'string', 'max' => 7],
            [['slug'], 'unique'],
            [['type'], 'unique'],
            [['abbreviation'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'claimTypeID' => 'Claim Type ID',
            'slug' => 'Slug',
            'type' => 'Type',
            'description' => 'Description',
            'abbreviation' => 'Abbreviation',
            'isActive' => 'Is Active',
        ];
    }
}
