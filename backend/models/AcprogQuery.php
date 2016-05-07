<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Acprog]].
 *
 * @see Acprog
 */
class AcprogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Acprog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Acprog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}