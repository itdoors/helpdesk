<?php
  
class SDtexts
{
     
  static function getClient_Claimopened_Create_Subject($claim)
  {
      if (!$claim) return null;
      $subject = 'Заявка №'.$claim->getId().' cоздана';
      return $subject; 
  }
  
  static function getClient_Claimopened_Create_Text($claim)
  {
      if (!$claim) return null;
      $text ='
Спасибо, Ваш запрос принят и один из операторов ответит Вам в ближайшее время. 
Ниже приведена информация относительно вашего запроса.
Номер заявки: '.$claim->getId().'
Отдел: '.$claim->getClaimtype().'
Адрес: '.$claim->getDepartments().'
Важность: '.$claim->getImportance().'
Куратор: '.$claim->getKurator().'
Исполнитель: '.$claim->getStuff().'

Подробную информацию можно получить по адресу: '.sfConfig::get('base_company_name').'
                                                                                              
Не отвечайте на это письмо.';
return $text;
  }
  
  static function getClient_Messages_Create_Subject($claim)
  {
      if (!$claim) return null;
      $subject = 'Заявка №'.$claim->getId().' новое сообщение';
      return $subject; 
  }
  static function getClient_Messages_Create_Text($claim)
  {
      if (!$claim) return null;
        $text = '
Новое сообщение по заявке №'.$claim->getId().'
Подробную информацию можно получить по адресу: '.sfConfig::get('base_company_name').'/messages/show/claimid/'.$claim->getId().'
Не отвечайте на это письмо.
';

return $text;
  }
  
  
  static function getSmeta_Status_Update_Subject($claim)
  {
      if (!$claim) return null;
      $subject = 'Заявка №'.$claim->getId().' изменен статус сметы';
      return $subject; 
  }
  static function getSmeta_Status_Update_Text($claim)
  {
      if (!$claim) return null;
        $text = '
Изменен статус сметы по заявке №'.$claim->getId().'
Подробную информацию можно получить по адресу: '.sfConfig::get('base_company_name').'/smeta.php/messages/show/claimid/'.$claim->getId().'
Не отвечайте на это письмо.
';

return $text;
  }
  
  
  static function getKurator_Messages_Create_Subject($claim)
  {
      if (!$claim) return null;
      $subject = 'Заявка №'.$claim->getId().' новое сообщение';
      return $subject; 
  }
  static function getKurator_Messages_Create_Text($claim)
  {
      if (!$claim) return null;
        $text = '
Новое сообщение по заявке №'.$claim->getId().'
Подробную информацию можно получить по адресу: '.sfConfig::get('base_company_name').'/kurator.php/messages/show/claimid/'.$claim->getId().'
Не отвечайте на это письмо.
';

return $text;
  } 
  
  static function getStuff_Messages_Create_Subject($claim)
  {
      if (!$claim) return null;
      $subject = 'Заявка №'.$claim->getId().' новое сообщение';
      return $subject; 
  }
  static function getStuff_Messages_Create_Text($claim)
  {
      if (!$claim) return null;
        $text = '
Новое сообщение по заявке №'.$claim->getId().'
Подробную информацию можно получить по адресу: '.sfConfig::get('base_company_name').'/stuff.php/messages/show/claimid/'.$claim->getId().'
Не отвечайте на это письмо.
';

return $text;
  }

  static public function getIdeaCreateSubjectUser($user)
  {
    $text = "
Уважаемый(ая) {$user}, спасибо за Вашу идею. ";

    return $text;
  }

  static public function getIdeaCreateTextUser($user)
  {
    $text = "
	Уважаемый(ая) {$user}, спасибо за Вашу идею и за Ваш вклад в развитие компании!<br /><br />
Надеемся, что Ваше пердложение позволит компании Импел Гриффин Групп работать еще более эффективней.<br /><br /> 
Пусть каждая Ваша идея будет гениальной, а награда за нее высокой!<br /><br />
Хорошего дня!
    ";

    return $text;
  }

  static public function getIdeaCreateSubjectAdmin($idea)
  {
    $text = "
Новая идея #{$idea->getId()} на intranet.griffin.ua ";

    return $text;
  }

  static public function getIdeaCreateTextAdmin($idea, $url, $user)
  {
    $text = "
Новая идея #{$idea->getId()}. <a href='{$url}' target='_blank'>{$url}</a><br /><br />

Пользователь: {$user}<br /><br />

Дата: {$idea->getFormattedDate()}<br /><br />

Название идеи: {$idea->getName()}<br /><br />

Текст идеи:<br />
{$idea->getDescription()}";

    return $text;
  }

  static public function getIdeaChangeByExpertSubjectUser($user)
  {
    $text = "
Уважаемый(ая) {$user}, Вашей идее номер {$idea->getId()} были присвоены баллы.<br /><br />
Войдите в Фабрику идей и ознакомьтесь с подробностями.<br /><br />
Спасибо за Вашу активность!";

    return $text;
  }

  static public function getIdeaChangeByExpertTextUser($idea, $user)
  {
    $text = "
Уважаемый {$user}, Вашей идее номер {$idea->getId()} были присвоены следующие баллы: {$idea->getTotal()}<br />
Спасибо за Вашу идею.";

    return $text;
  }
  
}
