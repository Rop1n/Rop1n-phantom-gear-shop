<?php

namespace app\controllers;
use app\models\Characteristic;
use yii\web\Response;

class CharacteristicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Characteristic();
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return [
                'success' => true,
                'id' => $model->id,
                'name' => $model->name,
            ];
        }

        return ['success' => false];
    }
}
