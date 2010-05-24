<?php
$this->configCache->registerConfigHandler('config/include_path.yml',
  'sfSimpleYamlConfigHandler');
$data = $this->configCache->checkConfig('config/include_path.yml', true);
if ($data)
{
  $data = include($data);
  $paths = array();
  foreach ($data['include_path'] as $name=>$include_path)
  {
    $include_path = sfToolkit::replaceConstants($include_path);
    $paths[] = $include_path;
  }
  set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $paths));
}