<?php 

class uiComponents extends sfComponents
{
  public function executeSession_timeout(sfWebRequest $request)
  {
     $time_out = session_get_cookie_params();
      
  }
 

  

}