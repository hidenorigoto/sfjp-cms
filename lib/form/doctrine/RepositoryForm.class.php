<?php

/**
 * Repository form.
 *
 * @package    sfjp
 * @subpackage form
 * @author     hidenorigoto
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RepositoryForm extends BaseRepositoryForm
{
  public function configure()
  {
    $this->useFields(array(
        'id',
        'name',
        'repository',
        'subdirectory',
        'bind_path',
        'force_update',
        'force_clone'
    ));
  }
}
