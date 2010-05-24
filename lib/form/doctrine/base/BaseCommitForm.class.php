<?php

/**
 * Commit form base class.
 *
 * @method Commit getObject() Returns the current form's model object
 *
 * @package    prj
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCommitForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'committed_at'     => new sfWidgetFormDateTime(),
      'author_handle'    => new sfWidgetFormInputText(),
      'author_email'     => new sfWidgetFormInputText(),
      'committer_handle' => new sfWidgetFormInputText(),
      'committer_email'  => new sfWidgetFormInputText(),
      'commit_key'       => new sfWidgetFormInputText(),
      'commit_url'       => new sfWidgetFormTextarea(),
      'page_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Page'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'committed_at'     => new sfValidatorDateTime(array('required' => false)),
      'author_handle'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'author_email'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'committer_handle' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'committer_email'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'commit_key'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'commit_url'       => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'page_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Page'))),
    ));

    $this->widgetSchema->setNameFormat('commit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commit';
  }

}
