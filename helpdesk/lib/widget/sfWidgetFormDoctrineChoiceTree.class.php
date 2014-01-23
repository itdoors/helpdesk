<?php
  
  class sfWidgetFormDoctrineChoiceTree extends sfWidgetFormChoice
{
  /**
   * @see sfWidget
   */
  public function __construct($options = array(), $attributes = array())
  {
    $options['choices'] = array();

    parent::__construct($options, $attributes);
  }

protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('model');
    $this->addOption('add_empty', false);
    $this->addOption('method', '__toString');
    $this->addOption('key_method', 'getPrimaryKey');
    $this->addOption('order_by', null);
    $this->addOption('query', null);
    $this->addOption('multiple', false);
    $this->addOption('table_method', null);

    parent::configure($options, $attributes);
  }

public function getChoices()
  {
    $choices = array();
    if (false !== $this->getOption('add_empty'))
    {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->translate($this->getOption('add_empty'));
    }

    if (null === $this->getOption('table_method'))
    {
      $query = null === $this->getOption('query') ? Doctrine_Core::getTable($this->getOption('model'))->createQuery() : $this->getOption('query');
      if ($order = $this->getOption('order_by'))
      {
        $query->addOrderBy($order[0] . ' ' . $order[1]);
      }
      $objects = $query->execute();
    }
    else
    {
      $tableMethod = $this->getOption('table_method');
      $results = Doctrine_Core::getTable($this->getOption('model'))->$tableMethod();  
      if ($results instanceof Doctrine_Query)
      {
        $objects = $results->execute();
      }
      else if (is_array($results))
      {
        $objects = $results;
      }
      else if ($results instanceof Doctrine_Record)
      {
        $objects = new Doctrine_Collection($this->getOption('model'));
        $objects[] = $results;
      }
      else
      {
        $objects = array();
      }
    }

    $method = $this->getOption('method');
    $keyMethod = $this->getOption('key_method');

    foreach ($objects as $object)
    {
      $choices[$object->$keyMethod()] = $object->$method();
    }

    return $choices;
  }

}