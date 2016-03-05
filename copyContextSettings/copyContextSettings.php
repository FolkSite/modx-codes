<?php

/* 
 * copyContextSettings
 * The snippet for MODX Revolution
 * See Documentation: https://github.com/dencodes/modx-codes/tree/master/copyContextSettings
 * AUTHOR: Denis Tkach - https://github.com/dencodes/
 */

$context = $modx->getOption('context', $scriptProperties);
$toContext = $modx->getOption('toContext', $scriptProperties);
$settings = trim($modx->getOption('settings', $scriptProperties));
$replace = $modx->getOption('replace', $scriptProperties, '1');
$clear = $modx->getOption('clear', $scriptProperties);

$enable = $modx->getOption('enable', $scriptProperties);

if (!$enable || $enable == '0') {return '';}

$arr_to = array_map('trim',explode(',',trim($toContext)));

$output = '';

if (!$context || !$arr_to) {
    return '<p>error: check input params</p>';
}

$context_obj = $modx->getContext($context);

if (!$context_obj) {
    return '<p>error: wrong source context key</p>';
}

$settings_src = $context_obj->config;

if (!$settings_src) {
    return '<p>exit: the context "'.$context.'" has no settings</p>';
}

$arr_settings = strlen($settings) ? array_map('trim',explode(',',$settings)) : array();

foreach ($arr_to AS $context_key) {
    $output .= '<p>'.$context_key.': ';
    
    $context_to = $modx->getContext($context_key);
    if (!$context_to) {
        $output .= 'the context is not exists';
    }
    else {
        
        if (trim($clear)) {
            $settings_target = array_keys($context_to->config);
            $modx->removeCollection('modContextSetting',array('context_key'=>$context_key));
        }
        
        foreach ($settings_src AS $key=>$val) {
            if ($arr_settings && !in_array($key,$arr_settings)) {continue;}
            $output .= $key.' - ';
            $setting = $modx->getObject('modContextSetting', array(
             'context_key' => $context_key,
             'key' => $key,
             ));
            
            if ($setting && $replace=='0') {
                $output .= 'exists && passed; ';
                continue;
            }
            
            if (!$setting) {
                $setting = $modx->newObject('modContextSetting');
                $setting->set('context_key', $context_key);
                $setting->set('key', $key);
            }
            
            $setting->set('value',$val);
            $setting->save();
            
            $output .= $val.'; ';
        }
    }
    $output .= '</p>';
}

return $output;
