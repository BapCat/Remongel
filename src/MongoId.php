<?php namespace BapCat\Remongel;

use BapCat\Interfaces\Values\Value;
use BapCat\Values\Regex;
use BapCat\Values\Text;

use InvalidArgumentException;

class MongoId extends Value {
  private $raw;
  
  private $time;
  private $machine_id;
  private $process_id;
  private $counter;
  
  public function __construct($raw) {
    $regex = new Regex('/^([a-f0-9]{8})([a-f0-9]{6})([a-f0-9]{4})([a-f0-9]{6})$/');
    
    $matches = $regex->capture(new Text($raw));
    
    if(empty($matches)) {
      throw new InvalidArgumentException('Expected MongoDB ID, but got [' . var_export($raw, true) . '] instead');
    }
    
    list($this->time, $this->machine_id, $this->process_id, $this->counter) = $matches[0];
    
    $this->raw = $raw;
  }
  
  public function __toString() {
    return $this->raw;
  }
  
  public function jsonSerialize() {
    return $this->raw;
  }
  
  protected function getRaw() {
    return $this->raw;
  }
  
  protected function getTime() {
    return $this->time;
  }
  
  protected function getMachineId() {
    return $this->machine_id;
  }
  
  protected function getProcessId() {
    return $this->process_id;
  }
  
  protected function getCounter() {
    return $this->counter;
  }
}
