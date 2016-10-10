<?php

namespace common\models\travel;

use common\components\JsonBehavior;
use common\components\UuidBehavior;
use common\models\Tt;
use common\models\User;
use Yii;

/**
 * This is the model class for table "travel".
 *
 * @property string $uid
 * @property string $ttUid
 * @property string $userUid
 * @property string $travelDate
 * @property string $params
 * @property integer $status
 * @property string $templateUid
 * @property string $createdAt
 *
 * @property Template $template
 * @property Tt $tt
 * @property Implementation $implementation
 * @property Media[] $media
 */
class Travel extends \yii\db\ActiveRecord
{
    /**
     * Выезд удален
     */
    const STATUS_DELETED = 0;

    /**
     * Выезд активен
     */
    const STATUS_ACTIVE = 10;

    /**
     * Выезд активен и создан шаблоном
     */
    const STATUS_ACTIVE_TEMPLATE = 11;

    /**
     * Выезд в статусе обработки
     */
    const STATUS_PROCESS = 20;

    /**
     * Выезд завершен успешно
     */
    const STATUS_COMPLETE = 30;

    /**
     * Выезд завершен успешно, но не по адресу
     */
    const STATUS_COMPLETE_OUT_RANGE = 31;

    /**
     * Выезд завершен успешно и является свободным (не назначенным в графике выездов)
     */
    const STATUS_COMPLETE_FREE = 32;

    /**
     * Выезд не выполнен
     */
    const STATUS_UNFINISHED = 40;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'ttUid', 'userUid', 'travelDate'], 'required'],
            [['travelDate', 'createdAt'], 'safe'],
            [['params'], 'string'],
            [['status'], 'integer'],
            [['uid', 'ttUid', 'userUid', 'templateUid'], 'string', 'max' => 36],
            [['uid'], 'unique'],
            [['templateUid'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['templateUid' => 'uid']],
            [['ttUid'], 'exist', 'skipOnError' => true, 'targetClass' => Tt::className(), 'targetAttribute' => ['ttUid' => 'uid']],
        ];
    }

    public function init()
    {
        parent::init();
        $this->attachBehavior('uid', UuidBehavior::className());
//        $this->attachBehavior('params', JsonBehavior::className());
    }

    public function fields()
    {
        return [
            'uid',
            'ttUid',
            'userUid',
            'travelDate',
            'status',
            'statusText',
            'templateUid',
            'createdAt',

            'tt',
        ];
    }

    public function extraFields()
    {
        return [
            'params',
            'template',
            'media',
            'implementation',

            'user',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'ttUid' => 'Tt Uid',
            'userUid' => 'User Uid',
            'travelDate' => 'Дата визита',
            'params' => 'Params',
            'status' => 'Статус',
            'statusText' => 'Статус',
            'templateUid' => 'Template Uid',
            'createdAt' => 'Время занесения в систему',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['uid' => 'templateUid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTt()
    {
        return $this->hasOne(Tt::className(), ['uid' => 'ttUid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImplementation()
    {
        return $this->hasOne(Implementation::className(), ['uid' => 'uid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'userUid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['travelUid' => 'uid']);
    }

    public function getStatusText()
    {
        $message = '';

        switch ($this->status) {
            case self::STATUS_DELETED:
                $message = 'Выезд удален';
                break;

            case self::STATUS_ACTIVE:
            case self::STATUS_ACTIVE_TEMPLATE:
                $message = 'Выезд активен';
                break;

            case self::STATUS_PROCESS:
                $message = 'Выезд в статусе обработки';
                break;

            case self::STATUS_COMPLETE:
                $message = 'Выезд завершен успешно';
                break;

            case self::STATUS_COMPLETE_OUT_RANGE:
                $message = 'Выезд завершен успешно, но не по адресу';
                break;

            case self::STATUS_COMPLETE_FREE:
                $message = 'Выезд завершен успешно и является свободным (не назначенным в графике выездов)';
                break;
            case self::STATUS_UNFINISHED:
                $message = 'Выезд не выполнен';
        }
        return $message;
    }
}
