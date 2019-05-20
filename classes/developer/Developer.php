<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This class will help you debug your application and access developer tools
 */

namespace Aqua;

class Developer
{
    public static function init() : void
    {
        $output = '
        <style>
            #AQUA_DEVTOOLS {
                background: #ffffff;
                width: auto;
                height: auto;
                position: fixed;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 500000;
                border-top: 2px solid #eeeeee;
                display: flex;
            }
            
            #AQUA_DEVTOOLS > div {
                padding: 10px;
                border-right: 2px solid #eeeeee;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 12px;
                font-family: monospace;
            }
        </style>
        <div id="AQUA_DEVTOOLS">';

        $output .= '<div><div style="width: 80px;">' . file_get_contents(__ROOT__ . '/Aqua.svg') . '</div></div>';

        $output .= '<div>Render: ' . self::render_time() . ' seconds</div>';

        $output .= '<div>Cache Enabled: ' . (Core::config()->general->cache?'Yes':'No') . '</div>';

        !Core::config()->general->cache or $output .= '<div>Cache ID: ' . Pearl::get_cache_id() . '</div>';

        $output .= '</div>';

        echo $output;
    }

    public static function render_time()
    {
        return substr(AQUA_END_TIME - AQUA_BEGIN_TIME, 0, 10);
    }
}