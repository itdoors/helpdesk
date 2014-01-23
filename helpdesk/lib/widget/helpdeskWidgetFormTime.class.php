<?php


class helpdeskWidgetFormTime extends sfWidgetFormTime
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * format:                 The time format string (%hour%:%minute%:%second%)
   *  * format_without_seconds: The time format string without seconds (%hour%:%minute%)
   *  * with_seconds:           Whether to include a select for seconds (false by default)
   *  * hours:                  An array of hours for the hour select tag (optional)
   *  * minutes:                An array of minutes for the minute select tag (optional)
   *  * seconds:                An array of seconds for the second select tag (optional)
   *  * can_be_empty:           Whether the widget accept an empty value (true by default)
   *  * empty_values:           An array of values to use for the empty value (empty string for hours, minutes, and seconds by default)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('default_time', array());
    $this->addOption('range_type', '');
    parent::configure();
    
  }  

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The time displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    // convert value to an array
    $default_time = $this->getOption('default_time') ? $this->getOption('default_time') : array();
    $hour = isset($default_time['hour']) ? $default_time['hour'] : 0;
    $minute = isset($default_time['minute']) ? $default_time['minute'] : 0;
    $second = isset($default_time['second']) ? $default_time['second'] : 0;
    
    if ($this->getOption('range_type') == 'to')
    {
      if ($hour == 0 && $minute == 0 & $second == 0)
      {
        $hour = 24;
      }
    }
    
    $this->setOption('hours', parent::generateTwoCharsRange(0, 24));
    
    $default = array('hour' => $hour, 'minute' => $minute, 'second' => $second);
    if (is_array($value))
    {
      $value = array_merge($default, $value);
    }
    else
    {
      $value = ctype_digit($value) ? (integer) $value : strtotime($value);
      if (false === $value)
      {
        $value = $default;
      }
      else
      {
        // int cast required to get rid of leading zeros
        $value = array('hour' => (int) date('H', $value), 'minute' => (int) date('i', $value), 'second' => (int) date('s', $value));
      }
    }

    $time = array();
    $emptyValues = $this->getOption('empty_values');

    // hours
    $widget = new sfWidgetFormSelect(array('choices' => $this->getOption('can_be_empty') ? array('' => $emptyValues['hour']) + $this->getOption('hours') : $this->getOption('hours'), 'id_format' => $this->getOption('id_format')), array_merge($this->attributes, $attributes));
    $time['%hour%'] = $widget->render($name.'[hour]', $value['hour']);

    // minutes
    $widget = new sfWidgetFormSelect(array('choices' => $this->getOption('can_be_empty') ? array('' => $emptyValues['minute']) + $this->getOption('minutes') : $this->getOption('minutes'), 'id_format' => $this->getOption('id_format')), array_merge($this->attributes, $attributes));
    $time['%minute%'] = $widget->render($name.'[minute]', $value['minute']);

    if ($this->getOption('with_seconds'))
    {
      // seconds
      $widget = new sfWidgetFormSelect(array('choices' => $this->getOption('can_be_empty') ? array('' => $emptyValues['second']) + $this->getOption('seconds') : $this->getOption('seconds'), 'id_format' => $this->getOption('id_format')), array_merge($this->attributes, $attributes));
      $time['%second%'] = $widget->render($name.'[second]', $value['second']);
    }

    return strtr($this->getOption('with_seconds') ? $this->getOption('format') : $this->getOption('format_without_seconds'), $time);
  }
}

