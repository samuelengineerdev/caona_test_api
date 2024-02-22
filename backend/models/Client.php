<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 *
 * @property ClientProfiles[] $clientProfiles
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'phone'], 'required'],
            [['first_name', 'last_name', 'email', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[ClientProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(ClientProfile::class, ['client_id' => 'id']);
    }

    public function getAddress()
    {
        return $this->hasOne(ClientAddress::class, ['client_id' => 'id']);
    }

    public function extraFields()
    {
        return ['profile'];
    }


}
