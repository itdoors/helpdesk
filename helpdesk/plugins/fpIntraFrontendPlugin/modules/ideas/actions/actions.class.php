<?php

/**
 * handling actions.
 *
 * @package    helpdesk
 * @subpackage handling
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ideasActions extends sfActions
{
  public function preExecute()
  {
    $this->baseRoute = 'ideas';
    $this->showRoute = 'ideas_show';

    $this->recordFormName = 'IdeaForm';

    $this->filtersNamespace = 'ideas.filters';
    $this->sortNamespace = 'ideas.sort';

    $this->filterFormName = 'IntranetIdeasFilterForm';

    $this->baseModuleName = 'ideas';

    $this->canEdit = $this->getUser()->hasCredential('intranetadmin');

    $this->limit = 30;

    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Date', 'Url'));
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);

    $limit = $this->limit;

    $query = IdeaTable::getIdeasQuery();

    $this->processQuery($query, $request);

    $pager = new Doctrine_Pager(
      $query,
      $page,
      $limit
    );

    $this->records = $pager->execute();

    $this->pager = $pager;

    $this->pager->links = $this->getLinks($page, $this->pager->getLastPage());

    //filter
    $this->processFilters($request);

    $this->filters = $this->getFilters();

    $this->sort = $this->getSort();
  }

  public function getLinks($page, $last_page, $nb_links = 25)
  {
    $links = array();
    $tmp   = $page - floor($nb_links / 2);
    $check = $last_page - $nb_links + 1;
    $limit = $check > 0 ? $check : 1;
    $begin = $tmp > 0 ? ($tmp > $limit ? $limit : $tmp) : 1;

    $i = (int) $begin;
    while ($i < $begin + $nb_links && $i <= $last_page)
    {
      $links[] = $i++;
    }

    //$this->currentMaxLink = count($links) ? $links[count($links) - 1] : 1;

    return $links;
  }

  public function getSort()
  {
    return $this->getUser()->getAttribute($this->sortNamespace, array());
  }

  public function processQuery($query, sfWebRequest $request)
  {
    $filters = $this->getFilters();

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
            $query->addWhere($query->getRootAlias().'.user_id = ?', $value);
            break;
          case 'date_range':
            if (isset($value['from']['day']) && isset($value['from']['month']) && isset($value['from']['year']))
            {
              if ($value['from']['day'] && $value['from']['month'] && $value['from']['year'])
              {
                $fromDate = $value['from']['year'].'-'.$value['from']['month'].'-'.$value['from']['day'].' 0:0:0';

                $query->addWhere($query->getRootAlias().'.createdatetime >= ?', $fromDate);
              }
            }
            if (isset($value['to']['day']) && isset($value['to']['month']) && isset($value['to']['year']))
            {
              if ($value['to']['day'] && $value['to']['month'] && $value['to']['year'])
              {
                $toDate = $value['to']['year'].'-'.$value['to']['month'].'-'.$value['to']['day'].' 23:59:59';
                $query->addWhere($query->getRootAlias().'.createdatetime <= ?', $toDate);
              }
            }
            //$query->addWhere($query->getRootAlias().'.user_id = ?', $value);
            break;
        }
      }
    }

    $sort = $this->getSort();

    if (!sizeof($sort))
    {
      $query->orderBy($query->getRootAlias().'.id DESC');
      return;
    }

    foreach($sort as $key => $value)
    {
      if (!$value)
      {
        continue;
      }

      $sort_order = $value == 'DESC' ? 'DESC' : 'ASC';

      switch($key) {
        case 'organization_id':
          $query->orderBy($query->getRootAlias().'.organization_id '. $sort_order);
          break;
        case 'createdatetime':
          $query->orderBy($query->getRootAlias().'.createdatetime '. $sort_order);
          break;
        case 'last_handling_date':
          $query->orderBy($query->getRootAlias().'.last_handling_date '. $sort_order);
          break;
      }
    }
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->filter_form = new $this->filterFormName();

    $params = $request->getParameter($this->filter_form->getName());

    $this->getUser()->setAttribute($this->filtersNamespace, $params);

    $this->redirect(url_for($this->baseRoute));
  }

  public function executeClear_filter(sfWebRequest $request)
  {
    $this->getUser()->getAttributeHolder()->remove($this->filtersNamespace);
    $this->getUser()->getAttributeHolder()->remove($this->sortNamespace);

    $this->redirect(url_for($this->baseRoute));
  }

  public function processFilters(sfWebRequest $request)
  {
    $this->filter_form = new $this->filterFormName();

    $params = $this->getFilters();

    if (sizeof($params))
    {
      $this->filter_form->bind($params);
    }
  }

  public function getFilters()
  {
    return $this->getUser()->getAttribute($this->filtersNamespace);
  }

  public function executeSort(sfWebrequest $request)
  {
    $sort_field = $request->getParameter('sort_field');
    $sort_type = $request->getParameter('sort_type');

    $sort = array($sort_field => $sort_type);

    $this->getUser()->setAttribute($this->sortNamespace, $sort);

    $this->redirect(url_for($this->baseRoute));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new $this->recordFormName();
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new $this->recordFormName();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $handling = $form->save();

      //$this->redirect('handling/edit?id='.$handling->getId());
      $this->redirect($this->baseRoute);
    }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->redirectUnless($record = Doctrine::getTable('Idea')->find($request->getParameter('id')) , $this->baseRoute);

    $isAdmin = $this->getUser()->hasCredential('intranetadmin');

    $userId = GlobalFunctions::getUserId();

    $this->redirectUnless($record->getUserId() == $userId || $isAdmin , $this->baseRoute);

    $this->record = $record;
  }

  public function executeRefreshTotal(sfWebRequest $request)
  {
    $record = Doctrine::getTable('Idea')->find($request->getParameter('id'));

    if (!$record)
    {
      return sfView::NONE;
    }

    return $this->renderText($record->getTotal());
  }

  public function executeSendEmail(sfWebRequest $request)
  {
    $record = Doctrine::getTable('Idea')->find($request->getParameter('id'));

    if (!$record)
    {
      return sfView::NONE;
    }

    $user = Doctrine::getTable('sfGuardUser')->find($record->getUserId());

    $subjectUser = SDtexts::getIdeaChangeByExpertSubjectUser($user->getFullName());
    $subjectText = SDtexts::getIdeaChangeByExpertTextUser($record, $user->getFullName());
    MailFunctions::sendMessageToUserById($user->getId(), $subjectUser, $subjectText, true);

    return $this->renderText($record->getTotal());
  }
}
