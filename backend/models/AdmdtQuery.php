<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Admdt]].
 *
 * @see Admdt
 */
class AdmdtQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Admdt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Admdt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}