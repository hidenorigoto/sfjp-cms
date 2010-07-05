<?php

/**
 * Commit filter form base class.
 *
 * @package    sfjp-cms
 * @subpackage filter
 * @author     hidenorigoto
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCommitFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'committed_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'author_handle'    => new sfWidgetFormFilterInput(),
      'author_email'     => new sfWidgetFormFilterInput(),
      'committer_handle' => new sfWidgetFormFilterInput(),
      'committer_email'  => new sfWidgetFormFilterInput(),
      'commit_key'       => new sfWidgetFormFilterInput(),
      'commit_url'       => new sfWidgetFormFilterInput(),
      'page_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Page'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'committed_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'author_handle'    => new sfValidatorPass(array('required' => false)),
      'author_email'     => new sfValidatorPass(array('required' => false)),
      'committer_handle' => new sfValidatorPass(array('required' => false)),
      'committer_email'  => new sfValidatorPass(array('required' => false)),
      'commit_key'       => new sfValidatorPass(array('required' => false)),
      'commit_url'       => new sfValidatorPass(array('required' => false)),
      'page_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Page'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('commit_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commit';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'committed_at'     => 'Date',
      'author_handle'    => 'Text',
      'author_email'     => 'Text',
      'committer_handle' => 'Text',
      'committer_email'  => 'Text',
      'commit_key'       => 'Text',
      'commit_url'       => 'Text',
      'page_id'          => 'ForeignKey',
    );
  }
}
