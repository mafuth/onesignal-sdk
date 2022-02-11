# ONESIGNAL SDK
### Installation

Clone the repo
   ```sh
   git clone https://github.com/mafuth/onesignal-sdk.git
   ```
config 
```php
require 'onsignal.class.php';
$ONESIGNAL =  new onesignal (
'your app id',
'your app key',
'your app icon',
'your app safari web id',
'your app email'
);
```

send a notification 
```php
$ONESIGNAL -> creatNotification('user ids to get notification','title of the notification','your message','image for notification');
```

cancel a notification 
```php
$ONESIGNAL -> cancelNotification('notification id');
```
get notification history 
```php
print_r($ONESIGNAL -> getHistory());
```
get all user devices
```php
print_r($ONESIGNAL -> getDevices());
```
creat html code to get user id and post to a url using ajax jquery
```php
echo $ONESIGNAL -> createCode(
'url you want to sent a post request with user id',
'post variable for user id',
'if you have ajax.js already included in you scripts use true else use false'
);
```

