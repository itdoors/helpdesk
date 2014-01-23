<?php

/**
 * organization actions.
 *
 * @package    helpdesk
 * @subpackage organization
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class organizationActions extends sfActions
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

    $organization_query = organizationTable::getMyOrganizationQuery();

    $this->processQuery($organization_query, $request);

    $pager = new Doctrine_Pager(
      $organization_query,
      $page,
      $limit
    );

    /*$app = sfContext::getInstance()->getConfiguration()->getApplication();

    $this->canEdit = $this->getUser()->hasCredential($app);*/

    $this->organizations = $pager->execute();

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
    return $this->getUser()->getAttribute('organization.sort', array());
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
            $query->addWhere($query->getRootAlias().'.id = ?', $value);
            break;
          case 'city_id':
            $query->addWhere($query->getRootAlias().'.city_id = ?', $value);
            break;
          case 'region_id':
            $query->addWhere('region.id = ?', $value);
            break;
          case 'scope_id':
            $query->addWhere($query->getRootAlias().'.scope_id = ?', $value);
            break;
          case 'user_id':
            if (isset($value[0]) && !$value[0])
            {
              break;
            }
            $query->andWhereIn('ou.user_id', $value);
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
        case 'name':
          $query->orderBy($query->getRootAlias().'.name '. $sort_order);
          break;
        case 'city':
          $query->orderBy('city.name '. $sort_order);
          break;
        case 'region':
          $query->orderBy('region.name '. $sort_order);
          break;
        case 'region':
          $query->orderBy('scope.name '. $sort_order);
          break;
      }
    }
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->filter_form = new CrmOrganizationFilterForm();

    $params = $request->getParameter($this->filter_form->getName());

    $this->getUser()->setAttribute('organization.filter', $params);

    $this->redirect(url_for('organization/index'));
  }

  public function executeClear_filter(sfWebRequest $request)
  {
    $this->getUser()->getAttributeHolder()->remove('organization.filter');
    $this->getUser()->getAttributeHolder()->remove('organization.sort');

    $this->redirect(url_for('organization/index'));
  }

  public function processFilters(sfWebRequest $request)
  {
    $this->filter_form = new CrmOrganizationFilterForm();

    $params = $this->getFilters();

    if (sizeof($params))
    {
      $this->filter_form->bind($params);
    }
  }

  public function getFilters()
  {
    return $this->getUser()->getAttribute('organization.filter');
  }

  public function executeSort(sfWebrequest $request)
  {
    $sort_field = $request->getParameter('sort_field');
    $sort_type = $request->getParameter('sort_type');

    $sort = array($sort_field => $sort_type);

    $this->getUser()->setAttribute('organization.sort', $sort);

    $this->redirect(url_for('organization/index'));

  }

  public function executeShow(sfWebRequest $request)
  {
    $organizationId = $request->getParameter('organization_id');

    if (!OrganizationUser::hasAccess($organizationId))
    {
      $this->getUser()->setFlash('error', 'You have no permission to access this page');
      $this->redirect('common/index');
    }

    $this->organization = Doctrine::getTable('organization')->find($organizationId);
  }

  public function executeRefresh_contacts(sfWebRequest $request)
  {
    $organization_id = $request->getParameter('organization_id');

    return $this->renderComponent('organization', 'organization_contact_list', array('organization_id' => $organization_id));
  }

  public function executeRefresh_users(sfWebRequest $request)
  {
    $organizationId = $request->getParameter('organization_id');

    return $this->renderComponent('organization', 'users_list', array('organizationId' => $organizationId));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CrmOrganizationForm();
    $this->setTemplate('new');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CrmOrganizationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  /*public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($handling = Doctrine_Core::getTable('Handling')->find(array($request->getParameter('id'))), sprintf('Object handling does not exist (%s).', $request->getParameter('id')));
    $this->form = new HandlingForm($handling);
    $this->setTemplate('edit');
  }*/

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($organization = Doctrine_Core::getTable('Organization')->find(array($request->getParameter('id'))), sprintf('Object organization does not exist (%s).', $request->getParameter('id')));
    $this->form = new CrmOrganizationForm($organization);

    $this->processForm($request, $this->form);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $organization = $form->save();

      $this->redirect(url_for('organization_show', array('organization_id' => $organization->getId())));
      //$this->redirect('handling');
    }
  }

  public function executeDuplicate(sfWebRequest $request)
  {
    $name = $request->getParameter('name');

    $organizations = OrganizationTable::getOrganizationLikeName($name);

    return $this->renderPartial('duplicate', array('organizations' => $organizations));
  }
}
