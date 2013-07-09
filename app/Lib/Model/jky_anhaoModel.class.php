<?php

class jky_anhaoModel extends RelationModel
{
    //关联关系
    protected $_link = array(
        'item'=> array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'jky_item',
            'foreign_key' => 'item_id',
        ),   
    );
}