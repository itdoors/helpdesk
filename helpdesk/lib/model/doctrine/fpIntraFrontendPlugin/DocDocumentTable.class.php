<?php

/**
 * DocDocumentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DocDocumentTable extends PluginDocDocumentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object DocDocumentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('DocDocument');
    }
    
    public function getDocumentsByCategoryId($category_id)
    {
        if (!$category_id) return array();
        return Doctrine::getTable('DocDocument')
        ->createQuery('d')
        ->where('d.category_id = '.$category_id)
        ->orderBy('d.name')
        ->execute();
    }
    
    public function getDocumentsByKeywords($keywords)
    {
        $documents_keyword = $keywords['search_documents']; 
        $q = Doctrine::getTable('DocDocument')
        ->createQuery('d')
        ->select('d.name, d.description');
        //->leftJoin('u.Stuff s')
        //->where('u.id = s.id');
        $keywords_array = explode(' ', $documents_keyword);
        foreach ($keywords_array as $keyword)
        {
          if ($keyword&&strlen($keyword)>2)
          $q->orWhere('(LOWER(d.name) LIKE \'%'.mb_strtolower($keyword, 'UTF-8').'%\' 
          OR LOWER(d.description) LIKE \'%'.mb_strtolower($keyword, 'UTF-8').'%\')
          ');
        };
        //die($q);
        return $q->execute();
    }
}