<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property int $budget
 * @property string $code
 * @property string $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $project_id
 * @property int $status
 * @property int $team_id
 * @property int $user_id
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

  

    public function behaviors(){
        return [
            TimestampBehavior::class,
            [
                'class'=>BlameableBehavior::class,
                'updatedByAttribute'=>false,
            ],

            // [

            //     'class'=>SluggableBehavior::class,
            //     'attribute'=>'title',
            // ],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'budget', 'code', 'project_id', 'team_id','status','description'], 'required'],
            [['budget', 'created_at', 'updated_at', 'created_by', 'project_id', 'team_id'], 'integer'],
            [['title', 'code'], 'string', 'max' => 255],
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
            'budget' => 'Budget',
            'code' => 'Code',
            'project_id' => 'Project',
            'description'=> 'Description',
            'team_id' => 'Team',
            'status'=>'Status',
            'created_at' => 'Created At',
            // 'updated_at' => 'Updated At',
            // 'created_by' => 'Created By',
           
        ];
    }
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }
  
}
