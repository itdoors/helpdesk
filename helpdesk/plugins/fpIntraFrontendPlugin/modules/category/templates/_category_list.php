<h1></h2>

<?php foreach ($categories as $category): ?>
    <?php if (!$category->getIsdeleted()) {?>
       <a href="<?php echo url_for('category/index?parent_id='.$category->getId()) ?>" class="folder">
        <?php echo $category->getName() ?>
        <?php echo "( ".count($category->getChildrens())." )"?>
    </a>
    <?php } else echo "<span class=\"folder\">".$category->getName()."</span>"?>
    <?php
    if (!$category->getIsdeleted()) { 
        
        /*echo link_to_if(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all',__('Edit'), 'category/edit?id='.$category->getId(), array('style'=>"font-size: 9px;"));
        echo " ";
        echo link_to_if(DocDocumentGroup::hasPermmisions() == 'action_all',__('Delete'), 'category/delete?id='.$category->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'style'=>"font-size: 9px;"));
        */
        echo link_to(__('Edit'), 'category/edit?id='.$category->getId(), array('style'=>"font-size: 9px;"));
        echo " ";
        echo link_to(__('Delete'), 'category/delete?id='.$category->getId(), array('method' => 'delete', 'confirm' => __('Are you sure?'), 'style'=>"font-size: 9px;"));
        
    //} else echo link_to_if(DocDocumentGroup::hasPermmisions() == 'action_all',__('Return'), 'category/restore?id='.$category->getId(), array('method' => 'put', 'confirm' => 'Are you sure?','style'=>"font-size: 9px;"));  
    } else echo link_to(__('Return'), 'category/restore?id='.$category->getId(), array('method' => 'put', 'confirm' => __('Are you sure?'),'style'=>"font-size: 9px;"));  
    ?> 
      
<?php endforeach; ?>
