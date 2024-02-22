<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_profiles}}`.
 */
class m240222_122447_create_client_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_profiles}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(), // Agrega el campo client_id
            'civil_status' => $this->string(),
            'occupation' => $this->string(),
            'membership_level' => $this->string(),
        ]);

        // Asumiendo que existe una relación de clave foránea con la tabla 'clients'
        $this->addForeignKey(
            'fk-client_profiles-client_id',
            '{{%client_profiles}}',
            'client_id', // Usa client_id en lugar de id
            '{{%clients}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client_profiles}}');
    }
}
