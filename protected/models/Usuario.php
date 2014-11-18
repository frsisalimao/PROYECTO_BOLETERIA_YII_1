<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $idusuario
 * @property string $email
 * @property string $cedula
 * @property string $nombre
 * @property string $telefono
 * @property string $direccion
 * @property string $password
 * @property string $estado
 *
 * The followings are the available model relations:
 * @property Compra[] $compras
 * @property Reserva[] $reservas
 */
class Usuario extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
      public $passwordCompare;
    public function tableName() {
        return 'usuario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email', 'required'),
            array('idusuario', 'numerical', 'integerOnly' => true),
            array('email, cedula, nombre, telefono, direccion, password, estado', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idusuario, email, cedula, nombre, telefono, direccion, password, estado', 'safe', 'on' => 'search'),
         //    array('password', 'compare', 'compareAttribute'=>'passwordCompare'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'compras' => array(self::HAS_MANY, 'Compra', 'usuario_idusuario'),
            'reservas' => array(self::HAS_MANY, 'Reserva', 'usuario_idusuario'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'idusuario' => 'Idusuario',
            'email' => 'Email',
            'cedula' => 'Cedula',
            'nombre' => 'Nombre',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'password' => 'Password',
            'estado' => 'Estado',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('idusuario', $this->idusuario);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('cedula', $this->cedula, true);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('telefono', $this->telefono, true);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('estado', $this->estado, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Usuario the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeUpdate() {
        if ($this->isNewRecord) {
            $this->password = hash_hmac('sha256', $this->password, Yii::app()->params['encryptionKey']);
        }
        return parent::beforeSave();
    }

    public function beforeSave() {

        $this->password = hash_hmac('sha256', $this->password, Yii::app()->params['encryptionKey']);

        return parent::beforeSave();
    }

}
