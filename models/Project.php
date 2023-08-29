<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\filters\AccessControl;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $budget
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $status
 * @property string $ducument
 * @property int $progress
 * @property int|null $start_at
 * @property int|null $user_id
 *@property int|null $end_at
 
 * @property User $createdBy
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
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
            [['title', 'description', 'budget','status'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at','progress','status', 'created_by','user_id','start_at','end_at'], 'integer'],
            [['title', 'budget', 'ducument'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['ducument'], 'file', 'extensions' => 'pdf'],
            [['progress'], 'integer', 'min' => 0, 'max' => 100],
            
            // [['end_at'], 'compare', 'compareAttribute' => 'start_at', 'operator' => '>='],
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
            'description' => 'Description',
            'budget' => 'Budget',
            'status' => 'Status',
            'progress' => 'Progress',
            'user_id' => 'Project Manager',
            'start_at'=>'Start Date',
            'end_at'=> 'End Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'ducument' => 'Document',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

  /**
     * @return ActiveQuery
     */
   
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
}
