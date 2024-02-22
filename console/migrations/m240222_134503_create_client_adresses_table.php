<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_adresses}}`.
 */
class m240222_134503_create_client_adresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_addresses}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'street' => $this->string(),
            'city' => $this->string(),
            'state' => $this->string(),
            'postal_code' => $this->string(),
        ]);

        // Agregar la clave foránea
        $this->addForeignKey(
            'fk-client_addresses-client_id',
            '{{%client_addresses}}',
            'client_id',
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
        // Eliminar la clave foránea primero
        $this->dropForeignKey('fk-client_addresses-client_id', '{{%client_addresses}}');

        // Luego, eliminar la tabla
        $this->dropTable('{{%client_addresses}}');
    }
}
