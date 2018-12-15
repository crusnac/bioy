<?php
/*
* Plugin Name: Bible in One Year
* Description: Romanian / English Bible in One Year plugin. 
* Version: 1.1
* Author: Claud Rusnac
* Author URI: http://www.srcreative.co
*/
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

function add_my_css_and_my_js_files(){
        //wp_enqueue_script('your-script-name', $this->urlpath  . '/your-script-filename.js', array('jquery'), '1.2.3', true);
        wp_enqueue_style( 'bioy', plugins_url('/css/bioy.css', __FILE__), false, '1.0.0', 'all');
    }
    
add_action('wp_enqueue_scripts', "add_my_css_and_my_js_files");

 // Display the Bible in One year based on language. 
    function bbioy_create($atts){ ?>

        <?php if($atts[lang] == null): //Check Language ?>
            
            <div class="error">Please specify a language (lang='en' or lang='ro') in your shortcode.</div>
        
        <?php endif //End Check Language ?>

        <?php if($atts[col] != null): //Col ?>
            <style>
                ul.bioy {
              columns: <?php echo $atts[col]; ?>;
              -webkit-columns: <?php echo $atts[col]; ?>;
              -moz-columns: <?php echo $atts[col]; ?>;
                }
            </style>
            <?php else: ?>
            <style>
                ul.bioy {
                  columns: 3;
                  -webkit-columns: 3;
                  -moz-columns: 3;
                }
            </style>

        <?php endif //End Col ?>
                        
         <?php if($atts[lang] == "en"): //English Language ?>  
         <?php setlocale(LC_ALL ,"en_EN"); date_default_timezone_set('America/Los_Angeles'); 

            if (file_exists(MY_PLUGIN_PATH.'xml/360-reading-plan-en.xml')) {
                $xml = simplexml_load_file(MY_PLUGIN_PATH.'xml/360-reading-plan-en.xml');
            } else {
                exit('Failed to open XML File.');
            }
                                 
            //Set Variables
            $current_day = date("j");
            $current_month = date("n");
            $biblegateway = 'http://www.biblegateway.com/passage/?search=';
            $translation = $atts[translation];
        ?>
        

         	<h2 class="bioy"><?php echo strftime("%B %Y"); ?></h2>
    
            <ul class="bioy">
                <?php foreach ($xml->children() as $verse): ?>
                    <?php if ($verse->month == $current_month): ?>
                         <li<?php if ($verse->day == $current_day): ?> class="current-day" <?php endif; ?>><span class="day-badge"><?php echo $verse->day; ?></span> <a href="<?php echo $biblegateway.$verse->verse; ?>&version=<?php echo $translation; ?>&interface=print" target="_blank"><?php echo $verse->verse; ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>    
            </ul>
        
         <?php endif //End English ?>
         
         
         <?php if($atts[lang] == "ro"): //Romanian Language ?>
         <?php setlocale(LC_ALL ,"ro_RO"); date_default_timezone_set('America/Los_Angeles'); 
                      
            if (file_exists(MY_PLUGIN_PATH.'xml/360-reading-plan-en.xml')) {
                $xml = simplexml_load_file(MY_PLUGIN_PATH.'xml/360-reading-plan-ro.xml');

            } else {
                exit('Failed to open XML File.');
            }
                                 
            //Set Variables
            $current_day = date("j");
            $current_month = date("n");
            $biblegateway = 'http://www.biblegateway.com/passage/?search=';
            $translation = $atts[translation];

         ?>
            
         
         	<h2 class="bioy"><?php echo strftime("%B %Y"); ?></h2>
          
            <ul class="bioy">
                <?php foreach ($xml->children() as $verse): ?>
                    <?php if ($verse->month == $current_month): ?>
                         <li<?php if ($verse->day == $current_day): ?> class="current-day" <?php endif; ?>><span class="day-badge"><?php echo $verse->day; ?></span> <a href="<?php echo $biblegateway.$verse->verse; ?>&version=<?php echo $translation; ?>&interface=print" target="_blank"><?php echo $verse->verse; ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>    
            </ul>
                            
            
         <?php endif //End Romanian ?>
    
    
    <?php }
    
add_shortcode('bioy', 'bbioy_create');

?>
