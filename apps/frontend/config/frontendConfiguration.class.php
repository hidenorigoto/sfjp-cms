<?php
class frontendConfiguration extends sfApplicationConfiguration {
    public function configure()
    {
        $this->dispatcher->connect('request.filter_parameters', array($this, 'listenToRequestFilterParameters'));
        $this->dispatcher->connect('template.filter_parameters', array($this, 'listenToTemplateFilterParameters'));
    }

    public function listenToRequestFilterParameters(sfEvent $event, $parameters)
    {
        require_once 'LocalHelper.php';
        return $parameters;
    }
    public function listenToTemplateFilterParameters(sfEvent $event, $parameters)
    {
        $request                = sfContext::getInstance()->getRequest();
        $parameters['pathinfo'] = $request->getPathInfo();
         return $parameters;
    }
}