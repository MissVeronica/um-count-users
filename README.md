# UM Count Users
Shortcode ```[um_count_users_custom]``` to list number of users with same meta_values for a meta_key

Supported UM fields:
1. Dropdown
2. Multi-select
3. Radio
4. Checkbox

Examples with a list of number of users from ```country``` and sorting options with Title and Subtitle
```
[um_count_users_custom meta_key="country"]

[um_count_users_custom meta_key="country" sort="meta_value"]
[um_count_users_custom meta_key="country" sort="count-asc"]    sort count ascending
[um_count_users_custom meta_key="country" sort="count-desc"]   sort count descending

[um_count_users_custom meta_key="country" sort="count-desc"]title#subtitle[/um_count_users_custom]   
[um_count_users_custom meta_key="country" sort="count-desc"]title %d text#subtitle %d text[/um_count_users_custom] 

# separator for Title/Subtitle
title %d text: where %d is number of users if present
subtitle %d text: where %d is number of users with empty meta_value if present and number of users not zero
```
## Updates
Current version 1.0.0
## Installation
Download the zip file and install as a WP Plugin, activate the plugin.
