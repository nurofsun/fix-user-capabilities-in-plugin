# Why wp_get_current_user undefined ?

An example simple plugin deleting post on frontend, with checking user capabilities.

It's because pluggable.php haven't been loaded and when you call this `current_user_can` function has $current_user variable assigned by value of wp_get_current_user function. error will occurs.

so, if you want to fix this problem,just wrap this `current_user_can` on a function use hook such as `plugins_loaded` or `init`

Follow me on [Twitter](https://twitter.com/noorofsun)





