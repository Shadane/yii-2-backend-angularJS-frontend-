<?php

use yii\db\Schema;
use yii\db\Migration;

class m150516_170935_migrationDiplom extends Migration
{
    public function up()
    {
        $sql = file_get_contents(__DIR__.'/ads.sql') ;
        $this->execute($sql);
    }

    public function down()
    {
        echo "m150516_170935_migrationDiplom cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
