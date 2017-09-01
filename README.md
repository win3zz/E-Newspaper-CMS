# E-Newspaper-CMS
Light weight CMS for upload and manage Newspaper (PDF)

### Usage
- User can use this widget for websites which need to daily upload their Epaper (PDF) or other type of paper to public download.
- This is more secure with static password mechanism. 
- You can change login username or password by editing 'login.php' file.
- Login Password is encrypted in MD5 secure hashing algorithm. 

create following table in database
```sql
CREATE TABLE `epaper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) 
```
Now, you just need to change database credentials in 'admin.php' file.

Enjoy. 

### Designed and Developed by 
Bipin Jitiya, M.Sc. (IT).
