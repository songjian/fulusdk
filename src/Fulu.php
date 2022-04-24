<?php

namespace Fulu;

ini_set('date.timezone', 'Asia/Shanghai');

class Fulu
{
   var $url = 'https://openapi.fulu.com/api/getway';
   var $AppKey = '';
   var $AppSecret = '';

   public function __construct($app_key, $app_secret)
   {
      $this->AppKey = $app_key;
      $this->AppSecret = $app_secret;
   }

   /**
    * 使用沙箱环境
    *
    * @param boolean $enable
    * @return void
    */
   public function sandbox($enable = false)
   {
      if ($enable) {
         $this->url = 'https://pre-openapi.fulu.com/api/getway';
         $this->AppKey = 'i4esv1l+76l/7NQCL3QudG90Fq+YgVfFGJAWgT+7qO1Bm9o/adG/1iwO2qXsAXNB';
         $this->AppSecret = '0a091b3aa4324435aab703142518a8f7';
      }
   }

   /**
    * php签名方法
    */
   public function getSign($Parameters)
   {
      //签名步骤一：把字典json序列化
      $json = json_encode($Parameters, 320);
      //签名步骤二：转化为数组
      $jsonArr = $this->mb_str_split($json);
      //签名步骤三：排序
      sort($jsonArr);
      //签名步骤四：转化为字符串
      $string = implode('', $jsonArr);
      //签名步骤五：在string后加入secret
      $string = $string . $this->AppSecret;
      //签名步骤六：MD5加密
      $result_ = strtolower(md5($string));
      return $result_;
   }
   /**
    * 可将字符串中中文拆分成字符数组
    */
   function mb_str_split($str)
   {
      return preg_split('/(?<!^)(?!$)/u', $str);
   }

   /**
    * 调用福禄api
    *
    * @param [type] $method
    * @param [type] $biz_content
    * @return void
    */
   function api($method, $biz_content)
   {

      $header = array("Content-type:application/json;");
      $post_data = array(
         'app_key' => $this->AppKey,
         'method' => $method,
         'timestamp' => date('Y-m-d H:i:s'),
         'version' => '2.0',
         'format' => 'json',
         'charset' => 'utf-8',
         'sign_type' => 'md5',
         'app_auth_token' => '',
         'biz_content' => json_encode($biz_content),
      );
      $post_data['sign'] = $this->getSign($post_data);
      // var_dump($post_data);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
      $output = curl_exec($ch);
      curl_close($ch);
      $output = json_decode($output, true);
      return $output;
   }

   /**
    * 话费下单接口
    *
    * @param [string] $chargePhone
    * @param [double] $chargeValue
    * @param [string] $customerOrderNo
    * @param [double] $customerPrice
    * @param [string] $shopType
    * @param [string] $externalBizId
    * @return void
    */
   public function orderMobileAdd(
      $charge_phone,
      $charge_value,
      $customer_orderNo,
      $customer_price = NULL,
      $shop_type = NULL,
      $external_bizId = NULL
   ) {
      $biz_content = array(
         'charge_phone' => $charge_phone,
         'charge_value' => $charge_value,
         'customer_order_no' => $customer_orderNo,
         'customer_price' => $customer_price,
         'shop_type' => $shop_type,
         'external_biz_id' => $external_bizId
      );
      return $this->api('fulu.order.mobile.add', $biz_content);
   }

   /**
    * 直充下单接口
    *
    * @param [int] $product_id
    * @param [string] $customer_order_no
    * @param [string] $charge_account
    * @param [int] $buy_num
    * @param [string] $charge_game_name
    * @param [string] $charge_game_region
    * @param [string] $charge_game_srv
    * @param [string] $charge_type
    * @param [string] $charge_password
    * @param [string] $charge_ip
    * @param [string] $contact_qq
    * @param [string] $contact_tel
    * @param [int] $remaining_number
    * @param [string] $charge_game_role
    * @param [double] $customer_price
    * @param [string] $shop_type
    * @param [string] $external_biz_id
    * @return void
    */
   public function orderDirectAdd(
      $product_id,
      $customer_order_no,
      $charge_account,
      $buy_num,
      $charge_game_name = NULL,
      $charge_game_region = NULL,
      $charge_game_srv = NULL,
      $charge_type = NULL,
      $charge_password = NULL,
      $charge_ip = NULL,
      $contact_qq = NULL,
      $contact_tel = NULL,
      $remaining_number = NULL,
      $charge_game_role = NULL,
      $customer_price = NULL,
      $shop_type = NULL,
      $external_biz_id = NULL
   ) {
      $biz_content = array(
         'product_id' => $product_id,
         'customer_order_no' => $customer_order_no,
         'charge_account' => $charge_account,
         'buy_num' => $buy_num,
         'charge_game_name' => $charge_game_name,
         'charge_game_region' => $charge_game_region,
         'charge_game_srv' => $charge_game_srv,
         'charge_type' => $charge_type,
         'charge_password' => $charge_password,
         'charge_ip' => $charge_ip,
         'contact_qq' => $contact_qq,
         'contact_tel' => $contact_tel,
         'remaining_number' => $remaining_number,
         'charge_game_role' => $charge_game_role,
         'customer_price' => $customer_price,
         'shop_type' => $shop_type,
         'external_biz_id' => $external_biz_id,
      );
      return $this->api('fulu.order.direct.add', $biz_content);
   }

   /**
    * 订单查询
    *
    * @param [string] $customer_order_no
    * @return void
    */
   public function orderInfoGet($customer_order_no)
   {
      $biz_content = array(
         'customer_order_no' => $customer_order_no
      );
      return $this->api('fulu.order.info.get', $biz_content);
   }
}
