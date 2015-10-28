<?php
    require_once(INCLUDE_DIR.'class.signal.php');
    require_once(INCLUDE_DIR.'class.plugin.php');
    require_once('config.php');

    class WebApiPlugin extends Plugin
    {
        var $config_class = "WebApiPluginConfig";

        function bootstrap()
        {
            Signal::connect('model.created', array($this, 'onThreadEntry'), 'ThreadEntry');
        }

        function onThreadEntry($threadEntry)
        {

            if ($threadEntry->getType() == "N") return; //system entry

            $ticket = Ticket::lookup($threadEntry->ht['ticket_id']);

            $recip = $ticket->getRecipients();

            // conntact api for each recipient
            foreach ($recip as $user) {

                //skip thread entry creator
                if ($threadEntry->getUserId() == $user->getId()) continue;

                //$fields = $this->getConfig()->get('webapi-fields');

                try {
                    //format Your payload as Your api need
                    $payload = array(
                        'method' => 'addNotification',
                        'params' =>
                        array(
                            'ticketID' => $ticket->getId(),
                            'title' => $ticket->getSubject(),
                            'value' => $threadEntry->getBody(),
                            'poster' => $threadEntry->getPoster(),
                        )
                    );

                    $data_string = utf8_encode(json_encode($payload));
                    $url         = $this->getConfig()->get('webapi-url');

                    $ch      = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array(
                        'Content-Type: application/json',
                        'Content-Length: '.strlen($data_string))
                    );
                    $content = curl_exec($ch);
                    if ($content === false) {
                        throw new Exception($url.' - '.curl_error($ch));
                    } else {

                        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        if ($statusCode != '200') {
                            throw new Exception($url.' Http code: '.$statusCode);
                        }
                    }
                    curl_close($ch);
                } catch (Exception $e) {
                    error_log('Error posting to Web API. '.$e->getMessage());
                }
            }
        }
    }