<?php
/**
 * Template for YiiDisqusWidget
 *
 * @author Anton Kucherov <idexter.ru@gmail.com>
 * @link http://idexter.ru/
 * @copyright 2013 idexter.ru
 */
?>
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = '<?php echo $shortname; ?>'; // required: replace example with your forum shortname

    <?php if($identifier!=''): ?>
        var disqus_identifier = '<?php echo $identifier; ?>';
    <?php endif; ?>

    <?php if($title!=''): ?>
        var disqus_title = '<?php echo $title; ?>';
    <?php endif; ?>

    <?php if($url!=''): ?>
        var disqus_url = '<?php echo $url; ?>';
    <?php endif; ?>

    <?php if($category_id!=''): ?>
        var disqus_category_id = '<?php echo $category_id; ?>';
    <?php endif; ?>

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>