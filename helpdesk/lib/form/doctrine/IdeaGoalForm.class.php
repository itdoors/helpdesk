<?php

/**
 * IdeaGoal form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IdeaGoalForm extends BaseIdeaGoalForm
{
  public function configure()
  {
    unset($this['idea_list']);
  }
}
