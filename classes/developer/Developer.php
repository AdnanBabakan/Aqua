<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This class will help you debug your application and access developer tools
 */

namespace Aqua;

class Developer
{
    public static function init(): void
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
                font-family: monospace;
            }
            
            #AQUA_DEVTOOLS > #AQUA_DEVTOOLS_BAR {
                display: flex;
                border-bottom: 2px solid #eeeeee;
            }
            
            #AQUA_DEVTOOLS > #AQUA_DEVTOOLS_BAR > div {
                padding: 10px;
                border-right: 2px solid #eeeeee;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 12px;
            }
            
            #AQUA_DEVTOOLS > #AQUA_DEV_TOOLS_MORE {
                width: 100%;
                height: 0;
                overflow-y: hidden;
            }
            
            #AQUA_DEVTOOLS > #AQUA_DEV_TOOLS_MORE section {
                padding: 0 50px;
            }
        </style>
        <div id="AQUA_DEVTOOLS"><div id="AQUA_DEVTOOLS_BAR">';

        $output .= '<div><div style="width: 80px;">' . file_get_contents(__ROOT__ . '/Aqua.svg') . '</div></div>';

        $output .= '<div>Render: ' . self::render_time() . ' seconds</div>';

        $output .= '<div>Cache Enabled: ' . (Core::config()->general->cache ? 'Yes' : 'No') . '</div>';

        !Core::config()->general->cache or $output .= '<div>Cache ID: ' . Pearl::get_cache_id() . '</div>';

        $output .= '<div>Used RAM: ' . memory_get_usage() / 1000000 . ' MB</div>';

        $output .= '<div>SQL Queries Executed: ' . Shark::get_executed_query_count() . '</div>';

        $output .= '<div style="cursor: pointer;" id="AQUA_MORE_DETAILS">More Details...</div>';

        $output .= '</div>';

        $output .= '<div id="AQUA_DEV_TOOLS_MORE">';

        $output .= '<h2>SQL Queries executed:</h2>';

        $output .= '<section>';

        foreach (Shark::get_raw_queries() as $raw_query) {
            $output .= $raw_query . '<br>';
        }

        $output .= '</section>';

        $output .= '</div>';

        $output .= '</div>';

        $output .= '<script>
            var isOpen = false;
            document.getElementById("AQUA_MORE_DETAILS").addEventListener("click", function() {
               if(!isOpen) {
                   isOpen = true;
                    document.getElementById("AQUA_DEV_TOOLS_MORE").style.height = "50vh";
                    document.getElementById("AQUA_DEV_TOOLS_MORE").style.padding = "20px";
                    document.getElementById("AQUA_DEV_TOOLS_MORE").style.overflowY = "auto";
               } else {
                    isOpen = false;
                    document.getElementById("AQUA_DEV_TOOLS_MORE").style.height = "0";
                    document.getElementById("AQUA_DEV_TOOLS_MORE").style.padding = "0";
                    document.getElementById("AQUA_DEV_TOOLS_MORE").style.overflowY = "hidden";
               }
            });
        </script>';
        echo $output;
    }

    public static function render_time()
    {
        return substr(AQUA_END_TIME - AQUA_BEGIN_TIME, 0, 10);
    }
}