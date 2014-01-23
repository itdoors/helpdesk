<?php
$dir_bool = 'Все ОК!!!';
$file_bool = 'Все ОК!!!'; 
?>

<h1>Doc document versions List</h1>

<table>

  <tbody>
    <?php foreach ($doc_document_versions as $doc_document_version): ?>
    <tr>
     
      <td><?php echo $doc_document_version->getFilepath() ?></td>
      <td><?php
         /* $document_id = $doc_document_version->getDocumentId();
          $dir = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'docdocuments'.DIRECTORY_SEPARATOR.$document_id;
          if (file_exists($dir))
          
          echo "ЕСТЬ - $dir"; else 
            {
                $dirMode = 0777;
                $create = true;    
                if (!is_readable($dir))
                    {
                      if ($create && !@mkdir($dir, $dirMode, true))
                      {
                        // failed to create the directory
                        throw new Exception(sprintf('Failed to create file upload directory "%s".', $dir));
                      }

                      // chmod the directory since it doesn't seem to work on recursive paths
                      chmod($dir, $dirMode);
                    }
                
                
                echo "НЕТ- $dir";
                $dir_bool = 'ПЛОХО!!!!';
            };                         */
       ?></td>
      <td><?php 
         /* $new_file = $dir.DIRECTORY_SEPARATOR.$doc_document_version->getFilepath();
          $old_file = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'docdocuments'.DIRECTORY_SEPARATOR.$doc_document_version->getFilepath();
          if (!file_exists($new_file)&&file_exists($dir)&&file_exists($old_file))   
           {
                
                 copy(
                  $old_file,
                  $new_file);
                 
                
                //echo "НЕТ- $new_file";
                //$file_bool = 'ПЛОХО!!!!';
            } 
            else echo "ЕСТЬ - $new_file";  */
           
      ?></td>
     
    </tr>
    <?php endforeach; ?>
  </tbody>
    <thead>
    <tr>

      <th>Filepath</th>
      <th>Mime type</th>
      <th>Createdatetime</th>

    </tr>
    <tr >
      <td></td>
      <td><?php echo $dir_bool?></td>
      <td><?php echo $file_bool?></td>
      
    </tr>
  </thead>
</table>

