<?php

class SendinblueCampaign extends SendinblueClass
{
    var $sender;
    var $user;
    var $list;
    var $headers;

    public function __construct(&$plugin, $headers, $sender, $user, $list)
    {
        parent::__construct($plugin, $headers);
        $this->sender = $sender;
        $this->user = $user;
        $this->list = $list;
    }

    public function createNewCampaign($mail)
    {
        $listIdSendinblue = 0;
        $this->list->getListExternalSendingMethod($listIdSendinblue, $mail->id);

        $data = [
            'sender' => $this->sender->getSender($mail),
            'name' => 'AcyMailing Mail '.$mail->id.' ('.$mail->subject.')',
            'htmlContent' => '<html>{% autoescape off %}{{ contact.'.$this->user->getAttributeName($mail->id).' }}{% endautoescape %}</html>',
            'scheduledAt' => date('c', time() + 60),
            'subject' => $mail->subject,
            'replyTo' => $this->sender->getReplyToEmail($mail),
            'recipients' => [
                'listIds' => [$listIdSendinblue],
            ],
            'footer' => '<span style="display: none !important;">{here}</span>',
            'inlineImageActivation' => !empty($this->config->get('embed_images', 0)),
        ];

        $this->callApiSendingMethod('emailCampaigns', $data, $this->headers, 'POST');
    }

    public function cleanCampaigns()
    {
        $cleanFrequency = $this->config->get(plgAcymSendinblue::SENDING_METHOD_ID.'_clean_frequency', 2592000);
        $lastClean = $this->config->get(plgAcymSendinblue::SENDING_METHOD_ID.'_last_clean', 0);

        $time = time();

        if (!empty($lastClean) && $lastClean < ($time + $cleanFrequency)) return true;

        $response = $this->callApiSendingMethod(
            plgAcymSendinblue::SENDING_METHOD_API_URL.'emailCampaigns?status=sent&limit=500&offset=0&sort=desc',
            [],
            $this->headers
        );

        if (empty($response['campaigns'])) return true;

        $startSendDate = date('c', $time - $cleanFrequency);

        foreach ($response['campaigns'] as $campaign) {
            $sendDate = strtotime($campaign['sentDate']);
            if ($sendDate > $startSendDate) continue;

            preg_match('#AcyMailing Mail ([0-9]+)#is', $campaign['name'], $match);
            if (empty($match)) continue;

            $id = intval($match[1]);

            if(empty($id)) continue;

            $this->user->deleteAttribute($id);
            $this->list->deleteList($id);
            $this->deleteCampaign($campaign['id']);
        }

        return true;
    }

    public function deleteCampaign($sendinblueCampaignId)
    {
        $this->callApiSendingMethod(plgAcymSendinblue::SENDING_METHOD_API_URL.'emailCampaigns/'.$sendinblueCampaignId, [], $this->headers, 'DELETE');
    }
}
