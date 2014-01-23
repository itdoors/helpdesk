<?php

/**
 * attach actions.
 *
 * @package    helpdesk
 * @subpackage attach
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class attachActions extends sfActions
{

  
  public function executeAddAttachForm(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    //if ($commet = SfPollPeer::retrieveByPk($request->getParameter('id')))
    if ($comment = Doctrine::getTable('Comments')->find($request->getParameter('id')))
    {
        $form = new commentsAttachForm($comment);
    }
    else
    {
        $form = new commentsAttachForm();
    }
    $number = $request->getParameter('num')+1;
    $key = 'attach'.$number;
    $form->addAttachForm($key);
    return $this->renderPartial('attach/addAttachForm',array('field' => $form['attach'][$key], 'num' => $number));
  }
}
