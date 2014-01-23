<?php foreach ($clients as $client): ?>
    <option value="<?php echo $client->getId()?>"><?php echo $client?></option>
<?php endforeach; ?>
