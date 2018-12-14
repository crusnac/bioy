<?php
/*
* Plugin Name: Bible in One Year
* Description: Romanian / English Bible in One Year plugin. 
* Version: 1.0
* Author: Claud Rusnac
* Author URI: http://www.srcreative.co
*/

?>
 <style>

     #bioy {
         width: 100%;
     }
                            
ul.bioy {
    width: 100%;  
  list-style: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  -webkit-column-gap: 20px; /* Chrome, Safari, Opera */
  -moz-column-gap: 20px; /* Firefox */
  column-gap: 20px;
    column-width: auto;
}

     ul.bioy li {
         padding: 10px;
     }
     
ul.bioy li.current-day {
    font-weight: 700;
}
     
            
.day-badge {
    display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    background-color: #ccc;
    border-radius: 10px;
}

</style>

<div id="bioy">
<?php // Display the Bible in One year based on language. 
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
            define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

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
             
            define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
         
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
</div>