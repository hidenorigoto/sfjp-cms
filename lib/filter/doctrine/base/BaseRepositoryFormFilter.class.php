<?php

/**
 * Repository filter form base class.
 *
 * @package    sfjp-cms
 * @subpackage filter
 * @author     hidenorigoto
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRepositoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(),
      'repository'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subdirectory'  => new sfWidgetFormFilterInput(),
      'bind_path'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'settings_json' => new sfWidgetFormFilterInput(),
      'force_update'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'force_clone'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'repository'    => new sfValidatorPass(array('required' => false)),
      'subdirectory'  => new sfValidatorPass(array('required' => false)),
      'bind_path'     => new sfValidatorPass(array('required' => false)),
      'settings_json' => new sfValidatorPass(array('required' => false)),
      'force_update'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'force_clone'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('repository_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Repository';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'repository'    => 'Text',
      'subdirectory'  => 'Text',
      'bind_path'     => 'Text',
      'settings_json' => 'Text',
      'force_update'  => 'Boolean',
      'force_clone'   => 'Boolean',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
