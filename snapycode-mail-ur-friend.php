<?php
/*
Plugin Name: Snapycode Mail Ur Friend
Plugin URI: http://snapycode.com
Description: A plugin to send mail to your friend
Version: 1.0
Author: Snapycode
Author URI: http://snapycode.com
License: GPLv2
*/

class SnapycodeMailFriend extends WP_Widget
{
  
  function SnapycodeMailFriend()
  {
    $widget_ops = array('classname' => 'SnapycodeMailFriend', 'description' => 'Send a mail to your Friend' );
    $this->WP_Widget('SnapycodeMailFriend', 'Snapycode mail ur friend', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'message' => '',  'security' => '', 'question' => '', 'answar' => '') );
    $title = $instance['title'];
	$message = $instance['message'];
	$security = $instance['security'];
	$question = empty($instance['question'])? 'How many wings does a fly have?':$instance['question'];
	$answar = empty($instance['answar'])? '2':$instance['answar'];
	
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  
  <p><label for="<?php echo $this->get_field_id('message'); ?>">Mail Format: <br/><textarea id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" rows="5" cols="30">
<?php echo attribute_escape($message); ?>
</textarea></label></p>

<p>
<input type="checkbox" id="<?php echo $this->get_field_id('security'); ?>" name="<?php echo $this->get_field_name('security'); ?>" <?php if($security == '2'){echo 'checked="checked"';} ?> value="2" /> Enable Security Question?<br />
</p>


<p><label for="<?php echo $this->get_field_id('question'); ?>">Security Question: <input class="widefat" id="<?php echo $this->get_field_id('question'); ?>" name="<?php echo $this->get_field_name('question'); ?>" type="text" value="<?php echo attribute_escape($question); ?>" /></label></p>

<p><label for="<?php echo $this->get_field_id('answar'); ?>">Answer: <input class="widefat" id="<?php echo $this->get_field_id('answar'); ?>" name="<?php echo $this->get_field_name('answar'); ?>" type="text" value="<?php echo attribute_escape($answar); ?>" /></label></p>

<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['message'] = $new_instance['message'];
	$instance['security'] = $new_instance['security'];
	$instance['question'] = $new_instance['question'];
	$instance['answar'] = $new_instance['answar'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : $instance['title'];
	$message = empty($instance['message']) ? '' :  $instance['message'];
	$security = empty($instance['security']) ? '' :  $instance['security'];
	
	$question = empty($instance['question']) ? '' :  $instance['question'];
	$answar = empty($instance['answar']) ? '' :  $instance['answar'];
 
    if (!empty($title))
      {
		  //echo $before_title . $title . $after_title;
	  }
 
    // WIDGET CODE GOES HERE
    echo "<h1>$title</h1>";
 	//echo $name;
   // echo $after_widget;
	
	//echo '<pre>'; print_r($instance);
	$css = plugins_url( 'snapycode-mail-ur-friend/css/style.css');
	session_start();
	
	$now = time(); 
	if($now > $_SESSION['expire'])
    {
        session_destroy();
	}
	
	?>
     <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>" />
     
     
    	<form name="ask" method="post" action="<?php echo plugins_url('snapycode-mail-ur-friend/send.php'); ?>">
       		<div id="inputArea">
            	<span id="snapymsg"><?php echo $_SESSION['snapycodesendmailmsg']; ?></span><br/>
                
                <label for="txtName">Your Name</label>
                <input id="Text16" required="true" type="text" name="ur_name"/>
                <label for="txtEmail">Your Email</label>
                <input id="Text17" required="true" type="text" name="ur_mail"/>
                
                <label for="txtName">Friend Name</label>
                <input id="Text16" required="true" type="text" name="fr_name"/>
                <label for="txtEmail">Friend's Email</label>
                <input id="Text17" required="true" type="text" name="fr_mail"/>
                
                <label for="txtWebsite">Subject</label>
                <input id="Text18" required="true" type="text" name="subject"/>
                <label for="txtComment">Message</label>
                <textarea id="Textarea6" required="true" rows="4" cols="30" name="mail_body"></textarea>
                <?php if($security == 2){ ?>
					
                    <?php echo '<p>'.$question.'<br/>'; ?>
                    <label for="txtEmail">Your Answer</label>
                    <input id="Text17" type="text" name="ur_ans"/></p>
                    <input type="hidden" name="rans" value="<?php echo $answar; ?>" />
				<?php }?>
                <input type="submit" name="submit" value="Send Mail" />
                
       	  </div>
        </form>

 <?php wp_enqueue_script("jquery"); ?>
    <script type="text/javascript">
        $(document).ready(function(){
	    $("input, textarea").addClass("idle");
		 $("input").addClass("idle");
            $("input, textarea").focus(function(){
                $(this).addClass("activeField").removeClass("idle");
	    }).blur(function(){
                $(this).removeClass("activeField").addClass("idle");
	    });
        });
    </script>

<?php
	
	//End widget code
  }
 
}

add_action( 'widgets_init', create_function('', 'return register_widget("SnapycodeMailFriend");') );?>