<?php
namespace app\models;

/**
* This is the model class for all types.
*
* @property string $slug
* @property string $type
* @property string $abbreviation
*/
class TypeDocument extends \yii\db\ActiveRecord {

	/**
	* @inheritdoc
	*/
	public static function tableName() {
		return 'type_document';
	}

    public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->dbIntranet;
    }

	/**
	* @inheritdoc
	*/
	public function rules() {
		return [
			[['slug', 'type', 'abbreviation'], 'required'],
			[['typeDocumentID'], 'integer'],
			[['slug'], 'string', 'max' => 15],
			[['type'], 'string', 'max' => 150],
			// [['abbreviation'], 'string', 'max' => 7],
		];
	}

	/**
	* @inheritdoc
	*/
	public function attributeLabels() {
		return [
			'typeDocumentID' => 'Index',
			'slug' => 'slug',
			'document' => 'type',
			// 'abbreviation' => 'Abbreviation',
		];
	}

	public function fields() {
		return [
			'slug' => function ($row) {
				return str_replace('-', '_', $row->slug);
			},
			'type' => 'document',
		];
	}

}
