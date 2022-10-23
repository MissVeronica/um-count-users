# UM Count Users
Shortcode ```[count_users_custom]``` to list number of users with same meta_values for a meta_key

Examples with a list of number of users from ```country``` and sorting options with Title and Subtitle
```
[count_users_custom meta_key="country"]
[count_users_custom meta_key="country" sort="meta_value"]
[count_users_custom meta_key="country" sort="count-asc"]    sort count ascending
[count_users_custom meta_key="country" sort="count-desc"]   sort count descending

[count_users_custom meta_key="country" sort="count-desc"]title#subtitle[/count_users_custom]   
[count_users_custom meta_key="country" sort="count-desc"]title %d text#subtitle %d text[/count_users_custom] 

# separator for Title/Subtitle
title %d text: where %d is number of users if present
subtitle %d text: where %d is number of users with empty meta_value if present and number of users not zero
```
## Installation
Download the zip file and install as a WP Plugin, activate the plugin.
