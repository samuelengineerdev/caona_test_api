<?php

namespace api\controllers;

use Yii;
use common\models\Client;
use yii\rest\ActiveController;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends ActiveController
{
    public $modelClass = 'common\models\Client';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        // Disable unnecessary actions
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }

    /**
     * List all clients.
     * GET /api/clients
     */
    public function actionIndex()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Client::find(),
        ]);

        return $dataProvider;
    }

    /**
     * Retrieve details of a specific client.
     * GET /api/clients/{id}
     * @param int $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * Create a new client.
     * POST /api/clients
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return $model;
        } else {
            return $model->errors;
        }
    }

    /**
     * Update an existing client.
     * PUT /api/clients/{id}
     * @param int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return $model;
        } else {
            return $model->errors;
        }
    }

    /**
     * Delete an existing client.
     * DELETE /api/clients/{id}
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return ['status' => 'success', 'message' => 'Client deleted successfully.'];
    }

    /**
     * Find the Client model by ID.
     * If the model is not found, a 404 exception is thrown.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model is not found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('Client not found.');
        }
    }
}
