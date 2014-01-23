<?php
include(sfConfig::get('sf_lib_dir').'/model/simple_html_dom.class.php');
/**
 * findtender actions.
 *
 * @package    tenderfinder
 * @subpackage findtender
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class findtenderActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $tenderkeywords = Tenderkeywords::getAllTenderkeywords();
    $result = '';
    $url = $request->getParameter('link');
    $html = file_get_html($url);
    $text = $html->plaintext;
    //$text = $html->text;
    $html->clear();               
    /*$snoopy = new Snoopy();
    $snoopy->fetchtext($url); // загружаем страницу
    $text = $snoopy->results;*/
    $s_link="<a href=\"$url\" target=\"_blank\">$url</a><br />";
    foreach ($tenderkeywords as $word)
    {
        $keyword = $word->getName();
        if (stripos($text, $keyword) !== false)
        {
            $lenth = strlen($keyword);
            $start = stripos($text, $keyword);
            $i = $start+$lenth;
            $j = 0;
            //следующее услови переписать с помощью РЕГУЛЯРНЫХ ВЫРАЖЕНИЙ!!!!!!!
            while($text[$i]!=' '&&$text[$i]!='-'&&$text[$i]!='.'&&$text[$i]!=','&&$text[$i]!=';'&&$text[$i]!=':')
            {
                $i++;
                $j++;
            }
            $last = substr($text, $start+$lenth, $j);
            $result .= "<span class=\"small_text\">Есть по ключевому слову</span> : <span class=\"yellow\"><b><i>$keyword</i></b></span>$last<br />";
        }
          
    } 
    $result = $result ? $s_link.$result : '';
    
    /*$snoopy = new Snoopy();
    foreach ($tenderlinks as $tenderlink)
    {

      $snoopy->fetch($tenderlink->getName()); // загружаем страницу

      $out = $snoopy->results; 
        
    } */   
    return $this->renderPartial('index', array('counter'=>$counter, 'result'=>$result));       

  }
  
  public function executeIndex(sfWebRequest $request)
  {
     $this->tenderlinks = Tenderlinks::getAllTenderlinks();
     
  }
  
  
/*   public function executeShow(sfWebRequest $request)
  {
    $tenderkeywords = Tenderkeywords::getAllTenderkeywords();
    $result = '';
    $counter = 0;
    
    foreach ($tenderlinks as $tenderlink)
    {
        $counter++;
        $url = $tenderlink->getName();
        $html = file_get_html($url);
        $text = $html->plaintext;
        $html->clear();
        foreach ($tenderkeywords as $word)
        {
            if (stripos($text, $word->getName()) !== false)
            $result .= "Есть вхождение по ссылке <a href=\"$url\">$url</a> по ключевому слову <b><i>$word</i></b><br />";
        } 
    }

    /*$snoopy = new Snoopy();
    foreach ($tenderlinks as $tenderlink)
    {

      $snoopy->fetch($tenderlink->getName()); // загружаем страницу

      $out = $snoopy->results; 
        
    }    
    return $this->renderPartial('index', array('counter'=>$counter, 'result'=>$result));       

  }  */
  
}
