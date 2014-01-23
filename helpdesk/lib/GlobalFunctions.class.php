<?php
class GlobalFunctions
{
  /** @var mixed[] $months Russian months*/
  static public $months = array(
    '1' => 'Январь',
    '2' => 'Февраль',
    '3' => 'Март',
    '4' => 'Апрель',
    '5' => 'Май',
    '6' => 'Июнь',
    '7' => 'Июль',
    '8' => 'Август',
    '9' => 'Cентябрь',
    '10' => 'Октябрь',
    '11' => 'Ноябрь',
    '12' => 'Декабрь',
  );

  const SESSION_NAMESACE__GRAFIK_ENTITY = 'grafik.entity_';

  /**
   * Is script run in Web Browser
   *
   * @return bool
   */
  static public function isBrowser()
  {
    return PHP_SAPI != 'cli';
  }

  static public function getUserId()
    {
      return sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
    }

  static public function getUser()
  {
    $userId = self::getUserId();

    $user = Doctrine::getTable('sfGuardUser')->find($userId);

    return $user;
  }

  static public function getUserFullName()
  {
    if (!self::isBrowser())
    {
      return '';
    }

    /** @var sfGuardUser $user */
    $user = self::getUser();

    return $user ? $user->getFullName() : '';
  }

  static public function getStuffId()
  {
    $userId = self::getUserId();

    $stuff = Doctrine::getTable('stuff')->findOneBy('user_id', $userId);

    return $stuff ? $stuff->getId() : null;
  }
    
  static public function getSearchResultsAutocomplite($s, $model, $field = 'name', $key = 'id')
  {
    $pattern = $s;
    
    $q = Doctrine::getTable($model)
      ->createQuery('i')
      ->where('LOWER(i.'.$field.') LIKE ?', '%'.$pattern."%");
      
    $q = $q->fetchArray();
      
    $result = array();
    foreach ($q as $item)
    {
      $result[$item[$key]] = $item[$field];
    }
    
    return $result ? $result : null;
  }
  
  
  
  static public function getFormattedArray($arr, $field)
  {
    $arr_new = array();
    
    foreach($arr as $key => $value)
    {
      $arr_new[] = $value[$field] ;
    }
    
    return $arr_new;
  }
  
  static public function getFormattedArrayDistinct($arr, $field)
  {
    $arr_new = array();
    
    foreach($arr as $key => $value)
    {
      if ($value[$field])
      {
        $arr_new[$value[$field]] = $value[$field] ;
      }
    }
    
    return $arr_new;
  }
  
  static public function getFormattedArrayObject($arr, $field)
  {
    $arr_new = array();
    
    $toString = 'get'.sfInflector::camelize($field);
    
    foreach($arr as $value)
    {
      $arr_new[$value->$toString()][] = $value ;
    }
    
    return $arr_new;
  }
  
  static function strtolower_utf8($string)
  { 
    $convert_to = array( 
      "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", 
      "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï", 
      "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж", 
      "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы", 
      "ь", "э", "ю", "я" 
    ); 
    $convert_from = array( 
      "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", 
      "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", 
      "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж", 
      "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ", 
      "Ь", "Э", "Ю", "Я" 
    ); 

    return str_replace($convert_from, $convert_to, $string); 
  }

  static public function getCreatedatetime()
  {
    return date('Y-m-d H:i:s');
  }

  /**
   * Is user has credential
   *
   * @param string $credential
   * @param bool $isAdmin if user is admin he always has all credential. some times in not needed
   * @return boolean
   */
  static public function hasCredential($credential, $isAdmin = true)
  {
    $user = sfContext::getInstance()->getUser();

    return $user->hasCredential($credential) && ($isAdmin ? 1 : !$user->hasCredential('admin'));
  }

  static public function isSuperKurator()
  {
    return self::hasCredential('superkurator', false);
  }

  /**
   * Sets variable to session
   *
   * @param string $key
   * @param mixed $value
   * @param string $namespace (default global.namespace)
   */
  public static function setSessionVariable($key, $value, $namespace = 'global.namespace')
  {
    $user = sfContext::getInstance()->getUser();

    $user->setAttribute($key, $value, $namespace);
  }

  /**
   * Sets variable to session
   *
   * @param string $key
   * @param string $namespace (default global.namespace)
   * @return mixed
   */
  public static function getSessionVariable($key, $namespace = 'global.namespace')
  {
    $user = sfContext::getInstance()->getUser();

    return $user->getAttribute($key, null, $namespace);
  }

  /**
   * Returns count of days in the month
   *
   * @param int $year
   * @param int $month
   *
   * @return int
   */
  public static function getDaysInTheMonth($year, $month)
  {
    return date('t', mktime(0, 0, 0, $month, 1, $year));
  }
}
?>
