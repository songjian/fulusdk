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

        $fulu = new \Fulu\Fulu();
        $fulu->sandbox(true);
        $r = $fulu->orderMobileAdd('15972368779', 100, $customer_order_no);
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
     * @depends testOrderMobileAdd
     */
    public function testOrderInfoGet($customer_order_no)
    {
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
        $this->assertEquals('untreated', $result['order_state']);
    }

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
    }

    /**
     * 获取商品模板接口
     *
     * @return void
     */
    public function testGoodsTemplateGet()
    {
        $fulu = new \Fulu\Fulu();
        $fulu->sandbox(true);
        $r = $fulu->goodsTemplateGet('70bb5598-1aef-422e-86ef-a68ae6de79e8');
        // print_r($r);
        $this->assertArrayHasKey('code', $r);
        $this->assertArrayHasKey('message', $r);
        $this->assertArrayHasKey('result', $r);
        $this->assertArrayHasKey('sign', $r);
        $this->assertEquals(3007, $r['code']);
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
