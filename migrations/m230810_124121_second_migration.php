<?php

use yii\db\Migration;

/**
 * Class m230810_124121_second_migration
 */
class m230810_124121_second_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'project_id', 'int not null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230810_124121_second_migration cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230810_124121_second_migration cannot be reverted.\n";

        return false;
    }
    */
}
