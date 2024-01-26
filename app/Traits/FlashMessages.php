<?php

namespace App\Traits;

/**
 * Trait FlashMessages
 * @package App\Traits
 */
trait FlashMessages
{
    protected $errorMessages = [];
    protected $infoMessages = [];
    protected $successMessages = [];
    protected $warningMessages = [];
    /**
     * @param $message
     * @param $type
     */
    protected function setFlashMessage($message, $type)
    {
        $messageTypes = [
            'info' => 'infoMessages',
            'error' => 'errorMessages',
            'success' => 'successMessages',
            'warning' => 'warningMessages',
        ];

        $model = $messageTypes[$type] ?? 'infoMessages';

        if (is_array($message)) {
            $this->$model = array_merge($this->$model, $message);
        } else {
            $this->$model[] = $message;
        }
    }

    protected function getFlashMessage()
    {
        return [
            'error' => $this->errorMessages,
            'info' => $this->infoMessages,
            'success' => $this->successMessages,
            'warning' => $this->warningMessages
        ];
    }
    /**
     * Flushing flash messages to Laravel's session
     */
    protected function showFlashMessages()
    {
        $flashMessages = [
            'error' => $this->errorMessages,
            'info' => $this->infoMessages,
            'success' => $this->successMessages,
            'warning' => $this->warningMessages
        ];

        session()->flash($flashMessages);
    }
}
