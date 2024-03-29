GT Post Lists
=============

by Jeremy Linder
at General Things, Inc.

Introduction
------------

Wordpress has always been a fantastic system for posting timed articles (blogs, if you will). Lately, with
the addition of custom post types, Wordpress has become similarly excellent at posting any kind of item you'd
like to, with a bit of customization to make it work.

However, problems start arising when you begin to worry about displaying the content in lists. Generally, there
are great templating functions to let you loop through different posts and output them, but these have to be done
in separate templates, each particular to the posts that are being output. Often, these templates are strikingly
similar in actual layout, with the main difference being the post type, of the order. I've done, as I've seen many
as well do, which is to read from GET variables in order to figure out what you want to display, but that puts
application logic in your layout and that's a MVC no-no.

This plugin was written to address that problem. Using GT Post Lists, you'll be able to, in your post body, change
the configuration of your list. Each list is extremely customizable, giving you the ability to create different layouts
for different content types and even different "classes" of layouts for all the content type you created. 

Examples
--------

    [gt-postlist]

This will output the default output of get_posts, but unbounded by the default post # limit.

    [gt-postlist type="page"]

This will output all the posts of type "page".

    [gt-postlist type="video" size="10" parent="4" exclude="40,50"]

This will output up to 10 posts of type "video", whos parent is id #4, except for posts whos ids are 40 or 50.

I hope you get the general of idea of how it works. Now I shall list the attributes that this function looks for. Please
note that it handles these the same way get_posts handles them (as the function wraps around get_posts)

Attributes
----------

    "include" = "number, [number, number ...]"
Only show posts specified by the id(s) given
  
    "exclude" = "number, [number, number, ...]"
Only show posts that do NOT include the id(s) given
  
    "parent" = "number, [number, number, ...]"
Only show posts that have a parent whos id is given
  
    "type" = "type_slug"
Only show posts of the type given.
  
    "size" = "number"
Only show up to this number of posts
  
    "meta_key" = "key_string"
    "meta_value" = "value_string"
Only show posts that match this meta_key and meta_value combination
  
    "orderby" = "field_name"
    "order = "ASC" or "DESC"
Order by the given values in the given direction
  
    "category" = "slug or number, [slug or number, slug or number, ...]"
Only show posts with the categories given by the given slugs and/or numbers. 
NOTE: It is faster to use ids than it is to use slugs
  
