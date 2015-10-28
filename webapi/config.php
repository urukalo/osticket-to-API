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
//                'webapi-fields' => new ChoiceField(array(
//                    'label' => 'Choose fields for transmition to web API',
//                    'configuration' => array(
//                        'multiselect' => true,
//                        'classes' => 'vertical-pad',
//                    ),
//                    'choices' => array(
//                        'phone' => __('Phone Number'),
//                        'email' => __('Email Address'),
//                        'ip' => __('IP Address'),
//                        'number' => __('Number'),
//                        'regex' => __('Custom (Regular Expression)'),
//                        '' => __('None')),
//                    ))
            );
        }
    }