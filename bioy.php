<?php
/*
* Plugin Name: Bible in One Year
* Description: Multi-Language Bible in One Year plugin. 
* Version: 1.4
* Author: Claud Rusnac
* Author URI: http://www.srcreative.co
*/
define( 'bioy_path', plugin_dir_path( __FILE__ ));

function bioy_files(){
        wp_enqueue_style( 'bioy', plugins_url('/css/bioy.css', __FILE__), false, '1.0.0', 'all');
    }
add_action('wp_enqueue_scripts', 'bioy_files');

    // Display the Bible in One year based on language. 
    function bbioy_create($atts){ ?>

        <?php if($atts[lang] == null): //Check Language.  If not set, show error ?>
            <div class="error">Please specify a language (i.e. lang='en', lang='ro') in your shortcode.</div>
        <?php endif //End Check Language ?>

        <?php $bioy_xml_file = 'bioy_'.$atts[lang].'.xml'; ?>

        <?php if(!file_exists(bioy_path.'xml/'.$bioy_xml_file)): //Check Include File ?>
            <div class="error">I cannot find the proper language XML file.  Please verify that your file is named correctly (<?php echo $bioy_xml_file; ?>).</div>
        <?php else: ?>
            <?php $bioy_xml = simplexml_load_file(bioy_path.'xml/'.$bioy_xml_file); ?>
        <?php endif //End Check Include file ?>

        <?php //Set Variables 
            $current_day = date("j");
            $current_month = date("n");
            $biblegateway = 'http://www.biblegateway.com/passage/?search=';
            $translation = $atts[translation];
            $locale = $atts[locale];
        ?>
        
        <?php if($atts[locale] != null): //Check if Locale is set and use it ?>
            <?php setlocale(LC_ALL,$atts[locale]); ?>
        <?php endif //End Check locale ?>
        
    
        <?php if($atts[col] != null): //If Col is set, override CSS ?>
            <style>
              ul.bioy {
              columns: <?php echo $atts[col]; ?>;
              -webkit-columns: <?php echo $atts[col]; ?>;
              -moz-columns: <?php echo $atts[col]; ?>;
                }
            </style>
        <?php endif //End Col ?>
        
            <?php if($atts[display_current_month] != 'no'): //Display Current Month Check ?>
                <h2 class="bioy"><?php echo strftime("%B %Y"); ?></h2>
            <?php endif //End Display Current Month Check ?>
    
            <ul class="bioy">
                <?php foreach ($bioy_xml->children() as $verse): ?>
                    <?php if ($verse->month == $current_month): ?>
                         <li<?php if ($verse->day == $current_day): ?> class="current-day" <?php endif; ?>><span class="day-badge"><?php echo $verse->day; ?></span> <a href="<?php echo $biblegateway.$verse->verse; ?>&version=<?php echo $translation; ?>&interface=print" target="_blank"><?php echo $verse->verse; ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>    
            </ul>
    
    <?php }
    
add_shortcode('bioy', 'bbioy_create');

?>
