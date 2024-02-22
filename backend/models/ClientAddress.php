<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client_addresses".
 *
 * @property int $id
 * @property int|null $client_id
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $postal_code
 *
 * @property Clients $client
 */
class ClientAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id'], 'integer'],
            [['street', 'city', 'state', 'postal_code'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'street' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'postal_code' => 'Postal Code',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }
}
