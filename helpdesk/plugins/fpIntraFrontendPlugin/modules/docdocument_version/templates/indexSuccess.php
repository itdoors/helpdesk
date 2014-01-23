<?php echo get_component('category', 'breadcrumbs')?> 

<h1>Doc document versions List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Filepath</th>
      <th>Mime type</th>
      <th>Createdatetime</th>
      <th>User</th>
      <th>Document</th>
      <th>Isdeleted</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($doc_document_versions as $doc_document_version): ?>
    <tr>
      <td><a href="<?php echo url_for('docdocument_version/edit?id='.$doc_document_version->getId()) ?>"><?php echo $doc_document_version->getId() ?></a></td>
      <td><?php echo $doc_document_version->getName() ?></td>
      <td><?php echo $doc_document_version->getFilepath() ?></td>
      <td><?php echo $doc_document_version->getMimeType() ?></td>
      <td><?php echo $doc_document_version->getCreatedatetime() ?></td>
      <td><?php echo $doc_document_version->getUserId() ?></td>
      <td><?php echo $doc_document_version->getDocumentId() ?></td>
      <td><?php echo $doc_document_version->getIsdeleted() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('docdocument_version/new') ?>">New</a>
