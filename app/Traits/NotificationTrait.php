<?php
/**
 * Created by PhpStorm.
 * User: chandan
 * Date: 18/7/17
 * Time: 12:50 PM
 */

namespace App\Traits;

use Log;
use Exception;
use GuzzleHttp\Client as HttpClient;

trait NotificationTrait
{
    public static function logs($value, $array = [])
    {
        Log::info($value, $array);
    }

    public static function exc($cmd)
    {
        self::logs("Executing command: ". $cmd);
        exec($cmd." 2>&1", $output);
        self::logs("Command output: ", $output);
        return $output;
    }

    //----------------------------Slack Variables and Functions-------------------
    private $slack_hook = null;
    private $slack_channel = null;
    private $slack_from = null;

    public function setSlackHook($value = '')
    {
        $this->slack_hook = $value;
    }

    public function getSlackHook()
    {
        return $this->slack_hook ? $this->slack_hook : env('SLACK_WEBHOOK');
    }

    public function setSlackChannel($value = '')
    {
        $this->slack_channel = $value;
    }

    public function getSlackChannel()
    {
        return $this->slack_channel ? $this->slack_channel : env('SLACK_CHANNEL');
    }

    public function setSlackFrom($value = '')
    {
        $this->slack_from = $value;
    }

    public function getSlackFrom()
    {
        return $this->slack_from ? $this->slack_from : env('SLACK_FROM');
    }

    public function slack($text, $attachments = [])
    {
        $channel = $this->getSlackChannel();
        $payload = $this->preparePayload($text, $attachments, $channel);

        try
        {
            $client = new HttpClient();
            $client->request('POST', $this->getSlackHook(),[
                'json' => $payload
            ]);
        }
        catch (Exception $e)
        {
            self::logs("Slack Exception: ". $e->getMessage());
        }
    }

    private function preparePayload($text, $attachments, $channel)
    {
        $payload = ['text' => '['.env("APP_ENV").'] '.$text, 'attachments' => [$attachments], 'channel' => $channel, 'username' => $this->getSlackFrom()];
        return $payload;
    }
}