<?php
  
class DoctrineFunctions extends Doctrine_Collection
{
    public function getSum($field)
    {
       $sum = 0;
       foreach ($this as $record)
       {
           $sum = $sum + $record->get($field);
       }
       return $sum;
    }
}
