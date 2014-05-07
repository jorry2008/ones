<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataModelDataAction
 *
 * @author nemo
 */
class DataModelDataAction extends CommonAction {
    
    protected $indexModel = "DataModelDataView";
    
    protected function _filter(&$map) {
        if($_GET["modelId"]) {
            $map["model_id"] = abs(intval($_GET["modelId"]));
        }
        if($_GET['fieldAlias']) {
            $map["DataModelFields.field_name"] = $_GET['fieldAlias'];
        }
        if($_GET["typeahead"]) {
            $map["data"] = array("LIKE", "%{$_GET["typeahead"]}%");
        }
        //根据分类查询对应的模型
        if($_GET["goods_id"]) {
            if(strpos($_GET["goods_id"], "_") !== false) {
                list($factory_code, $id, $catid) = explode("_", $_GET["goods_id"]);
                $model = D("GoodsCategory");
                $category = $model->find($catid);
                if($category) {
                    $map["model_id"] = $category["bind_model"];
                }
            } else {
                $model = D("GoodsCatView");
                $category = $model->find($_GET["goods_id"]);
                if($category) {
                    $map["model_id"] = $category["bind_model_id"];
                }
            }
        }
    }
    
    protected function pretreatment() {
        $_POST["model_id"] = $_POST["modelId"];
    }
    
}