<?php
/**
 * admin init
 */
add_action('admin_init', 'anxpsf_admin_init');

function anxpsf_admin_init() {
    // register style
    wp_register_style('anxpsf-style', plugins_url('assets/css/anxpsf-style.css', __FILE__));
    
    // register script
    wp_register_script('anxpsf-script', plugins_url('assets/js/anxpsf-script.js', __FILE__));
}

/**
 * admin styles
 */
function anxpsf_admin_styles() {
    wp_enqueue_style('anxpsf-style');
}

add_action('admin_print_styles-widgets.php', 'anxpsf_admin_styles');

/**
 * admin scripts
 */
function anxpsf_admin_scripts() {
    wp_enqueue_script('anxpsf-script');
}

add_action('admin_print_scripts-widgets.php', 'anxpsf_admin_scripts');

/**
 * widget twitter feed
 */
class ANXP_Twitter_Feed_Widget extends WP_Widget {
    function ANXP_Twitter_Feed_Widget() {
        $widget_options = array(
            'classname' => 'anxp-twitter-feed',
            'description' => ''
        );
        
        parent::WP_Widget('anxp-twitter-feed', 'ANXP Twitter Feed', $widget_options);
    }
    
    public function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = $instance['title'];
        $consumer_key = $instance['consumer_key'];
        $consumer_key_decrypt = encrypt_decrypt('decrypt', $consumer_key);
        $consumer_secret = $instance['consumer_secret'];
        $consumer_secret_decrypt = encrypt_decrypt('decrypt', $consumer_secret);
        $access_token = $instance['access_token'];
        $access_token_decrypt = encrypt_decrypt('decrypt', $access_token);
        $access_token_secret = $instance['access_token_secret'];
        $access_token_secret_decrypt = encrypt_decrypt('decrypt', $access_token_secret);
        $username = $instance['username'];
        $limit = $instance['limit']; ?>
        
        <div class="widget-content">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" type="text" value="<?php echo $title; ?>" />
            </p>
            <!-- -->
            <p>
                <label for="<?php echo $this->get_field_id('consumer_key'); ?>">Consumer Key:</label>
                <input id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>" class="widefat" type="text" value="<?php echo $consumer_key_decrypt; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('consumer_secret'); ?>">Consumer Secret:</label>
                <input id="<?php echo $this->get_field_id('consumer_secret'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>" class="widefat" type="text" value="<?php echo $consumer_secret_decrypt; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('access_token'); ?>">Access Token:</label>
                <input id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" class="widefat" type="text" value="<?php echo $access_token_decrypt; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('access_token_secret'); ?>">Access Token Secret:</label>
                <input id="<?php echo $this->get_field_id('access_token_secret'); ?>" name="<?php echo $this->get_field_name('access_token_secret'); ?>" class="widefat" type="text" value="<?php echo $access_token_secret_decrypt; ?>" />
            </p>
            <!-- -->
            <p>
                <label for="<?php echo $this->get_field_id('username'); ?>">Username:</label>
                <input id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" class="widefat" type="text" value="<?php echo $username; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('limit'); ?>">Number of tweets to show:</label><br />
                <input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" class="tiny-text" type="number" value="<?php echo $limit; ?>" />
            </p>
            <p>
                <a class="anxp-widget-footer" href="https://www.anxiouspenguin.com/" title="Anxious Penguin" target="_blank"><span>Anxious Penguin</span></a>
            </p>
        </div>
    <?php }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = $new_instance['title'];
        //$instance['consumer_key'] = $new_instance['consumer_key'];
        $instance['consumer_key'] = encrypt_decrypt('encrypt', $new_instance['consumer_key']);
        //$instance['consumer_secret'] = $new_instance['consumer_secret'];
        $instance['consumer_secret'] = encrypt_decrypt('encrypt', $new_instance['consumer_secret']);
        //$instance['access_token'] = $new_instance['access_token'];
        $instance['access_token'] = encrypt_decrypt('encrypt', $new_instance['access_token']);
        //$instance['access_token_secret'] = $new_instance['access_token_secret'];
        $instance['access_token_secret'] = encrypt_decrypt('encrypt', $new_instance['access_token_secret']);
        $instance['username'] = $new_instance['username'];
        $instance['limit'] = $new_instance['limit'];
        
        return $instance;
    }
    
    public function widget($args, $instance) {
        extract($args);
        
        $title = apply_filters('widget_title', $instance['title']);
        $consumer_key = apply_filters('widget_title', $instance['consumer_key']);
        $consumer_key = encrypt_decrypt('decrypt', $consumer_key);
        $consumer_secret = apply_filters('widget_title', $instance['consumer_secret']);
        $consumer_secret = encrypt_decrypt('decrypt', $consumer_secret);
        $access_token = apply_filters('widget_title', $instance['access_token']);
        $access_token = encrypt_decrypt('decrypt', $access_token);
        $access_token_secret = apply_filters('widget_title', $instance['access_token_secret']);
        $access_token_secret = encrypt_decrypt('decrypt', $access_token_secret);
        $username = apply_filters('widget_title', $instance['username']);
        $limit = apply_filters('widget_title', $instance['limit']);
        
        echo $args['before_widget'];
            echo ($title) ? $args['before_title'] . $title . $args['after_title'] : '';
            
            if($consumer_key AND $consumer_secret AND $access_token AND $access_token_secret AND $username AND $limit)
            {
                echo '<ul>';
                    $this->twitter_tweets_by_user($consumer_key, $consumer_secret, $access_token, $access_token_secret, $username, $limit);
                echo '</ul>';
            }
            else
            {
                echo '<p>Uh oh, you forgot to configure the <span style="font-weight: bold;">ANXP Twitter Feed</span> widget!</p>';
            }
            
        echo $args['after_widget'];
    }
    
    private function twitter_tweets_by_user($consumer_key, $consumer_secret, $access_token, $access_token_secret, $username, $limit) {
        $cache = ANXPSF_DIR . 'cache/twitter.txt';
        
        clearstatcache();
        
        if(filemtime($cache) < (time() - 3600)) {
    		require ANXPSF_DIR . 'twitteroauth/TwitterOAuth.php';
            
            define('CONSUMER_KEY', $consumer_key);
            define('CONSUMER_SECRET', $consumer_secret);
            define('ACCESS_TOKEN', $access_token);
            define('ACCESS_TOKEN_SECRET', $access_token_secret);
            
            $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
            $twitter->ssl_verifypeer = FALSE;
            $tweets_data = $twitter->get('statuses/user_timeline', array('screen_name' => $username, 'exclude_replies' => 'true', 'include_rts' => 'true', 'count' => $limit));
            $tweets = '';
            
            if(!empty($tweets_data)) {
                foreach($tweets_data as $data) {
                    //$tweetText = $data['text'];
                    //$tweetText = preg_replace("/(http://|(www.))(([^s<]{4,68})[^s<]*)/", '<a href="http://$2$3" target="_blank">$1$2$4</a>', $tweetText); // linkify links
                    //$tweetText = preg_replace("/@(w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $tweetText); // linkify mentions
                    //$tweetText = preg_replace("/#(w+)/", '<a href="http://search.twitter.com/search?q=$1" target="_blank">#$1</a>', $tweetText); // linkify tags
                    
                    //$tweets .= '<li><a class="flaticon-twitter1" href="https://twitter.com/' . $username . '/status/' . $data['id_str'] . '" target="_blank"><span>@' . $username . ':</span> ' . $data['text'] . '</a></li>';
                    
                    $date = DateTime::createFromFormat('D M d H:i:s O Y', $data['created_at']);
                    $date_fix = sprintf( '%s ' . __( 'ago' ), human_time_diff($date->format('U')));
                    
                    $tweets .= '<li>
                        <a href="https://twitter.com/' . $username . '/status/' . $data['id_str'] . '" target="_blank">
                            <span class="tweet">
                                <span class="username">@' . $username . ':</span> ' . $data['text'] . '
                            </span>
                            <span class="date">' . $date_fix . '</span>
                        </a>
                    </li>';
                }
                
                $file = fopen($cache, 'w');
                
        		fwrite($file, $tweets);
        		fclose($file);
            }
        } else {
            $tweets = file_get_contents($cache);
        }
        
    	echo $tweets;
    }
}

add_action('widgets_init', create_function('', 'register_widget("ANXP_Twitter_Feed_Widget");'));

/**
 * widget facebook feed
 */
class ANXP_Facebook_Feed_Widget extends WP_Widget {
    function ANXP_Facebook_Feed_Widget() {
        $widget_options = array(
            'classname' => 'anxp-facebook-feed',
            'description' => ''
        );
        
        parent::WP_Widget('anxp-facebook-feed', 'ANXP Facebook Feed', $widget_options);
    }
    
    public function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = $instance['title'];
        $access_token = $instance['access_token'];
        $access_token = encrypt_decrypt('decrypt', $access_token);
        $user_id = $instance['user_id'];
        $limit = $instance['limit']; ?>
        
        <div class="widget-content">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" type="text" value="<?php echo $title; ?>" />
            </p>
            <!-- -->
            <p>
                <label for="<?php echo $this->get_field_id('access_token'); ?>">Access Token:</label>
                <input id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" class="widefat" type="text" value="<?php echo $access_token; ?>" />
            </p>
            <!-- -->
            <p>
                <label for="<?php echo $this->get_field_id('user_id'); ?>">User ID:</label>
                <input id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" class="widefat" type="text" value="<?php echo $user_id; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('limit'); ?>">Number of posts to show:</label><br />
                <input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" class="tiny-text" type="number" value="<?php echo $limit; ?>" />
            </p>
            <p>
                <a class="anxp-widget-footer" href="https://www.anxiouspenguin.com/" title="Anxious Penguin" target="_blank"><span>Anxious Penguin</span></a>
            </p>
        </div>
    <?php }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = $new_instance['title'];
        //$instance['access_token'] = $new_instance['access_token'];
        $instance['access_token'] = encrypt_decrypt('encrypt', $new_instance['access_token']);
        $instance['user_id'] = $new_instance['user_id'];
        $instance['limit'] = $new_instance['limit'];
        
        return $instance;
    }
    
    public function widget($args, $instance) {
        extract($args);
        
        $title = apply_filters('widget_title', $instance['title']);
        $access_token = apply_filters('widget_title', $instance['access_token']);
        $access_token = encrypt_decrypt('decrypt', $access_token);
        $user_id = apply_filters('widget_title', $instance['user_id']);
        $limit = apply_filters('widget_title', $instance['limit']);
        
        echo $args['before_widget'];
            echo ($title) ? $args['before_title'] . $title . $args['after_title'] : '';
            
            if($access_token AND $user_id AND $limit)
            {
                echo '<ul>';
                    $this->facebook_feed_by_user($access_token, $user_id, $limit);
                echo '</ul>';
            }
            else
            {
                echo '<p>Uh oh, you forgot to configure the <span style="font-weight: bold;">ANXP Facebook Feed</span> widget!</p>';
            }
            
        echo $args['after_widget'];
    }
    
    private function facebook_feed_by_user($access_token, $user_id, $limit) {
        $url = 'https://graph.facebook.com/v2.4/' . $user_id . '/posts?access_token=' . $access_token . '&fields=id,message,link&limit=' . $limit;
        $cache = ANXPSF_DIR . 'cache/facebook.txt';
        
        clearstatcache();
        
        if(filemtime($cache) < (time() - 3600)) {
            $ch = curl_init($url);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $output = curl_exec($ch);
            
            curl_close($ch); 
            
            $data = json_decode($output);
            $items = '';
            $count = 1;
    
            if(!isset($data->error)) {
                foreach($data->data as $item) {
                    $item_description = (!isset($item->message)) ? 'No description.' : strip_tags($item->message);
                    //$item_description = mb_strimwidth($item_description, 0, 137, '...');
                    
                    $items .= '<li><a href="' . $item->link . '" target="_blank">' . $item_description . '</a></li>';
                    
                    if($count == $limit) { break; }
                    
                    $count ++;
                }
                
                $file = fopen($cache, 'w');
                
                fwrite($file,$items);
                fclose($file);
            }
        } else {
            $items = file_get_contents($cache);
        }
        
        echo $items;
    }
}

add_action('widgets_init', create_function('', 'register_widget("ANXP_Facebook_Feed_Widget");'));

/**
 * widget instagram feed
 */
class ANXP_Instagram_Feed_Widget extends WP_Widget {
    function ANXP_Instagram_Feed_Widget() {
        $widget_options = array(
            'classname' => 'anxp-instagram-feed',
            'description' => ''
        );
        
        parent::WP_Widget('anxp-instagram-feed', 'ANXP Instagram Feed', $widget_options);
    }
    
    public function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = $instance['title'];
        $client_id = $instance['client_id'];
        $client_id = encrypt_decrypt('decrypt', $client_id);
        $user_id = $instance['user_id'];
        $limit = $instance['limit']; ?>
        
        <div class="widget-content">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" type="text" value="<?php echo $title; ?>" />
            </p>
            <!-- -->
            <p>
                <label for="<?php echo $this->get_field_id('client_id'); ?>">Client ID:</label>
                <input id="<?php echo $this->get_field_id('client_id'); ?>" name="<?php echo $this->get_field_name('client_id'); ?>" class="widefat" type="text" value="<?php echo $client_id; ?>" />
            </p>
            <!-- -->
            <p>
                <label for="<?php echo $this->get_field_id('user_id'); ?>">User ID:</label>
                <input id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" class="widefat" type="text" value="<?php echo $user_id; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('limit'); ?>">Number of photos to show:</label><br />
                <input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" class="tiny-text" type="number" value="<?php echo $limit; ?>" />
            </p>
            <p>
                <a class="anxp-widget-footer" href="https://www.anxiouspenguin.com/" title="Anxious Penguin" target="_blank"><span>Anxious Penguin</span></a>
            </p>
        </div>
    <?php }
    
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = $new_instance['title'];
        //$instance['client_id'] = $new_instance['client_id'];
        $instance['client_id'] = encrypt_decrypt('encrypt', $new_instance['client_id']);
        $instance['user_id'] = $new_instance['user_id'];
        $instance['limit'] = $new_instance['limit'];
        
        return $instance;
    }
    
    public function widget($args, $instance)
    {
        extract($args);
        
        $title = apply_filters('widget_title', $instance['title']);
        $client_id = apply_filters('widget_title', $instance['client_id']);
        $client_id = encrypt_decrypt('decrypt', $client_id);
        $user_id = apply_filters('widget_title', $instance['user_id']);
        $limit = apply_filters('widget_title', $instance['limit']);
        
        echo $args['before_widget'];
            echo ($title) ? $args['before_title'] . $title . $args['after_title'] : '';
            
            if($client_id AND $user_id AND $limit)
            {
                echo '<ul>';
                    $this->ig_photos_by_user($client_id, $user_id, $limit);
                echo '</ul>';
            }
            else
            {
                echo '<p>Uh oh, you forgot to configure the <span style="font-weight: bold;">ANXP Instagram Feed</span> widget!</p>';
            }
            
        echo $args['after_widget'];
    }
    
    private function ig_photos_by_user($client_id, $user_id, $limit)
    {
        $url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?client_id=' . $client_id . '&count=' . $limit .'';
        $cache = ANXPSF_DIR . 'cache/instagram.txt';
        
        clearstatcache();
        
        if(filemtime($cache) < (time() - 3600)) {
    		$ch = curl_init($url);
            
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    		curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            
    		$output = curl_exec($ch);
            
    		curl_close($ch); 
            
    		$media = json_decode($output);
    		$photos = '';
            $count = 1;
            
            if(!isset($media->error_type))
            {
                foreach($media->data as $data)
                {
                    //thumbnail
                    $photos .= '<li><a href="' . $data->link . '" target="_blank"><img src="' . $data->images->low_resolution->url . '" alt="" /></a></li>';
                    
                    if($count == $limit) { break; }
                    
                    $count ++;
                }
                
                $file = fopen($cache, 'w');
                
                fwrite($file,$photos);
                fclose($file);
            }
        }
        else
        {
            $photos = file_get_contents($cache);
        }
        
    	echo $photos;
    }
}

add_action('widgets_init', create_function('', 'register_widget("ANXP_Instagram_Feed_Widget");'));

/**
 * encrypt and decrypt
 */
function encrypt_decrypt($action, $string)
{
    $output = FALSE;
    
    // RandomKeygen (https://randomkeygen.com/) is an easy way to randomly generate keys like below
    $encrypt_method = "AES-256-CBC";
    $secret_key = '3D4855D34B42F5669882CE828DD25';
    $secret_iv = '7FCD118F745E1D4CADC6D37FAF931';
    
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
    if($action == 'encrypt')
    {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    elseif($action == 'decrypt')
    {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    
    return $output;
}
?>