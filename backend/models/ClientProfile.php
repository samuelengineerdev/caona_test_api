<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client_profiles".
 *
 * @property int $id
 * @property int $client_id
 * @property string|null $civil_status
 * @property string|null $occupation
 * @property string|null $membership_level
 *
 * @property Client $client
 */
class ClientProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id'], 'integer'],
            [['civil_status', 'occupation', 'membership_level'], 'string', 'max' => 255],
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
            'civil_status' => 'Civil Status',
            'occupation' => 'Occupation',
            'membership_level' => 'Membership Level',
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
