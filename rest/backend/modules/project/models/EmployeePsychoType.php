<?php

namespace backend\modules\project\models;

use backend\components\BackModel;
use kartik\builder\Form;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "employee_psycho_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property integer $position
 *
 * @property Employee[] $employees
 */
class EmployeePsychoType extends BackModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_psycho_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'position'], 'required'],
            [['value'], 'number'],
            [['position'], 'integer'],
            [['name'], 'string', 'max' => 255],
	        [['id', 'name', 'value', 'position'], 'safe', 'on' => 'search']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва',
            'value' => 'Значення',
            'position' => 'Порядок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['psycho_type_id' => 'id']);
    }

	/**
	 * @inheritdoc
	 */
	public function search($params)
	{
		$query = static::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!empty($params)){
			$this->load($params);
		}

		$query->andFilterWhere(['id' => $this->id]);
		$query->andFilterWhere(['like', 'name', $this->name]);
		$query->andFilterWhere(['like', 'value', $this->value]);
		$query->andFilterWhere(['like', 'position', $this->position]);

		return $dataProvider;
	}

	/**
	 * @param bool $viewAction
	 *
	 * @return array
	 */
	public function getViewColumns($viewAction = false)
	{
		return $viewAction
			? [
				'id',
				'name',
				'value',
				'position'
			]
			: [
				'id',
				'name',
				'value',
				'position',
				[
					'class' => \yii\grid\ActionColumn::className()
				]
			];
	}

	/**
	 * @return array
	 */
	public function getFormRows()
	{
		return
			[
				'name' => [
					'type' => Form::INPUT_TEXT,
				],
				'value' => [
					'type' => Form::INPUT_TEXT,
				],
				'position' => [
					'type' => Form::INPUT_TEXT,
				],
			];

	}

	/**
	 * @return string
	 */
	public function getBreadCrumbRoot()
	{
		return 'Психотипи зловмисників';
	}
}
