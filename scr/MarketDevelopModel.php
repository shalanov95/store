<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/scr/BaseModel.php';
use scr\BaseModel;
class MarketDevelopModel extends BaseModel
{
    private $productId = 3;
    private $date = '2021-01-01';
    private $completedOrders = 0;
    private $margin = 0.3;
    private $arrSupply = null;

    public function getArrSupply(){
        return $this->arrSupply;
    }

    public function setParams($productId, $date = '2021-01-01', $completedOrders = 0, $margin = 0.3){
        $this->setProductId($productId);
        $this->setDate($date);
        $this->setCompletedOrders($completedOrders);
        $this->setMargin($margin);
        return $this;
    } 

    public function setProductId($productId){
        $this->productId = $productId;
        return $this;
    }

    public function setDate($date){
        $this->date = $date;
        return $this;
    }

    public function setCompletedOrders($completedOrders){
        $this->completedOrders = $completedOrders;
        return $this;
    }
    public function setMargin($margin){
        $this->margin = $margin;
        return $this;
    }

    public function supplyIsSet()
    {
        // $date = date('Y-m-d', strtotime($this->date));
        $date = $this->date;
        $this->arrSupply = $this->findMany("Select * from supplies 
            where Product_id = $this->productId and supply_date <= '$date' order by supply_date");
        return $this;    
    }
    public function PricingProduct()
    {
        if($this->arrSupply){
            $order = $this->completedOrders;
            $cent = 0;
            foreach($this->arrSupply as $arr){
                if ($arr["Amount"] > $order){
                $cent = $arr["Cost"] / $arr["Amount"] ;
                break;
                } else {
                    $order = $order - $arr["Amount"];
                    $cent = $arr["Cost"] / $arr["Amount"] ;
                }
            }
            $cent += $cent * $this->margin;
            return ($cent)? $cent : "товар распродан";

        } else {
            return "товар еще не посутпил в продажу";
        }
    }
    public function ProductOnDepot()
    {
        if($this->arrSupply)
        {
            $sum = 0;
            foreach($this->arrSupply as $arr)
            {

                $sum= $sum + $arr['Amount'];
            }
            $res = $sum - $this->completedOrders;
            return ($res > 0)? $res : "товар распродан"; 
        }    
    }
}