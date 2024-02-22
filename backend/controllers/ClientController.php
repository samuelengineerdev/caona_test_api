<?php

namespace backend\controllers;

use backend\models\Client;
use backend\models\ClientAddress;
use backend\models\ClientProfile;
use Yii;



class ClientController extends \yii\web\Controller
{


    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }


    public function actionIndex()
    {
        $clients = Client::find()->with(['profile', 'address'])->orderBy(['id' => SORT_DESC])->all();

        $clientData = [];

        foreach ($clients as $client) {
            $clientInfo = [
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'client_email' => $client->email,
                'phone' => $client->phone,

            ];

            if ($client->profile !== null) {
                $clientInfo['profile'] = [
                    'civil_status' => $client->profile->civil_status,
                    'occupation' => $client->profile->occupation,
                    'membership_level' => $client->profile->membership_level,
                ];
            }

            if ($client->address !== null) {
                $clientInfo['address'] = [
                    'street' => $client->address->street,
                    'city' => $client->address->city,
                    'state' => $client->address->state,
                    'postal_code' => $client->address->postal_code,
                ];
            }

            $clientData[] = $clientInfo;
        }

        return $this->asJson(['status' => 1, 'clients' => $clientData]);
    }



    public function actionCreate()
    {
        $client = new Client();
        $data = Yii::$app->request->bodyParams;

        if (!isset($data['first_name']) || !isset($data['phone'])) {
            return $this->asJson(['status' => 0, 'message' => 'First Name and Phone are required']);
        }

        $client->first_name = $data['first_name'];
        $client->last_name = $data['last_name'] ?? '';
        $client->email = $data['email'] ?? '';
        $client->phone = $data['phone'];

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($client->save()) {
                if (isset($data['profile'])) {
                    $profileData = $data['profile'];
                    $profile = new ClientProfile();
                    $profile->client_id = $client->id;
                    $profile->civil_status = $profileData['civil_status'] ?? '';
                    $profile->occupation = $profileData['occupation'] ?? '';
                    $profile->membership_level = $profileData['membership_level'] ?? '';
                    $profile->save();
                }

                if (isset($data['address'])) {
                    $addressData = $data['address'];
                    $address = new ClientAddress();
                    $address->client_id = $client->id;
                    $address->street = $addressData['street'] ?? '';
                    $address->city = $addressData['city'] ?? '';
                    $address->state = $addressData['state'] ?? '';
                    $address->postal_code = $addressData['postal_code'] ?? '';
                    $address->save();
                }

                $transaction->commit();

                return $this->asJson(['status' => 'success', 'data' => $client]);
            } else {
                return $this->asJson(['status' => 'error', 'errors' => $client->errors]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }




    public function actionView()
    {
        $id = Yii::$app->request->bodyParams['id'];
        $client = $this->findModel($id);

        $responseData = [
            'id' => $client->id,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'email' => $client->email,
            'phone' => $client->phone,
        ];

        if ($client->profile !== null) {
            $responseData['profile'] = [
                'civil_status' => $client->profile->civil_status,
                'occupation' => $client->profile->occupation,
                'membership_level' => $client->profile->membership_level,
            ];
        }

        if ($client->address !== null) {
            $responseData['address'] = [
                'street' => $client->address->street,
                'city' => $client->address->city,
                'state' => $client->address->state,
                'postal_code' => $client->address->postal_code,
            ];
        }

        return $this->asJson(['status' => 1, 'client' => $responseData]);
    }



    protected function findModel($id)
    {
        if (($model = Client::find()->with('profile')->where(['id' => $id])->one()) !== null) {
            return $model;
        }

        return $this->asJson(['status' => 0, 'message' => "The requested page does not exist."]);
    }


    public function actionUpdate()
    {
        $data = Yii::$app->request->bodyParams;
        $model = $this->findModel($data['id']);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->first_name = $data['first_name'];
            $model->last_name = $data['last_name'];
            $model->email = $data['email'];
            $model->phone = $data['phone'];

            if (!$model->save()) {
                return $this->asJson(['status' => 0, 'message' => "Error updating customer data."]);
            }

            if (isset($data['profile'])) {
                $profileData = $data['profile'];
                if ($model->profile === null) {
                    $profile = new ClientProfile();
                    $profile->client_id = $model->id;
                } else {
                    $profile = $model->profile;
                }

                $profile->civil_status = $profileData['civil_status'];
                $profile->occupation = $profileData['occupation'];
                $profile->membership_level = $profileData['membership_level'];

                if (!$profile->save()) {
                    return $this->asJson(['status' => 0, 'message' => "Error updating customer profile."]);
                }
            }

            if (isset($data['address'])) {
                $addressData = $data['address'];
                if ($model->address === null) {
                    $address = new ClientAddress();
                    $address->client_id = $model->id;
                } else {
                    $address = $model->address;
                }

                $address->street = $addressData['street'];
                $address->city = $addressData['city'];
                $address->state = $addressData['state'];
                $address->postal_code = $addressData['postal_code'];

                if (!$address->save()) {
                    return $this->asJson(['status' => 0, 'message' => "Error updating customer address."]);
                }
            }

            $transaction->commit();

            return $this->asJson(['status' => 1, 'data' => $model]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->asJson(['status' => 0, 'message' => $e->getMessage()]);
        }
    }
    public function actionDelete()
    {
        $id = Yii::$app->request->bodyParams['id'];
        $model = $this->findModel($id);
        $model->delete();

        return $this->asJson(['status' => 1, 'message' => 'Client deleted successfully']);
    }
}
