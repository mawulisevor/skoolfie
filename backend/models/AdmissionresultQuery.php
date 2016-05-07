<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Admissionresult]].
 *
 * @see Admissionresult
 */
class AdmissionresultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Admissionresult[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Admissionresult|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}