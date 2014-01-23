<?php

/**
 * handling_more_info_table actions.
 *
 * @package    helpdesk
 * @subpackage handling_more_info_table
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class handling_more_info_tableActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function preExecute()
  {
    $isCrmAdmin = $this->getUser()->hasCredential('crmadmin');

    $this->redirectUnless($isCrmAdmin, 'handling');

    $this->form = new HandlingMoreInfoTableDateRangeForm();

    $this->baseRoute = 'handling_more_info_table';
    $this->doneRoute = 'handling_more_info_table_done';

    $this->dateRangeNamespace = 'more_info.date_range';
    $this->filtersNamespace = 'more_info.filters';

    $this->filterFormName = 'CrmMoreInfoFilterForm';

    sfContext::getInstance()->getConfiguration()->loadHelpers('Date');
  }

  public function executeIndex(sfWebRequest $request)
  {
    if ($request->isMethod('POST'))
    {
      $params = $request->getParameter($this->form->getName());

      $this->form->bind($params);

      if ($this->form->isValid())
      {
        $this->setFilters($this->dateRangeNamespace, $params);
        $this->redirect($this->doneRoute);
      }
    }
  }

  public function executeDone(sfWebRequest $request)
  {

    $params = $this->getFilters($this->dateRangeNamespace);

    $this->redirectUnless(sizeof($params), $this->baseRoute);

    //types only for table
    $resultType = HandlingResult::TYPE_LOST;
    $resultId = HandlingResult::getIdBySlug($resultType);
    $this->types = HandlingMoreInfoType::getTypesByResultId($resultId);
    //eof types for table

    //filter
    $this->processFilters($request);
    $this->filters = $this->getFilters($this->filterNamespace);
    //eof filter

    //view variables
    $this->fromDate = $this->getDateShort($params);
    $this->toDate = $this->getDateShort($params, 'to');
    //eof view variables

    $query = Handling::getMoreInfoLostQuery($params);

    $this->processQuery($query, $request);

    $this->results = $query->execute();
  }

  public function getDateShort($params, $type = 'from')
  {
    return format_date($params['date_range'][$type]['year'].'-'.$params['date_range'][$type]['month'].'-'.$params['date_range'][$type]['day'], 'dd.MM.yyyy', 'ru');
  }

  public function setFilters($namespace, $params)
  {
    $this->getUser()->setAttribute($namespace, $params);
  }

  public function unsetFilters($namespace)
  {
    $this->getUser()->getAttributeHolder()->remove($namespace);
  }

  public function getFilters($namespace)
  {
    return $this->getUser()->getAttribute($namespace);
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->filter_form = new $this->filterFormName();

    $params = $request->getParameter($this->filter_form->getName());

    $this->setFilters($this->filtersNamespace, $params);

    $this->redirect($this->doneRoute);
  }

  public function executeClear_filter(sfWebRequest $request)
  {
    $this->unsetFilters($this->filtersNamespace);

    $this->redirect($this->doneRoute);
  }

  public function processFilters(sfWebRequest $request)
  {
    $this->filter_form = new $this->filterFormName();

    $params = $this->getFilters($this->filtersNamespace);

    if (sizeof($params))
    {
      $this->filter_form->bind($params);
    }
  }

  public function processQuery($query, sfWebRequest $request)
  {
    $filters = $this->getFilters($this->filtersNamespace);

    if (sizeof($filters))
    {

      foreach($filters as $key => $value)
      {
        if (!$value)
        {
          continue;
        }
        switch($key)
        {
          case 'user_id':
            $query->addWhere('hu.user_id = ?', $value);
            break;
          case 'scope_id':
            $query->addWhere('o.scope_id = ?', $value);
            break;
          case 'result_id':
            $query->addWhere('h.result_id = ?', $value);
            break;
        }
      }
    }
  }
}
