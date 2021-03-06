<?php

use yii\db\Migration;

class m140709_173333_widget_text extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%widget_text}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'key' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'body' => $this->text()->notNull(),
            'status' => $this->smallInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx_widget_text_key', '{{%widget_text}}', 'key');
    }

    public function down()
    {
        $this->dropTable('{{%widget_text}}');
    }
}
