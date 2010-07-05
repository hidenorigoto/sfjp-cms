<?php

/**
 * Page form base class.
 *
 * @method Page getObject() Returns the current form's model object
 *
 * @package    sfjp-cms
 * @subpackage form
 * @author     hidenorigoto
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'repository_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Repository'), 'add_empty' => false)),
      'path'               => new sfWidgetFormInputText(),
      'content_raw'        => new sfWidgetFormTextarea(),
      'content_type'       => new sfWidgetFormInputText(),
      'content_rendered'   => new sfWidgetFormTextarea(),
      'title'              => new sfWidgetFormInputText(),
      'index_json'         => new sfWidgetFormTextarea(),
      'last_updated'       => new sfWidgetFormDateTime(),
      'last_updated_ym'    => new sfWidgetFormInputText(),
      'first_committed'    => new sfWidgetFormDateTime(),
      'first_committed_ym' => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'repository_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Repository'))),
      'path'               => new sfValidatorString(array('max_length' => 255)),
      'content_raw'        => new sfValidatorString(array('required' => false)),
      'content_type'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'content_rendered'   => new sfValidatorString(array('required' => false)),
      'title'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'index_json'         => new sfValidatorString(array('required' => false)),
      'last_updated'       => new sfValidatorDateTime(array('required' => false)),
      'last_updated_ym'    => new sfValidatorInteger(array('required' => false)),
      'first_committed'    => new sfValidatorDateTime(array('required' => false)),
      'first_committed_ym' => new sfValidatorInteger(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('page[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Page';
  }

}
