<?php

require_once(__DIR__ . "/../vendor/autoload.php");

class CardTest extends \PHPUnit\Framework\TestCase
{
    /**
     * 测试卡密类商品下单
     *
     * @return void
     */
    public function testOrderCardAdd()
    {
        $fulu = new \Fulu\Fulu();
        $fulu->sandbox(true);
        $customer_order_no = $this->uuid();
        $r = $fulu->orderCardAdd('10000587', 1, $customer_order_no, 20);
        // print_r($r);
        $this->assertArrayHasKey('code', $r);
        $this->assertArrayHasKey('message', $r);
        $this->assertArrayHasKey('result', $r);
        $this->assertArrayHasKey('sign', $r);
        $this->assertEquals(0, $r['code']);
        $result = json_decode($r['result'], true);
        $this->assertEquals($customer_order_no, $result['customer_order_no']);
        return $customer_order_no;
    }

    /**
     * 测试订单查询
     *
     * @depends testOrderCardAdd
     */
    public function testOrderInfoGet($customer_order_no)
    {
        sleep(5);
        $fulu = new \Fulu\Fulu();
        $fulu->sandbox(true);
        $r = $fulu->orderInfoGet($customer_order_no);
        // print_r($r);
        $this->assertArrayHasKey('code', $r);
        $this->assertArrayHasKey('message', $r);
        $this->assertArrayHasKey('result', $r);
        $this->assertArrayHasKey('sign', $r);
        $this->assertEquals(0, $r['code']);
        $result = json_decode($r['result'], true);
        $this->assertEquals($customer_order_no, $result['customer_order_no']);
        $this->assertEquals('success', $result['order_state']);
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
