<?php

use yii\db\Migration;

/**
 * Class m221022_140336_init
 */
class m221022_140336_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('role', [
            'role_id' => $this->primaryKey(),
            'role_name' => $this->string()->notNull(),
        ]);

        $this->insert('role', [
            'role_name' => 'regular',
        ]);

        $this->insert('role', [
            'role_name' => 'admin',
        ]);

        $this->createTable('company', [
            'company_id' => $this->primaryKey(),
            'company_name' => $this->string()->notNull(),
        ]);

        $this->createTable('hiring_team', [
            'hiring_team_id' => $this->primaryKey(),
        ]);

        $this->createTable('member', [
            'member_id' => $this->primaryKey(),
            'member_email' => $this->string()->notNull(),
            'role_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('hiring_team_member', [
            'hiring_team_id' => $this->integer()->notNull(),
            'member_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('job', [
            'job_id' => $this->primaryKey(),
            'job_title' => $this->string()->notNull(),
            'job_description' => $this->text()->notNull(),
            'job_creation_date' => $this->date()->notNull(),
            'hiring_team_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
        ]);

        // member FK for role_id
        $this->addForeignKey(
            'member__to__role',
            'member',
            'role_id',
            'role',
            'role_id',
            'CASCADE',
            'CASCADE',
        );

        // member FK for company_id
        $this->addForeignKey(
            'member__to__company',
            'member',
            'company_id',
            'company',
            'company_id',
            'CASCADE',
            'CASCADE',
        );

        // hiring_team_member FK for member_id
        $this->addForeignKey(
            'hiring_team_member__to__member',
            'hiring_team_member',
            'member_id',
            'member',
            'member_id',
            'CASCADE',
            'CASCADE',
        );

        // hiring_team_member FK for hiring_team_id
        $this->addForeignKey(
            'hiring_team_member__to__hiring_team',
            'hiring_team_member',
            'hiring_team_id',
            'hiring_team',
            'hiring_team_id',
            'CASCADE',
            'CASCADE',
        );

        // job FK for hiring_team_id
        $this->addForeignKey(
            'job__to__hiring_team',
            'job',
            'hiring_team_id',
            'hiring_team',
            'hiring_team_id',
            'CASCADE',
            'CASCADE',
        );

        // job FK for company_id
        $this->addForeignKey(
            'job__to__company',
            'job',
            'company_id',
            'company',
            'company_id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221022_140336_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221022_140336_init cannot be reverted.\n";

        return false;
    }
    */
}
