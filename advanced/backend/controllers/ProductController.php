<?php

namespace backend\controllers;

use backend\models\Product;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Product controller
 */
class ProductController extends Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function actionIndex($id)
    {
        $cacheKey = 'products_' . $id;
        $products = Yii::$app->cache->get($cacheKey);
        if (empty($products)) {
            $products = Product::find()
                ->where(['status' => Product::STATUS_ACTIVE, 'category_id' => $id])
                ->all();
            Yii::$app->cache->set($cacheKey, $products, 3600);
        }

        return $products;
    }
}
