# MySQL_Project_Product_Tracking_System
I have several header functions in php files, which follow my own route. 
I submitted file name is project-WenyiLiu, all my php files are stored in: 
project-WenyiLiu/src folder Under C:/php folder.

So, my header location route is: 
```
Localhost:8080/project-WenyiLiu/src/index.php
```
The header function is used to rollback to information page before user has entered all required items. Or direct to error massage page can’t find the machine or app ID

If you want to change the route, you can find the header function at (they all at the end of the file):
1.	indexResult.php 			line 131
2.	appResult.php 			line 73 and line 130
3.	hardwareResult.php 			line 96 and line 203
If you need to use search to find the function, please search: project-WenyiLiu

--------------------------------------------------------------------------------------------------------
At the begining, it requires you to enter the customer info, e.g. Company name, contact name and phone number.
If you alreay is a customer in the database, your information will be shown on the next page, otherwise, you will be assigned a unique number.
Then you will need to choose whether customer has bought a hardware or software only.
<p align="center">
<img src= "https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/1.png" align="middle"/>
</p>

***
For new customer:
<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/2.png" align="middle"/>
</p>

****
For exist customer:
<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/8.png" align="middle"/>
</p>
<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/3.png" align="middle"/>
</p>

***

If the hardware's manufactor and model is matched, it will return the correct id and insert the new record into database. Otherwise it will show error message and return to an error page.

<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/4.png" align="middle"/>
</p>

***

Then it requires you to enter the information of software. The same procudures as hardware.
<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/5.png" align="middle"/>
</p>

***

There you go! You have successfully added a new record into database.
<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/6.png" align="middle"/>
</p>

-----------------------------------------
Here are some error pages if the infomation is wrong:
<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/7.png" align="middle"/>
</p>

<p align="center">
  <img src="https://github.com/cravenbrave/MySQL_Project_Product_Tracking_System/blob/4d31573b165a5c56bbe1dd2412d4fade890a4d69/9.png" align="middle"/>
</p>
