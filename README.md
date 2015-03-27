# samforum

I have been working on this forum for a while, thought of adding couple premium features and sell it but due to lack of time I wont be able to finish it - so here, I am going to release what has been done, for free. Forum has been made with general security in mind, all queries in uses PDO and the best is that I have written all the code in Object Oriented style which will give you ability to extend of easily make modifications with ease.

##Functionality:
- Registration
- Login
- Captcha
- Recover password
- Change password
- Chatbox
- Search
- Post threads
- Post replies
- Edit threads(user)
- Create category(admin)
- Edit category(admin)
- Delete categories(admin)
- Edit threads


##Functionality that may be added in future.
- Mentioning system
- Private messaging
- Avatar
- Status update
- Design

##How to guide.
  Open connection_to_db.php file and write down your dataabse details, hostname, username, password and databse name.
  Change site_name name in form_registration_class.php on line 110 to your website/forum link, and "from" to your website's name, for example "sam forums".

There is no need to import database or table, I have written all the queries, that should make required tables for you. Just create a database named "forum".
