<?php

/**
 * commentsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class commentsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object commentsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('comments');
    }
    
    public function getCommentsByClaimClient($claim_id)
    {
      $q = Doctrine_Core::getTable('comments')
      ->createQuery('c')
      ->leftJoin('c.Users u')
      ->leftJoin('c.Attach a')
      ->where('c.claim_id = '.$claim_id)
      ->addWhere('c.isvisible = false')
      ->orderBy('c.createdatetime ASC')
      ->execute();
      return $q;
    }
    
    public function getCommentsByClaimStuff($claim_id)
    {
      $q = Doctrine_Core::getTable('comments')
      ->createQuery('c')
      ->leftJoin('c.Users u')
      ->leftJoin('c.Attach a')
      ->where('c.claim_id = '.$claim_id)
      ->orderBy('c.createdatetime ASC')
      ->execute();
      return $q;
    }
    
    public function getCommentsByClaimKurator($claim_id)
    {
        return $this->getCommentsByClaimStuff($claim_id);
    }
    
    public function getCommentsByClaimOper($claim_id)
    {
      return $this->getCommentsByClaimStuff($claim_id);
    }
    public function getCommentsByClaimDispatcher($claim_id)
    {
        return $this->getCommentsByClaimStuff($claim_id);
    }
    
    public function getCommentsByClaimSupervisor($claim_id)
    {
        return $this->getCommentsByClaimStuff($claim_id);
    }
    public function getCommentsByClaimSmeta($claim_id)
    {
        return $this->getCommentsByClaimStuff($claim_id);
    }
    public function getCommentsByClaimFinance($claim_id)
    {
        return $this->getCommentsByClaimStuff($claim_id);
    }
    
}