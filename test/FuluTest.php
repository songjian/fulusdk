<?php

require_once(__DIR__ . "/../vendor/autoload.php");

class FuluTest extends \PHPUnit\Framework\TestCase
{
    /**
     * 话费充值
     *
     */
    public function testOrderMobileAdd()
    {
        $customer_order_no = $this->uuid();

        $fulu = new \Fulu\Fulu('', '');
        $fulu->sandbox(true);
        $ret = $fulu->orderMobileAdd('15972368779', 100, $customer_order_no);
        // print_r($ret);
        $this->assertArrayHasKey('code', $ret);
        $this->assertArrayHasKey('message', $ret);
        $this->assertArrayHasKey('result', $ret);
        $this->assertArrayHasKey('sign', $ret);
        $this->assertEquals('0', $ret['code']);
        $result = json_decode($ret['result'], true);
        $this->assertEquals($customer_order_no, $result['customer_order_no']);
        return $customer_order_no;
    }

    /**
     * 测试订单查询
     *
     * @depends testOrderMobileAdd
     */
    public function testOrderInfoGet($customer_order_no)
    {
        $fulu = new \Fulu\Fulu('', '');
        $fulu->sandbox(true);
        $ret = $fulu->orderInfoGet($customer_order_no);
        // print_r($ret);
        $this->assertArrayHasKey('code', $ret);
        $this->assertArrayHasKey('message', $ret);
        $this->assertArrayHasKey('result', $ret);
        $this->assertArrayHasKey('sign', $ret);
        $this->assertEquals('0', $ret['code']);
        $result = json_decode($ret['result'], true);
        $this->assertEquals($customer_order_no, $result['customer_order_no']);
        $this->assertEquals('untreated', $result['order_state']);
    }

    function uuid()
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
        return $uuid;
    }
}
