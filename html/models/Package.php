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
class Package extends \yii\db\ActiveRecord implements Linkable
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
            Link::REL_SELF => Url::to(['package/view', 'id' => $this->packageID], true),
        ];
    }

    public static function search($terms) {

        $query = self::_buildQuery($terms);

        $sort = ['score' => SORT_DESC];

        $query->orderBy($sort);
        return $query;
    }

    protected static function _buildQuery($terms) {
        $select = [
            'package.packageID',
            'package.title',
            'package.description',
            'package.isPublished'
        ];
        $query = self::find()->select($select);
        $query->where(['isPublished' => IS_TRUE, 'isPersonalInjury' => IS_TRUE, 'isDeleted' => IS_FALSE]);

        $minScore = 0;
        $sumScore = '';

        $subQueries = [];

        // add subQuery for searching meta values
        if ($terms) {
            $keywords = explode(' ', $terms);

            foreach ($keywords as $term) {
                if (!empty($term)) {

                    $subQuery = new \yii\db\Query;
                    $select = ['package_attribute.packageID', 'convert(2, decimal) as score'];
                    $subQuery->select($select)->distinct()->from('package_attribute');
                    $subQuery->andWhere(['OR LIKE', 'package_attribute.metaValue', $term]);
                    $subQueries[] = $subQuery;

                    $subQuery = new \yii\db\Query;
                    $select = ['package.packageID', 'convert(4, decimal) as score'];
                    $subQuery->select($select)->distinct()->from('package');
                    $subQuery->orWhere(['LIKE', 'package.title', $term]);
                    $subQuery->orWhere(['LIKE', 'package.description', $term]);
                    $subQueries[] = $subQuery;
                }
            }
        }

        if (!empty($subQueries)) {
            $count = count($subQueries);
            for ($i = 0; $i < $count; $i++) {
                $table = 'tmp' . $i;
                $minScore += 0.5;
                $sumScore .= ' + (if(isnull(' . $table . '.score), 0, ' . $table . '.score))';
                $query->leftJoin([$table => $subQueries[$i]], $table . '.packageID = package.packageID');
            }
        }

        $match = "MATCH (title, description) AGAINST ('$terms' IN BOOLEAN MODE)";
        $sumSelect = '(' . $match . $sumScore . ') as score';
        $query->addSelect([$sumSelect]);
        $query->orderBy(['score' => 'DESC', 'title' => 'ASC']);
        $query->having(['>', 'score', $minScore]);

        return $query;

    }

    public static function count($terms) {
        $query = self::_buildQuery($terms);
        return $query->count();
    }

}
