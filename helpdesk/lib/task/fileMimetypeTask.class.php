<?php

class fileMimetypeTask extends sfBaseTask
{
  protected $mimeTypesArray;

  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'file';
    $this->name             = 'mimetype';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [file:mimetype|INFO] task does things.
Call it with:

  [php symfony file:mimetype|INFO]
EOF;
  }
  protected function execute($arguments = array(), $options = array())
  {
    // configure
    require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
    $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], $options['env'] == 'dev');
    sfContext::createInstance($configuration);

    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $this->logSection('Start: ','file:mimetype');

    $this->logSection('Start: ','process attach files');

    $this->mimeTypesArray = $this->getMimeArray();

    $webDir= sfConfig::get('sf_web_dir');
    $uploadDir = 'uploads/claimfiles';

    //$this->fixBug();

    // attach

    $files = $this->getAttachFiles();

    foreach ($files as $file)
    {
      $sourceDir = $webDir . $uploadDir;

      $filepath = $sourceDir . DIRECTORY_SEPARATOR . $file->getFilepath();

      $fileExt = $this->getFileExt($filepath);

      if ($fileExt)
      {
        $newName = $this->getNewFileName($file->getFilepath(), $fileExt);

        $newFilepath = $sourceDir . DIRECTORY_SEPARATOR . $newName;

        //$rename = rename($filepath, $newFilepath);
        $rename = 1;

        /*$file->setFilepath($newFilepath);
        $file->save();*/

        $this->logSection('File ext: ', "{$rename}   {$newName}   " . $file->getFilepath());
      }
    }

    $this->logSection('End: ','process attach files');

    $this->logSection('End: ','file:mimetype');
  }

  public function fixBug()
  {
    $attaches = Doctrine::getTable('attach')
      ->createQuery('a')
      ->where('a.filepath LIKE ?', '/var/www%')
      // ->limit(1)
      ->execute();

    $webDir= sfConfig::get('sf_web_dir');
    $uploadDir = 'uploads/claimfiles';
    $sourceDir = $webDir . $uploadDir;


    /** @var attach[]|Doctrine_Collection $attaches */
    foreach ($attaches as $attach)
    {
      $filepath = $attach->getFilepath();

      $newName = $this->getNewFileName($filepath, 'bin');

      $newFilepath = $sourceDir . DIRECTORY_SEPARATOR . $newName;

      $attach->setFilepath($newName);
      $attach->save();

      rename($filepath, $newFilepath);

      //$baseName =


      $this->logSection('File path: ', "{$newName} " );
    }
  }

  /**
   * Get file new name
   *
   * @param string $filename
   * @param $fileExt
   * @return string
   */
  public function getNewFileName($filename, $fileExt)
  {
    $oldExt = pathinfo($filename, PATHINFO_EXTENSION);

    return basename($filename, $oldExt) . $fileExt;
  }

  /**
   * Returns file ext
   *
   * @param string $filepath
   * @return string
   */
  public function getFileExt($filepath)
  {
    $fileExt = '';

    if (file_exists($filepath))
    {
      $fileMimetype = $this->getFileMimetype($filepath);

      if (!$fileMimetype)
      {
        $this->logSection('Mimetype NOT DETECTED: ', "{$filepath}", null, 'ERROR');
      }

      if (isset($this->mimeTypesArray[$fileMimetype]))
      {
        $fileExt = $this->mimeTypesArray[$fileMimetype];
      }
      else
      {
        $this->logSection('Mimetype NOT FOUND: ', "{$filepath}", null, 'ERROR');
      }
    }
    else
    {
      $this->logSection('File NOT EXIST: ', "{$filepath}", null, 'ERROR');
    }

    return $fileExt;
  }

  /**
   * Returns attach files where ext = .bin
   *
   * @return attach[]|Doctrine_Collection
   */
  public function getAttachFiles()
  {
    $attaches = Doctrine::getTable('attach')
      ->createQuery('a')
      //->where('a.filepath LIKE ?', '%.bin')
      ->where('a.id = ?', '9073')
      // ->limit(1)
      ->execute();

    return $attaches;
  }

  /**
   * Returns real file ext
   */
  public function getFileMimetype($file)
  {
    /*ob_start();
    //need to use --mime instead of -i. see #6641
    passthru(sprintf('file -b --mime %s 2>/dev/null', escapeshellarg($file)), $return);
    if ($return > 0)
    {
      ob_end_clean();

      return null;
    }
    $type = trim(ob_get_clean());

    if (!preg_match('#^([a-z0-9\-]+/[a-z0-9\-]+)#i', $type, $match))
    {
      // it's not a type, but an error message
      return null;
    }

    return $match[1];*/

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->buffer($file);
  }

  public function getMimeArray($mimePath = '/etc')
  {
    $regex = '/([\w\+\-\.\/]+)\t+([\w\s]+)/i';
    $lines = file("$mimePath/mime.types", FILE_IGNORE_NEW_LINES);

    $mimeArray = array();

    foreach($lines as $line)
    {
      // skip comments
      if (substr($line, 0, 1) == '#')
      {
        continue;
      }
      // skip mime types w/o any extensions
      if (!preg_match($regex, $line, $matches))
      {
        continue;
      }
      $mime = $matches[1];
      $extensions = explode(" ", $matches[2]);

      if (isset($extensions[0]))
      {
        $mimeArray[$mime] = trim($extensions[0]);
      }
    }
    return $mimeArray;
  }
}