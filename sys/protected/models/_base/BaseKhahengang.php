<?php

/**
 * This is the model base class for the table "khahengang".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Khahengang".
 *
 * Columns in table "khahengang" available as properties of the model,
 * followed by relations of table "khahengang" available as properties of the model.
 *
 * @property integer $id
 * @property integer $price
 * @property integer $customer_id
 *
 * @property Customer $customer
 */
abstract class BaseKhahengang extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'khahengang';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Khahengang|Khahengangs', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('price, customer_id', 'required'),
			array('price, customer_id', 'numerical', 'integerOnly'=>true),
			array('id, price, customer_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'price' => Yii::t('app', 'Price'),
			'customer_id' => null,
			'customer' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('price', $this->price);
		$criteria->compare('customer_id', $this->customer_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}