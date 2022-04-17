<?php
class onesignal{
    private $APP_ID;
    private $APP_KEY;
    private $APP_ICON;
    private $APP_EMAIL;
    private $APP_SAFARI_WEB_ID;

    public function __construct($APP_ID,$KEY,$ICON,$SAFARI_WEB_ID,$EMAIL){
        $this->APP_ID = $APP_ID;
        $this->APP_KEY = $KEY;
        $this->APP_ICON = $ICON;
        $this->APP_SAFARI_WEB_ID = $SAFARI_WEB_ID;
        $this->APP_EMAIL = $EMAIL;
    }
    public function sendImageMessage($IDS,$title,$msg,$img,$url){
        $content = array(
            "en" => $msg
        );
        
        $headings = array(
            "en" => $title
        );
        
        $fields = array(
            'app_id' => $this->APP_ID,
            'include_player_ids' => $IDS,
            'data' => array("foo" => "bar"),
            "headings" => $headings,
            'contents' => $content,
            'url' => $url,
            'chrome_web_image' => $img
        );
        
        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        //print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    public function sendMessage($IDS,$title,$msg,$url){
        $content = array(
            "en" => $msg
        );
        
        $headings = array(
            "en" => $title
        );
        
        $fields = array(
            'app_id' => $this->APP_ID,
            'include_player_ids' => $IDS,
            'data' => array("foo" => "bar"),
            "headings" => $headings,
            'url' => $url,
            'contents' => $content
        );
        
        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        //print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
    
    public function createCode($END_POINT,$VARIABLE,$AJAX_STATUS){ 
        $APP_ID = $this->$APP_ID;
        $APP_SAFARI_WEB_ID = $this->$APP_SAFARI_WEB_ID;
        if($AJAX_STATUS == false){
            $CODE = "
            <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
            <script>
            window.OneSignal = window.OneSignal || [];
            OneSignal.push(function() {
                OneSignal.init({
                appId: '$APP_ID',
                safari_web_id: 'web.onesignal.auto.$APP_SAFARI_WEB_ID',
                notifyButton: {
                    enable: true,
                },
                });
            });
            OneSignal.push(function() {
                OneSignal.isPushNotificationsEnabled(function(isEnabled) {
                    if (isEnabled)
                    {
                        OneSignal.push(function() {
                        OneSignal.getUserId(function(userId) {
                            $.ajax({
                                type:'POST',
                                url:'$END_POINT',
                                data:{
                                    $VARIABLE:userId,
                                }
                            });    
                        });
                            
                        OneSignal.getUserId().then(function(userId) {
                            $.ajax({
                                type:'POST',
                                url:'$END_POINT',
                                data:{
                                    $VARIABLE:userId,
                                }
                            });   
                        });
                    });
                    console.log('Push notifications are enabled!');
                    }
                    else
                    {
                        console.log('Push notifications are not enabled yet.'); 
                    }   
                });
                        
                OneSignal.isPushNotificationsEnabled().then(function(isEnabled) {
                    if (isEnabled)
                    console.log('Push notifications are enabled!');
                    else
                    {
                        console.log('Push notifications are not enabled yet.'); 
                    }     
                });
            });
            </script>
            ";
        }else{
            $CODE = "
            <script>
            window.OneSignal = window.OneSignal || [];
            OneSignal.push(function() {
                OneSignal.init({
                appId: '$APP_ID',
                safari_web_id: 'web.onesignal.auto.$APP_SAFARI_WEB_ID',
                notifyButton: {
                    enable: true,
                },
                });
            });
            OneSignal.push(function() {
                OneSignal.isPushNotificationsEnabled(function(isEnabled) {
                    if (isEnabled)
                    {
                        OneSignal.push(function() {
                        OneSignal.getUserId(function(userId) {
                            $.ajax({
                                type:'POST',
                                url:'$END_POINT',
                                data:{
                                    $VARIABLE:userId,
                                }
                            });    
                        });
                            
                        OneSignal.getUserId().then(function(userId) {
                            $.ajax({
                                type:'POST',
                                url:'$END_POINT',
                                data:{
                                    $VARIABLE:userId,
                                }
                            });   
                        });
                    });
                    console.log('Push notifications are enabled!');
                    }
                    else
                    {
                        console.log('Push notifications are not enabled yet.'); 
                    }   
                });
                        
                OneSignal.isPushNotificationsEnabled().then(function(isEnabled) {
                    if (isEnabled)
                    console.log('Push notifications are enabled!');
                    else
                    {
                        console.log('Push notifications are not enabled yet.'); 
                    }     
                });
            });
            </script>";
            return $CODE;
        }
    }
}
