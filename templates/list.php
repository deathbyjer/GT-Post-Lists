<ul class="gt-postlist<?php if ($this->list_id) print "list_id-" . $this->list_id; ?>">
<?php foreach ($this->posts as $post): ?>
  <li class="post-<?php print $post->ID; ?>"><?php $this->do_template(); ?></li>
<?php endforeach; ?>
</ul>