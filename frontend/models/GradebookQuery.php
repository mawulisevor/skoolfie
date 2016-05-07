<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Gradebook]].
 *
 * @see Gradebook
 */
class GradebookQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Gradebook[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Gradebook|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}