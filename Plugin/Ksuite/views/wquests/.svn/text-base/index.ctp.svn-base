<script>
 window.fbAsyncInit = function() {
      FB.init({
          appId   : '<?php echo $user['appid']; ?>',
          session : <?php echo json_encode($user['session']); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
       });

      // whenever the user logs in, we refresh the page
      FB.Event.subscribe('auth.login', function() {
              window.location.reload();
          });
  };

(function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
}());
</script>

<fb:dashboard>
     <fb:action href="listing">Display your Webquests</fb:action>
     <fb:action href="help">Help</fb:action>
     <fb:create-button href="add">Add new Webquest</fb:create-button>
</fb:dashboard>

<style type="text/css">
     .container { padding:10px; }
     .centered{margin:10px auto;}
     .hello{margin:10px auto;font-size:14pt;font-weight:bold;}
</style>
<div id="fb-root"></div>

<?php
#echo $user['login'];

echo $html->para('hello', 'Hello '.$user['me']['name'].'!');
#echo $html->image($pic[0]['pic_square'], array('alt'=>$name[0]['first_name'], 'title'=>$name[0]['first_name']));
echo $html->para('centered', $html->image('http://trac.chipotle-software.com/karamelo_01.jpg', array('alt'=>'Karamelo', 'title'=>'Karamelo')));
echo $html->para(Null, 'Karamelo is an e-Learning, Web 2.0 platform which provides both tools and resources to improve the teaching-learning process.');
echo $html->para(Null,'In this app you can create Webquests and invite your students to answer them as homework. Please visit <a href="help">"What is a webquest?"</a> section to learn more about Webquests. Create a new Webquest  <a href="add">here</a> or <a href="listing">see your webquest</a>.');

?>

<fb:bookmark />

<br /><br /><br />
<fb:comments xid="karamelo_comments" showform="true" canpost="true" candelete="true">
     <fb:title>Talk about Webquest</fb:title>
</fb:comments>
