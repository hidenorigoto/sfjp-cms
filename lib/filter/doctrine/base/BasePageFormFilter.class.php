<?php

/**
 * Page filter form base class.
 *
 * @package    prj
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'repository_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Repository'), 'add_empty' => true)),
      'path'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content_raw'      => new sfWidgetFormFilterInput(),
      'content_type'     => new sfWidgetFormFilterInput(),
      'content_rendered' => new sfWidgetFormFilterInput(),
      'title'            => new sfWidgetFormFilterInput(),
      'index_json'       => new sfWidgetFormFilterInput(),
      'last_updated'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'repository_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Repository'), 'column' => 'id')),
      'path'             => new sfValidatorPass(array('required' => false)),
      'content_raw'      => new sfValidatorPass(array('required' => false)),
      'content_type'     => new sfValidatorPass(array('required' => false)),
      'content_rendered' => new sfValidatorPass(array('required' => false)),
      'title'            => new sfValidatorPass(array('required' => false)),
      'index_json'       => new sfValidatorPass(array('required' => false)),
      'last_updated'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('page_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Page';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'repository_id'    => 'ForeignKey',
      'path'             => 'Text',
      'content_raw'      => 'Text',
      'content_type'     => 'Text',
      'content_rendered' => 'Text',
      'title'            => 'Text',
      'index_json'       => 'Text',
      'last_updated'     => 'Date',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
