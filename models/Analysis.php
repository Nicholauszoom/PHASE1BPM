<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "analysis".
 *
 * @property int $id
 * @property string $title
 * @property string $item
 * @property string $description
 * @property int $quantity
 * @property int $cost
 * @property int $project
 * @property string $boq
 * @property string $files
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class Analysis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analysis';
    }

    public function behaviors(){
        return [
            TimestampBehavior::class,
            [
                'class'=>BlameableBehavior::class,
                'updatedByAttribute'=>false,
            ],
          
           
            
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'item', 'description', 'quantity', 'cost','project'], 'required'],
            [['quantity', 'cost', 'created_at', 'updated_at', 'created_by','project'], 'integer'],
            [['title', 'item', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'item' => 'Item',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'cost' => 'Cost',
            'boq' => 'Boq',
            'project' => 'Project',
            'files' => 'Files',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project']);
    }
}
