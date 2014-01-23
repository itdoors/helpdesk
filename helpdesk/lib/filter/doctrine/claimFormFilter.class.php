<?php

/**
 * claim filter form.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimFormFilter extends BaseclaimFormFilter
{
  public function configure()
  {
  }
}

class claimDispatcherFormFilter extends BaseclaimFormFilter
{
  public function configure()
  {
      unset(
        $this['createdatetime'],
        $this['closedatetime'],
        $this['isclosedclient'],
        $this['isclosedstuff'],
        $this['description'],
        $this['stuffdescription']
      );
  }
}