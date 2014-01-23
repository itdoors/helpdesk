<?php

class cleanForm extends sfForm
{
  public function configure()
  {
    $widgetName = $this->getOption('widgetName') ? $this->getOption('widgetName') : 'departments_id';

    $model = $this->getOption('model') ? $this->getOption('model') : 'departments';

    $this->setWidget($widgetName, new sfWidgetFormDoctrineChoice(array(
      'model' => $model
    )));

    if ($this->getOption('query'))
    {
      $this->getWidget($widgetName)->setOption('query', $this->getOption('query'));
    }

    if ($this->getOption('method'))
    {
      $this->getWidget($widgetName)->setOption('method', $this->getOption('method'));
    }

    $nameFormat = $this->getOption('nameFormat') ? $this->getOption('nameFormat') : 'departments';

    $this->getWidgetSchema()->setNameFormat("{$nameFormat}[%s]");
  }
}