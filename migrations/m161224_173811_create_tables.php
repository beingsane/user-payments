<?php

use yii\db\Schema;
use yii\db\Expression as DbExpression;

class m161224_173811_create_tables extends yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultValue(new DbExpression('CURRENT_TIMESTAMP'))->notNull(),
        ]);

        $this->createIndex('user_id', '{{%account}}', 'user_id', true);
        $this->createIndex('created_at', '{{%account}}', 'created_at', false);


        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey()->notNull(),
            'transaction_id' => $this->integer()->notNull(),
            'account_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultValue(new DbExpression('CURRENT_TIMESTAMP'))->notNull(),
        ]);

        $this->createIndex('created_at', '{{%payment}}', 'created_at', false);
        $this->createIndex('FK_payment_payment_transaction', '{{%payment}}', 'transaction_id', false);
        $this->createIndex('FK_payment_payment_type', '{{%payment}}', 'type_id', false);
        $this->createIndex('FK_payment_account', '{{%payment}}', 'account_id', false);


        $this->createTable('{{%payment_transaction}}', [
            'id' => $this->primaryKey()->notNull(),
        ]);


        $this->createTable('{{%payment_type}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(30)->notNull(),
        ]);


        $this->createTable('{{%transfer}}', [
            'id' => $this->primaryKey()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'from_user_id' => $this->integer()->notNull(),
            'to_user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'state_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultValue(new DbExpression('CURRENT_TIMESTAMP'))->notNull(),
        ]);

        $this->createIndex('created_at', '{{%transfer}}', 'created_at', false);
        $this->createIndex('FK_transfer_transfer_type', '{{%transfer}}', 'type_id', false);
        $this->createIndex('FK_transfer_transfer_state', '{{%transfer}}', 'state_id', false);
        $this->createIndex('FK_transfer_from_user', '{{%transfer}}', 'from_user_id', false);
        $this->createIndex('FK_transfer_to_user', '{{%transfer}}', 'to_user_id', false);


        $this->createTable('{{%transfer_state}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(30)->notNull(),
        ]);


        $this->createTable('{{%transfer_type}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(30)->notNull(),
        ]);


        $this->addForeignKey('FK_account_user', '{{%account}}', 'user_id', '{{%user}}', 'id', null, null);

        $this->addForeignKey('FK_payment_payment_type', '{{%payment}}', 'type_id', '{{%payment_type}}', 'id', null, null);
        $this->addForeignKey('FK_payment_payment_transaction', '{{%payment}}', 'transaction_id', '{{%payment_transaction}}', 'id', null, null);
        $this->addForeignKey('FK_payment_account', '{{%payment}}', 'account_id', '{{%account}}', 'id', null, null);

        $this->addForeignKey('FK_transfer_transfer_type', '{{%transfer}}', 'type_id', '{{%transfer_type}}', 'id', null, null);
        $this->addForeignKey('FK_transfer_transfer_state', '{{%transfer}}', 'state_id', '{{%transfer_state}}', 'id', null, null);
        $this->addForeignKey('FK_transfer_to_user', '{{%transfer}}', 'to_user_id', '{{%user}}', 'id', null, null);
        $this->addForeignKey('FK_transfer_from_user', '{{%transfer}}', 'from_user_id', '{{%user}}', 'id', null, null);


        $data = [
            ['id' => '1', 'name' => 'Debet'],
            ['id' => '2', 'name' => 'Credit'],
        ];
        $this->batchInsert('{{%payment_type}}', [], $data);

        $data = [
            ['id' => '1', 'name' => 'Awaiting'],
            ['id' => '2', 'name' => 'Accepted'],
            ['id' => '3', 'name' => 'Declined'],
        ];
        $this->batchInsert('{{%transfer_state}}', [], $data);

        $data = [
            ['id' => '1', 'name' => 'Send'],
            ['id' => '2', 'name' => 'Receive'],
        ];
        $this->batchInsert('{{%transfer_type}}', [], $data);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        $this->dropTable('{{%transfer_type}}');
        $this->dropTable('{{%transfer_state}}');
        $this->dropTable('{{%transfer}}');
        $this->dropTable('{{%payment_type}}');
        $this->dropTable('{{%payment_transaction}}');
        $this->dropTable('{{%payment}}');
        $this->dropTable('{{%account}}');

        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
