<?php
  class dogovorComponents extends sfComponents 
  {
    public function executeDopdogovors()
    {
      if (!$this->dogovor_id) return sfView::NONE;
      $this->dopdogovors = Doctrine::getTable('DopDogovor')
        ->createQuery('d')
        ->where('d.dogovor_id =?', $this->dogovor_id)
        ->orderBy('d.id DESC')
        ->execute();
    }
  } 

