
            <?php 
                $i = 0;   

                if(!empty($contents)) 
                {
                    foreach ($contents as $skey => $svalue) 
                    { //print_r($svalue);
                        $i++; ?>
                    <?php
                        switch ($svalue['type']) {
                            case 'image':
                                echo '<img src="'.$svalue['path'].'" width="'.$svalue['wid'].'" height="'.$svalue['hit'].'" style="z-index:'.$i.'; position: absolute;top:'.$svalue['tm'].';left:'.$svalue['lm'].'">';
                                break;
                            case 'video':
                                echo '<video   height='.$svalue['hit'].'; width='.$svalue['wid'].'; style=" z-index:'.$i.'; position: absolute;top:'.$svalue['tm'].'; left:'.$svalue['lm'].'";  autoplay=""; loop="loop"; muted="muted"><source src="'.$svalue['path'].'" type="video/mp4"><source src="'.$svalue['path'].'" type="video/ogg">Your browser does not support the video tag.</video>';
                                break;
                             case 'html':
                                echo '<p><span height='.$svalue['hit'].'; width='.$svalue['wid'].'; style=" z-index:'.$i.'; position: absolute; top:'.$svalue['tm'].'; left:'.$svalue['lm'].' "><span style="color: rgb(255, 0, 0);">'.$svalue['html_data'].'</span></span></p>';
 
                                break;
                            case 'marquee':
                                echo '<marquee  width='.$svalue['wid'].';  height='.$svalue['hit'].'; style=" z-index:'.$i.'; position:absolute;top:'.$svalue['tm'].'; left:'.$svalue['lm'].' ";align="bottom";loop="-1";scrolldelay="1" ; behavior="scroll"; direction="left">'.$svalue['marquee_data'].'</marquee>';
                            default:
                                break;
                        }
                    }
                }
?> 

          
