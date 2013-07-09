<?php
class jky_cate_reModel extends RelationModel
{
    protected $_link = array(
        'item' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'jky_item',
            'foreign_key' => 'item_id',
        ),
        'cate' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'jky_cate',
            'foreign_key' => 'cate_id',
        ),
    );    
}