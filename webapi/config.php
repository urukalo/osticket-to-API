<?php
    require_once INCLUDE_DIR.'class.plugin.php';

    class WebApiPluginConfig extends PluginConfig
    {

        function getOptions()
        {
            return array(
                'webapi' => new SectionBreakField(array(
                    'label' => 'Web API notifier',
                    )),
                'webapi-url' => new TextboxField(array(
                    'label' => 'Web API URL',
                    'configuration' => array('size' => 100, 'length' => 200),
                    )),
            );
        }
    }