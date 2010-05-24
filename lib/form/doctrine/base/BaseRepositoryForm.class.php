<?php

/**
 * Repository form base class.
 *
 * @method Repository getObject() Returns the current form's model object
 *
 * @package    prj
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseRepositoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormTextarea(),
      'repository'    => new sfWidgetFormTextarea(),
      'subdirectory'  => new sfWidgetFormTextarea(),
      'bind_path'     => new sfWidgetFormInputText(),
      'settings_json' => new sfWidgetFormTextarea(),
      'force_update'  => new sfWidgetFormInputCheckbox(),
      'force_clone'   => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'          => new sfValidatorString(array('required' => false)),
      'repository'    => new sfValidatorString(array('max_length' => 256)),
      'subdirectory'  => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'bind_path'     => new sfValidatorString(array('max_length' => 128)),
      'settings_json' => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'force_update'  => new sfValidatorBoolean(array('required' => false)),
      'force_clone'   => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('repository[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Repository';
  }

}
