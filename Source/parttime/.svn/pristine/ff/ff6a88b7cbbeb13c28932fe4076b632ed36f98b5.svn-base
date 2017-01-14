<!DOCTYPE html>
<!--
* Copyright (C) 2012-2016 Doubango Telecom <http://www.doubango.org>
* License: BSD
* This file is part of Open Source sipML5 solution <http://www.sipml5.org>
-->
<html>
<!-- head -->
<head>
    <meta charset="utf-8" />
    <title>sipML5 live demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="Keywords" content="doubango, sipML5, VoIP, HTML5, WebRTC, RTCWeb, SIP, IMS, Video chat, VP8, live demo " />
    <meta name="Description" content="HTML5 SIP client using WebRTC framework" />
    <meta name="author" content="Doubango Telecom" />
    <script src="../resources/scripts/SIPml-api.js" type="text/javascript"> </script>
    <script type="text/javascript">
            var ext = '<%= Session["EXT"] %>';
            alert(ext); 
            var sipStack;
            var eventsListener = function(e){
                if(e.type == 'started'){
                    login();
                }
                else if(e.type == 'i_new_message'){ // incoming new SIP MESSAGE (SMS-like)
                    acceptMessage(e);
                }
                else if(e.type == 'i_new_call'){ // incoming audio/video call
                    acceptCall(e);
                }
            }
            
            function createSipStack(){
                sipStack = new SIPml.Stack({
                        realm: '115.79.57.172', // mandatory: domain name
                        impi: '104', // mandatory: authorization name (IMS Private Identity)
                        impu: 'sip:104@115.79.57.172', // mandatory: valid SIP Uri (IMS Public Identity)
                        password: '1234ab', // optional
                        display_name: 'Test', // optional
                        enable_rtcweb_breaker: false, // optional
                        outbound_proxy_url: 'udp://115.79.57.172:5060', // optional
                        events_listener: { events: '*', listener: eventsListener }, // optional: '*' means all events
                        sip_headers: [ // optional
                                { name: 'User-Agent', value: 'IM-client/OMA1.0 sipML5-v1.0.0.0' },
                                { name: 'Organization', value: 'Nhilong.com' }
                        ]
                    }
                );
            }

            var readyCallback = function(e){
                createSipStack(); // see next section
            };
            var errorCallback = function(e){
                console.error('Failed to initialize the engine: ' + e.message);
            }
            SIPml.init(readyCallback, errorCallback);
            sipStack.start();
            var registerSession;
            var login = function(){
                registerSession = sipStack.newSession('register', {
                    events_listener: { events: '*', listener: eventsListener } // optional: '*' means all events
                });
                registerSession.register();
            }
            var acceptCall = function(e){
                var callerID = e.newSession.o_session.o_uri_from.s_user_name;
                if (callerID.length > 2) {
                    window.open("http://ql.nhilong.com/popup/makhach.php?phone=" + callerID, '_blank');
                }
            }
    </script>
</head>
<body>
</body>
