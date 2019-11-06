<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $contactID
 * @property string $contactGUID
 * @property integer $contactTypeID
 * @property integer $organizationID
 * @property string $firstName
 * @property string $lastName
 * @property string $directLine
 * @property string $directExtension
 * @property string $cellphone
 * @property string $fax
 * @property string $email
 * @property integer $_isDeleted
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contactGUID', 'organizationID', 'firstName', 'lastName', 'directLine', 'email'], 'required'],
            [['contactTypeID', 'organizationID', '_isDeleted'], 'integer'],
            [['contactGUID'], 'string', 'max' => 36],
            [['firstName', 'lastName'], 'string', 'max' => 255],
            [['directLine', 'cellphone', 'fax'], 'string', 'max' => 15],
            [['directExtension'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contactID' => 'Contact ID',
            'contactGUID' => 'Contact Guid',
            'contactTypeID' => 'Contact Type ID',
            'organizationID' => 'Organization ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'directLine' => 'Direct Line',
            'directExtension' => 'Direct Extension',
            'cellphone' => 'Cellphone',
            'fax' => 'Fax',
            'email' => 'Email',
            '_isDeleted' => 'Is Deleted',
        ];
    }

    public function fields() {
		return [
			'contactID' => 'contactID',
			'contactGUID' => function ($row) {
				return (isset($row->contactGUID))? $row->contactGUID: '';
			},
			'name' => function ($row) {
				$firstName = (!empty($row->firstName)? ', ' . $row->firstName: '');
				return $row->lastName . $firstName;
			},
			'firstName' => function ($row) {
				return (isset($row->firstName))? $row->firstName: '';
			},
			'lastName' => function ($row) {
				return (isset($row->lastName))? $row->lastName: '';
			},
			'email' => function ($row) {
				return (isset($row->email))? $row->email: '';
			},
			'phone' => function ($row) {
				$extension = (!empty($row->directExtension)? ' Ext. ' . $row->directExtension: '');
				return $row->directLine . $extension;
			},
			'directLine' => function ($row) {
				return (isset($row->directLine))? $row->directLine: '';
			},
			'directExtension' => function ($row) {
				return (isset($row->directExtension))? $row->directExtension: '';
			},
			'cellphone' => function ($row) {
				return (isset($row->cellphone))? $row->cellphone: '';
			},
			'fax' => function ($row) {
				return (isset($row->fax))? $row->fax: '';
			},
		];
	}    
}
