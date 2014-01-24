<?php

class sfActorPhotoValidatedFile extends sfValidatedFile
{
  public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
  {
    $file_name = $this->generateFilename();

    $imagesSize = sfConfig::get('app_profile_images');

    foreach ($imagesSize as $imagePrefix => $imageSize)
    {
      /** @var sfImage $img */
      $img = new sfImage($this->tempName);
      //$img->resize($this->getThumbnailWidth($img),$this->getThumbnailHeight($img));
      $img->thumbnail($imageSize[0], $imageSize[1], 'center');
      $img->setQuality(90);

      if (!file_exists($this->path)) {
        mkdir($this->path, 0777, true);
      }

      $img->saveAs($this->path . DIRECTORY_SEPARATOR . $imagePrefix . '_'.$file_name);
    }

    return $file_name;
  }

  /**
   * Returns thumbnail width
   *
   * @param sfImage $img
   * @return int
   */
  protected function getThumbnailWidth($img)
  {
    $width = $img->getWidth();
    $height = $img->getHeight();
    if ($width >= $height)
    {
      return sfConfig::get('thumbnail_size');
    }
    $width = round(sfConfig::get('thumbnail_size')/$height*$width);
    return $width;
  }

  /**
   * Returns thumbnail height
   *
   * @param sfImage $img
   * @return int
   */
  protected function getThumbnailHeight($img)
  {
    $width = $img->getWidth();
    $height = $img->getHeight();
    if ($height >= $width)
    {
      return sfConfig::get('thumbnail_size');
    }
    $height =  round(sfConfig::get('thumbnail_size')/$width*$height);
    return  $height;
  }
}