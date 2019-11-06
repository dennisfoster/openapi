<?php

namespace app\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "package".
 *
 * @property integer $packageID
 * @property integer $parentPackageID
 * @property integer $packageTypeID
 * @property integer $bodyPartID
 * @property string $bodyPartSlug
 * @property string $title
 * @property string $description
 * @property integer $totalNationalValue
 * @property integer $employeeID
 * @property integer $isPublished
 * @property integer $isStackable
 * @property integer $isWorkersCompensation
 * @property integer $isPersonalInjury
 * @property integer $isFlaggedForReview
 * @property integer $isExpress
 * @property integer $isDeleted
 * @property integer $_created
 * @property integer $_updated
 */
class Packages extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->dbPackage;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentPackageID', 'packageTypeID', 'bodyPartID', 'totalNationalValue', 'employeeID', 'isPublished', 'isStackable', 'isWorkersCompensation', 'isPersonalInjury', 'isFlaggedForReview', 'isExpress', 'isDeleted', '_created', '_updated'], 'integer'],
            [['title', 'description', 'employeeID', '_created', '_updated'], 'required'],
            [['description'], 'string'],
            [['bodyPartSlug'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'packageID' => 'Package ID',
            'parentPackageID' => 'Parent Package ID',
            'packageTypeID' => 'Package Type ID',
            'bodyPartID' => 'Body Part ID',
            'bodyPartSlug' => 'Body Part Slug',
            'title' => 'Title',
            'description' => 'Description',
            'totalNationalValue' => 'Total National Value',
            'employeeID' => 'Employee ID',
            'isPublished' => 'Is Published',
            'isStackable' => 'Is Stackable',
            'isWorkersCompensation' => 'Is Workers Compensation',
            'isPersonalInjury' => 'Is Personal Injury',
            'isFlaggedForReview' => 'Is Flagged For Review',
            'isExpress' => 'Is Express',
            'isDeleted' => 'Is Deleted',
            '_created' => 'Created',
            '_updated' => 'Updated',
        ];
    }

    public function getLinks() {
        return [
            Link::REL_SELF => Url::to(['packages/view', 'id' => $this->packageID], true),
        ];
    }

}
