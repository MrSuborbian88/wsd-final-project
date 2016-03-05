You’re sick of MorningMail being filled with news you don’t care about and you’re going to fix it with
web science stuff.
Tasks
1. Keep track of who clicks on which headlines by building a service that takes a userID and an
article’s URL
suggest that RPI users login using CAS
identify un-authenticated users with a cookie that never expires
2. Using MorningMail’s RSS feed, create a page that displays morning mail content
You should cache the content locally
In absence of other data, your site should output the rss feed items in their native order
Given data, your site should provide the most relevant items on the top of the page
Clicking a headline on your site should cause the site to record that the link was clicked + send
the user to the site in question
Display a list linked recently clicked by the user
3. Cluster similar users based on their clicking history
4. Order articles by most frequently clicked (within a given cluster)