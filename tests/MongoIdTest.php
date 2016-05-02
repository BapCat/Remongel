<?php

use BapCat\Remongel\MongoId;

class MongoIdTest extends PHPUnit_Framework_TestCase {
  /**
   * @dataProvider       goodIds
   */
  public function testValidIds($id) {
    $val = new MongoId($id);
    
    $this->assertSame($id, $val->raw);
    $this->assertSame($id, (string)$val);
    $this->assertSame($id, $val->__toString());
    $this->assertSame(json_encode($id), json_encode($val));
    $this->assertSame(substr($id,  0, 8), $val->time->raw);
    $this->assertSame(substr($id,  8, 6), $val->machine_id->raw);
    $this->assertSame(substr($id, 14, 4), $val->process_id->raw);
    $this->assertSame(substr($id, 18, 6), $val->counter->raw);
  }
  
  /**
   * @dataProvider       badIds
   * @expectedException  InvalidArgumentException
   */
  public function testInvalidIds($id) {
    new MongoId($id);
  }
  
  public function goodIds() {
    return [
      ['56eda7f0975a53bdabe7eeea']
    ];
  }
  
  public function badIds() {
    return [
      [''],
      [null],
      ['aaaaaaaaaaaaaa'],
      ['false'],
      [false],
      ['true'],
      [true],
      [new stdClass()],
      [[]],
      [[1]],
      [1],
      [0],
      ['aaaaaaaaaaaaaaaaaaaaaaag']
    ];
  }
}
