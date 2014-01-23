<?php

/**
 * handling actions.
 *
 * @package    helpdesk
 * @subpackage handling
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class handlingActions extends sfActions
{
  public function preExecute()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);

    $limit = 30;

    $query = HandlingTable::getMyHandlingQuery();

    $this->processQuery($query, $request);

    $pager = new Doctrine_Pager(
      $query,
      $page,
      $limit
    );

    /*$app = sfContext::getInstance()->getConfiguration()->getApplication();

    $this->canEdit = $this->getUser()->hasCredential($app);*/

    $this->handlings = $pager->execute();

    $this->pager = $pager;

    $this->pager->links = $this->getLinks($page, $this->pager->getLastPage());

    //filter
    $this->processFilters($request);

    $this->filters = $this->getFilters();

    $this->sort = $this->getSort();

    $this->processLayout();
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
    return $this->getUser()->getAttribute('handling.sort', array());
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
          case 'organization_id':
            $query->addWhere($query->getRootAlias().'.organization_id = ?', $value);
            break;
          case 'city_id':
            $query->addWhere('o.city_id = ?', $value);
            break;
          case 'scope_id':
            $query->addWhere('o.scope_id = ?', $value);
            break;
          case 'chance':
            $query->addWhere($query->getRootAlias().'.chance LIKE ?', '%'.$value.'%');
            break;
          case 'user_id':
            $query->addWhere('hu.user_id = ?', $value);
            break;
          case 'type_id':
            if (isset($value[0]) && !$value[0])
            {
              break;
            }
            $query->andWhereIn($query->getRootAlias().'.type_id', $value);
            break;
          case 'status_id':
            $query->addWhere($query->getRootAlias().'.status_id = ?', $value);
            break;
          case 'result_id':
            $query->addWhere($query->getRootAlias().'.result_id = ?', $value);
            break;
        }
      }
    }

    $sort = $this->getSort();

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
    $this->filter_form = new CrmHandlingFilterForm();

    $params = $request->getParameter($this->filter_form->getName());

    $this->getUser()->setAttribute('handling.filter', $params);

    $this->redirect(url_for('handling/index'));
  }

  public function executeClear_filter(sfWebRequest $request)
  {
    $this->getUser()->getAttributeHolder()->remove('handling.filter');
    $this->getUser()->getAttributeHolder()->remove('handling.sort');

    $this->redirect(url_for('handling/index'));
  }

  public function processFilters(sfWebRequest $request)
  {
    $this->filter_form = new CrmHandlingFilterForm();

    $params = $this->getFilters();

    if (sizeof($params))
    {
      $this->filter_form->bind($params);
    }
  }

  public function getFilters()
  {
    return $this->getUser()->getAttribute('handling.filter');
  }

  public function executeSort(sfWebrequest $request)
  {
    $sort_field = $request->getParameter('sort_field');
    $sort_type = $request->getParameter('sort_type');

    $sort = array($sort_field => $sort_type);

    $this->getUser()->setAttribute('handling.sort', $sort);

    $this->redirect(url_for('handling/index'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->redirectUnless(Handling::getSessionOrganizationId(), 'handling');
    $this->form = new HandlingForm();
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new HandlingForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /*public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($handling = Doctrine_Core::getTable('Handling')->find(array($request->getParameter('id'))), sprintf('Object handling does not exist (%s).', $request->getParameter('id')));
    $this->form = new HandlingForm($handling);
    $this->setTemplate('edit');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($handling = Doctrine_Core::getTable('Handling')->find(array($request->getParameter('id'))), sprintf('Object handling does not exist (%s).', $request->getParameter('id')));
    $this->form = new HandlingForm($handling);

    $this->processForm($request, $this->form);
  }*/

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $handling = $form->save();

      //$this->redirect('handling/edit?id='.$handling->getId());
      $this->redirect('handling');
    }
  }

  public function executeList(sfWebRequest $request)
  {
    $organization_id = $request->getParameter('organization_id');

    $filters = $this->getFilters();

    $filters['organization_id'] = $organization_id;

    $this->getUser()->setAttribute('handling.filter', $filters);

    $this->redirect('handling');
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->redirectUnless($handling = Doctrine::getTable('Handling')->find($request->getParameter('handling_id')) , 'handling');

    $this->handling = $handling;
  }

  public function executeRefresh_messages(sfWebRequest $request)
  {
    $handlingId = $request->getParameter('handlingId');

    return $this->renderComponent('handling', 'handling_messages', array('handlingId' => $handlingId));
  }

  public function executeRefresh_managers(sfWebRequest $request)
  {
    $handlingId = $request->getParameter('handling_id');

    return $this->renderComponent('handling', 'managers_list', array('handling_id' => $handlingId));
  }

  public function executeClose(sfWebRequest $request)
  {
    $this->redirectUnless($this->getUser()->hasCredential('crmadmin'), 'handling');

    $this->redirectUnless($handling = Doctrine::getTable('Handling')->find($request->getParameter('handling_id')), 'handling');

    $isClosed = $request->getParameter('link') == 'open' ? false : true;

    $handling->setIsClosed($isClosed);
    $handling->save();

    $handling->History('is_closed', 'getIsClosed');

    $this->redirect(url_for('handling_show', array('handling_id' => $handling->getId())));
  }

  public function executeTender(sfWebRequest $request)
  {
    $filters = $this->getFilters();
    $filters['type_id'] = HandlingType::getTenderIds();
    $this->getUser()->setAttribute('handling.filter', $filters);

    $this->redirect('handling');
  }

  public function processLayout()
  {
    $filters = $this->getFilters();

    $isTender = false;

    if (isset($filters['type_id']))
    {
      foreach ($filters['type_id'] as $type)
      {
        if (in_array($type, HandlingType::getTenderIds()))
        {
          $isTender = true;
          break;
        }
      }
    }

    if ($isTender)
    {
      $this->setTemplate('tender');
    }
  }

  public function executeMore_info(sfWebRequest $request)
  {
    $handlingId = $request->getParameter('handlingId');
    $type = $request->getParameter('type');

    return $this->renderComponent('handling', 'more_info', array(
      'handlingId' => $handlingId,
      'type' => $type
    ));
  }
}
